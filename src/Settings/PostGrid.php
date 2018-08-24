<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings;

use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\InitializableInterface;
use RuntimeException;
use function App\sage;

/**
 * Custom Post Grid for the theme builder.
 */
class PostGrid implements InitializableInterface
{
    private const NOT_FOUND = 'not found';

    public static function init(): void
    {
        // Filters.
        add_filter('fl_builder_register_settings_form', static::class . '::postGridSettings', 10, 2);
        add_filter('fl_builder_posts_module_layout_path', static::class . '::loadLayoutPath', 10, 3);
    }

    /**
     * Adds custom settings to the Posts module.
     *
     * @param array  $form
     * @param string $slug
     *
     * @return array
     */
    public static function postGridSettings($form, $slug): array
    {
        if ('post-grid' !== $slug) {
            return $form;
        }

        $form['layout']['sections']['general']['fields']['layout']['options']['theme'] = __('Theme', 'fl-builder');
        $form['layout']['sections']['general']['fields']['layout']['toggle']['theme'] = [
            'sections' => [
                'posts',
            ],
            'fields' => [
                'match_height',
                'show_filter',
                'show_cat_desc',
            ],
        ];
        $form['layout']['sections']['general']['fields']['show_filter'] = [
            'type' => 'select',
            'label' => __('Show filter bar?', 'fabric'),
            'default' => '1',
            'options' => [
                '1' => __('Yes', 'fl-builder'),
                '0' => __('No', 'fl-builder'),
            ],
            'toggle' => [
                '0' => [],
                '1' => [
                    'sections' => ['filter_bar'],
                ],
            ],
        ];
        $form['layout']['sections']['info']['fields']['date_format']['options']['l jS F'] = date('l jS F');
        $form['layout']['sections']['filter_bar'] = [
            'title' => __('Filter bar', 'fabric'),
            'fields' => [
                'auto_filter' => [
                    'type' => 'select',
                    'label' => __('Auto filter?', 'fabric'),
                    'default' => '1',
                    'options' => [
                        '1' => __('Yes', 'fl-builder'),
                        '0' => __('No', 'fl-builder'),
                    ],
                ],
                'show_button' => [
                    'type' => 'select',
                    'label' => __('Show submit button?', 'fabric'),
                    'default' => '1',
                    'options' => [
                        '0' => __('No', 'fabric'),
                        '1' => __('Yes', 'fabric'),
                    ],
                ],
                'show_search_filter' => [
                    'type' => 'select',
                    'label' => __('Show search box?', 'fabric'),
                    'default' => '1',
                    'options' => [
                        '1' => __('Yes', 'fl-builder'),
                        '0' => __('No', 'fl-builder'),
                    ],
                ],
                'show_meta_filters' => [
                    'type' => 'select',
                    'label' => __('Show field filters?', 'fabric'),
                    'default' => '1',
                    'options' => [
                        '1' => __('Yes', 'fl-builder'),
                        '0' => __('No', 'fl-builder'),
                    ],
                ],
                'show_cat_desc' => [
                    'type' => 'select',
                    'label' => __('Show category description?', 'fabric'),
                    'default' => '1',
                    'options' => [
                        '1' => __('Yes', 'fl-builder'),
                        '0' => __('No', 'fl-builder'),
                    ],
                ],
                'show_cat_filter' => [
                    'type' => 'select',
                    'label' => __('Show category dropdown?', 'fabric'),
                    'default' => '1',
                    'options' => [
                        '1' => __('Yes', 'fl-builder'),
                        '0' => __('No', 'fl-builder'),
                    ],
                ],
            ],
        ];

        return $form;
    }

    public static function loadLayoutPath($path, $layout, $settings)
    {
        if ('theme' !== $layout) {
            return $path;
        }

        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        return self::templatePath(
            $helper->getPostGridTemplateDir(),
            'post-theme',
            get_post_type() ?: $settings->post_type
        );
    }

    private static function templatePath(string $dir, string $prefix, string $postType): string
    {
        $dir = untrailingslashit($dir);
        $prefix = untrailingslashit($prefix);

        $paths = [
            "$dir/$prefix-$postType.blade.php",
            "$dir/$prefix-$postType.php",
            "$dir/$prefix.blade.php",
            "$dir/$prefix.php",
            __DIR__ . "/../post-grid/$prefix-$postType.blade.php",
            __DIR__ . "/../post-grid/$prefix-$postType.php",
            __DIR__ . "/../post-grid/$prefix.blade.php",
            __DIR__ . "/../post-grid/$prefix.php",
        ];

        $path = array_first($paths, function (string $path): bool {
            return file_exists($path);
        }, self::NOT_FOUND);

        if (self::NOT_FOUND === $path) {
            throw new RuntimeException('Template not found in ' . implode(', ', $paths));
        }

        if (ends_with($path, '.blade.php')) {
            /** @var AbstractHelper $helper */
            $helper = sage(AbstractHelper::class);
            $path = $helper->templatePath($path);
        }

        return $path;
    }

    public static function filterBar($settings): string
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        ob_start();

        // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
        $show_filter = false;
        $tax_exists = false;

        $postType = $settings->post_type ?? null;
        if ('main_query' === $settings->data_source) {
            $postType = get_post_type();
        }
        if (empty($postType)) {
            $postType = 'post';
        }

        if ($settings->show_filter) {
            // Get the taxonomy name.
            if ('post' === $postType) {
                $category = 'category';
            } elseif ('product' === $postType) {
                $category = 'product_cat';
            } else {
                $category = $postType . '_category';
            }
            // Check if the taxonomy exists.
            $tax_exists = taxonomy_exists($category);
            // Whether or not to show the filter.
            $show_filter = $tax_exists ? true : false;
            // Get the Term ID to filter by from $_GET['pc'].
            $term_id = $helper->getCat(true, $category, true);
            // Change the category if it is valid.
            if (! empty($term_id)) {
                $settings->{'tax_' . $postType . '_' . $category} = $term_id;
            }
        }

        $path = self::templatePath(
            $helper->getPostGridTemplateDir(),
            'filter-bar',
            $postType
        );

        // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.IncludingFile
        include $path;

        return ob_get_clean();
    }
}

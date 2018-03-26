<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings;

use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\InitializableInterface;
use function App\sage;

/**
 * Custom Post Grid for the theme builder.
 */
class PostGrid implements InitializableInterface
{
    protected const DIR = __DIR__;

    public static function init(): void
    {
        // Filters
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
                'show_search' => [
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
            ],
        ];

        return $form;
    }

    /**
     * Renders custom CSS for the post grid module.
     *
     * @param string $css
     * @param array  $nodes
     *
     * @return string
     */
    public static function postGridCSS($css, $nodes)
    {
        $globalIncluded = false;

        foreach ($nodes['modules'] as $module) {
            if (! is_object($module)) {
                continue;
            }

            if ('post-grid' !== $module->settings->type) {
                continue;
            }

            if (! $globalIncluded) {
                $globalIncluded = true;
                $css .= file_get_contents(FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'css/fl-theme-builder-post-grid-woocommerce.css');
            }

            ob_start();
            $id = $module->node;
            $settings = $module->settings;
            include FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'includes/post-grid-woocommerce.css.php';
            $css .= ob_get_clean();
        }

        return $css;
    }

    public static function loadLayoutPath($path, $layout, $settings)
    {
        if ('theme' !== $layout) {
            return $path;
        }

        $post_type = get_post_type() ?: $settings->post_type;
        $path = static::DIR . "/../Modules/post-grid/includes/post-theme-{$post_type}.php";

        if (! file_exists($path)) {
            $path = static::DIR . '/../Modules/post-grid/includes/post-theme.php';
        }

        return $path;
    }

    public static function filterBar($settings): string
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        ob_start();

        $show_filter = false;
        $tax_exists = false;
        $post_type = 'main_query' === $settings->data_source ? (get_post_type() ?: 'post') : $settings->post_type;
        if ($settings->show_filter) {
            // Get the taxonomy name.
            $category = ('post' === $post_type) ? 'category' : $post_type . '_cat';
            // Check if the taxonomy exists.
            $tax_exists = taxonomy_exists($category);
            // Whether or not to show the filter.
            $show_filter = $tax_exists ? true : false;
            // Get the Term ID to filter by from $_GET['cat'].
            $term_id = $helper->getCat(true, $category, true);
            // Change the category if it is valid.
            if (! empty($term_id)) {
                $settings->{'tax_' . $post_type . '_' . $category} = $term_id;
            }
        }

        $path = static::DIR . "/../Modules/post-grid/includes/filter-bar-{$post_type}.php";
        if (! file_exists($path)) {
            $path = static::DIR . '/../Modules/post-grid/includes/filter-bar.php';
        }

        include $path;

        return ob_get_clean();
    }
}

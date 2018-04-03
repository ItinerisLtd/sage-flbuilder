<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use Itineris\SageFLBuilder\Settings\PostGrid;
use WP_Query;
use function App\sage;

/**
 * TODO: This class needs refactor!
 * TODO: The final goal is to remove this class.
 */
class God implements InitializableInterface
{
    public static function init(): void
    {
        $god = new static();

        add_action('fl_builder_posts_module_after_pagination', [$god, 'noPostsFilterBar'], 10, 2);

        add_filter('fl_builder_loop_settings', [$god, 'forceEventPostType']);
        // TODO: Is `PHP_INT_MAX` necessary?
        add_filter('fl_theme_builder_template_include', [$god, 'loadPageBladeTemplate'], PHP_INT_MAX, 2);
        add_filter('fl_builder_render_module_content', [$god, 'wrapRichText'], 10, 2);
        add_filter('fl_builder_module_frontend_custom_fab_filter_bar', [$god, 'filterBarFrontend']);
    }

    /**
     * TODO: Do I deserve a class?
     *
     * Warning: This is a slow database query!
     *
     * @param $postType
     *
     * @return array
     */
    public static function flGetLocations($postType): array
    {
        $locations = [];
        $locQuery = new WP_Query([
            'post_type' => $postType,
            'meta_key' => 'location',
            'meta_query' => [
                [
                    'key' => 'location',
                    'value' => '',
                    'compare' => '!=',
                ],
            ],
        ]);

        if ($locQuery->have_posts()) {
            while ($locQuery->have_posts()) {
                $locQuery->the_post();
                $location = get_field('location', get_the_ID());
                if (! array_key_exists($location, $locations)) {
                    $locations[esc_attr($location)] = $location;
                }
            }
        }

        wp_reset_postdata();

        return $locations;
    }

    /**
     * TODO: Do I deserve a class?
     */
    public static function flGetFilterCount($settings): int
    {
        $count = 0;
        if (! $settings->show_filter) {
            return $count;
        }
        if ($settings->show_search) {
            $count++;
        }
        if ($settings->show_meta_filters) {
            $count++;
        }

        return $count;
    }

    /**
     * TODO: Do I deserve a class?
     */
    public function forceEventPostType($settings)
    {
        if ('fab_events_carousel' === $settings->type) {
            $settings->post_type = 'event';
        }

        return $settings;
    }

    /**
     * TODO: Review if/else conditions.
     * TODO: Is `$type` dead?
     */
    public function loadPageBladeTemplate($template, $ids)
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        $type = get_post_meta($ids, '_fl_theme_layout_type', true);
        $post_type = get_post_type();
        if ('fl-theme-layout' === $post_type || $this->isWoocommerce()) {
            $template = $helper->templatePath($helper->locateTemplate('woocommerce/fl-builder-woocommerce'));
        } elseif ('fl-theme-layout' === $post_type || is_home() || is_archive()) {
            $template = $helper->templatePath($helper->locateTemplate('fl-builder-archive'));
        }

        return $template;
    }

    private function isWoocommerce(): bool
    {
        return function_exists('is_woocommerce') && is_woocommerce();
    }

    /**
     * TODO: Do I deserve a class?
     */
    public function wrapRichText($out, $module): string
    {
        if ('rich-text' !== $module->slug) {
            return $out;
        }

        return '<div class="content">' . $out . '</div>';
    }

    /**
     * TODO: Inconsistent text domain.
     */
    public function registerSettingsForm($form, $id)
    {
        if ('post-grid' !== $id) {
            return $form;
        }

        $newOption = [
            'layout' => [
                'sections' => [
                    'general' => [
                        'fields' => [
                            'layout' => [
                                'options' => [
                                    'theme' => __('Theme', 'fl-builder'),
                                ],
                                'toggle' => [
                                    'theme' => [
                                        'fields' => [
                                            'show_filter',
                                            'auto_filter',
                                            'show_search',
                                            'show_meta_filters',
                                            'show_cat_desc',
                                        ],
                                    ],
                                ],
                            ],
                            'show_filter' => [
                                'type' => 'select',
                                'label' => __('Show filter bar?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                                'toggle' => [
                                    '1' => [
                                        'fields' => [
                                            'auto_filter',
                                            'show_button',
                                            'show_search',
                                            'show_meta_filters',
                                            'show_cat_desc',
                                        ],
                                    ],
                                ],
                            ],
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
                    ],
                ],
            ],
        ];

        return array_merge_recursive($form, $newOption);
    }

    /**
     * TODO: Am I dead?
     */
    public function loadProductMarkupAfterPosts($settings): void
    {
        if ('theme' !== $settings->layout) {
            return;
        }

        $postType = get_post_type() ?: $settings->post_type;
        if ('product' !== $postType) {
            return;
        }

        echo '</ul></div></div>';
    }

    /**
     * TODO: Am I belong to class `PostGrid` or `FilterBar`?
     */
    public function filterBarFrontend($settings): string
    {
        $settings['show_filter'] = true;
        $settings['layout'] = 'theme';

        return sage(PostGrid::class)->filterBar((object) $settings);
    }

    /**
     * TODO: Am I belong to class `PostGrid` or `FilterBar`?
     */
    public function noPostsFilterBar($settings, $query): void
    {
        if ($query->have_posts()) {
            return;
        }

        $settings->show_filter = true;
        $settings->layout = 'theme';

        echo sage(PostGrid::class)->filterBar($settings);
    }
}

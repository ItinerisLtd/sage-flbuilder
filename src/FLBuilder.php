<?php

namespace Itineris\SageFLBuilder;

use Itineris\SageFLBuilder\Settings\EventsArchive;
use Itineris\SageFLBuilder\Settings\PostGrid;
use Itineris\SageFLBuilder\Settings\ProductsArchive;

/**
 * Beaver Builder extensions
 */
class FLBuilder
{

    public function __construct()
    {
        define('FAB_FL_MODULE_DIR', __DIR__ . '/FLBuilder/Modules/');
        define('FAB_FL_MODULE_CAT', 'Custom Widgets');
        define('FAB_FL_MODULE_GROUP', 'Itineris Standard Modules');

        add_action('init', [$this, 'loadWidgets'], 99);
        add_filter('fl_builder_loop_settings', [$this, 'forceEventPostType']);

        PostGrid::init();
        EventsArchive::init();
        ProductsArchive::init();
        add_filter('fl_theme_builder_template_include', [$this, 'loadPageBladeTemplate'], PHP_INT_MAX, 2);
        add_filter('fl_builder_module_frontend_file', [$this, 'locateTemplate'], 10, 2);
        add_filter('fl_builder_render_module_content', [$this, 'wrapRichText'], 10, 2);
        add_filter('fl_builder_module_frontend_custom_fab_filter_bar', [$this, 'filterBarFrontend'], 10, 2);

        add_action('fl_builder_posts_module_after_pagination', [$this, 'noPostsFilterBar'], 10, 2);
    }

    public function loadWidgets()
    {
        foreach (new \DirectoryIterator(FAB_FL_MODULE_DIR) as $widgets) {
            if ($widgets->isDot()) {
                continue;
            }
            foreach ($widgets as $widget) {
                $filename = $widget->getFilename();
                if ($widget->isDot() || 'post-grid' === $filename) {
                    continue;
                }
                require_once FAB_FL_MODULE_DIR . "{$filename}/{$filename}.php";
            }
        }
    }

    public function enqueueAdminAssets()
    {
        if (class_exists('FLBuilderModel') && \FLBuilderModel::is_builder_active()) {
            wp_enqueue_script('fabric-admin', FAB_ADMIN_ASSETS . '/js/admin.js', [ 'jquery' ], '1.0.0', true);
            wp_localize_script(
                'fabric-admin',
                'fabric_admin',
                [
                    'assets'        => FAB_ASSETS,
                    'admin_assets'  => FAB_ADMIN_ASSETS
                ]
            );
        }
    }

    public function forceEventPostType($settings)
    {
        if ('fab_events_carousel' === $settings->type) {
            $settings->post_type = 'event';
        }
        return $settings;
    }

    public function loadPageBladeTemplate($template, $ids)
    {
        $type = get_post_meta($ids, '_fl_theme_layout_type', true);
        $post_type = get_post_type();
        if (is_woocommerce() || 'fl-theme-layout' == $post_type) {
            $template = \App\template_path(\App\locate_template('woocommerce/fl-builder-woocommerce'));
        } elseif ((is_home() || is_archive()) || 'fl-theme-layout' == $post_type) {
            $template = \App\template_path(\App\locate_template('fl-builder-archive'));
        }
        return $template;
    }

    /**
     * Add Laravel Blade support for frontend.php
     *
     * @param $file
     * @param $module
     *
     * @return string
     */
    public function locateTemplate($file, $module)
    {
        $relfilepath = get_relative_bb_path($module, 'frontend', 'module');
        $path = \App\locate_template("../{$relfilepath}");
        $file = $path ? \App\template_path($path) : $file;
        return $file;
    }

    public function wrapRichText($out, $module)
    {
        if ('rich-text' === $module->slug) {
            $out = '<div class="content">'.$out.'</div>';
        }
        return $out;
    }

    public function registerSettingsForm($form, $id)
    {
        if ('post-grid' === $id) {
            $new_option = [
                'layout'        => [
                    'sections'      => [
                        'general'       => [
                            'fields'        => [
                                'layout'        => [
                                    'options'       => [
                                        'theme'       => __('Theme', 'fl-builder'),
                                    ],
                                    'toggle'        => [
                                        'theme'         => [
                                            'fields'        => [
                                                'show_filter',
                                                'auto_filter',
                                                'show_search',
                                                'show_meta_filters',
                                                'show_cat_desc',
                                            ]
                                        ]
                                    ]
                                ],
                                'show_filter'   => [
                                    'type'          => 'select',
                                    'label'         => __('Show filter bar?', 'fabric'),
                                    'default'       => '1',
                                    'options'       => [
                                        '1'             => __('Yes', 'fl-builder'),
                                        '0'             => __('No', 'fl-builder')
                                    ],
                                    'toggle'        => [
                                        '1'             => [
                                            'fields'        => [
                                                'auto_filter',
                                                'show_button',
                                                'show_search',
                                                'show_meta_filters',
                                                'show_cat_desc'
                                            ]
                                        ]
                                    ]
                                ],
                                'auto_filter'   => [
                                    'type'          => 'select',
                                    'label'         => __('Auto filter?', 'fabric'),
                                    'default'       => '1',
                                    'options'       => [
                                        '1'             => __('Yes', 'fl-builder'),
                                        '0'             => __('No', 'fl-builder')
                                    ]
                                ],
                                'show_button'   => [
                                    'type'          => 'select',
                                    'label'         => __('Show submit button?', 'fabric'),
                                    'default'       => '1',
                                    'options'       => [
                                        '0'             => __('No', 'fabric'),
                                        '1'             => __('Yes', 'fabric'),
                                    ],
                                ],
                                'show_search'   => [
                                    'type'          => 'select',
                                    'label'         => __('Show search box?', 'fabric'),
                                    'default'       => '1',
                                    'options'       => [
                                        '1'             => __('Yes', 'fl-builder'),
                                        '0'             => __('No', 'fl-builder')
                                    ]
                                ],
                                'show_meta_filters'  => [
                                    'type'                  => 'select',
                                    'label'                 => __('Show field filters?', 'fabric'),
                                    'default'               => '1',
                                    'options'               => [
                                        '1'                     => __('Yes', 'fl-builder'),
                                        '0'                     => __('No', 'fl-builder')
                                    ]
                                ],
                                'show_cat_desc' => [
                                    'type'          => 'select',
                                    'label'         => __('Show category description?', 'fabric'),
                                    'default'       => '1',
                                    'options'       => [
                                        '1'             => __('Yes', 'fl-builder'),
                                        '0'             => __('No', 'fl-builder')
                                    ]
                                ],
                            ],
                        ],
                    ],
                ]
            ];
            $form = array_merge_recursive($form, $new_option);
        }
        return $form;
    }

    public static function flGetLocations($post_type)
    {
        $locations = [];
        $loc_query = new \WP_Query([
            'post_type' => $post_type,
            'meta_key'  => 'location',
            'meta_query'    => [
                [
                    'key'   => 'location',
                    'value' => '',
                    'compare'   => '!=',
                ]
            ]
        ]);
        if ($loc_query->have_posts()) {
            while ($loc_query->have_posts()) {
                $loc_query->the_post();
                $location = get_field('location', get_the_ID());
                if (!array_key_exists($location, $locations)) {
                    $locations[esc_attr($location)] = $location;
                }
            }
        }
        wp_reset_postdata();
        return $locations;
    }

    public static function flGetFilterCount($settings)
    {
        $count = 0;
        if (!$settings->show_filter) {
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

    public function loadProductMarkupAfterPosts($settings, $query)
    {
        if ('theme' === $settings->layout) {
            $post_type = get_post_type() ?: $settings->post_type;
            $html = '';
            if ('product' === $post_type) {
                $html = '</ul></div></div>';
            }
            echo $html;
        }
    }

    public function filterBarFrontend($settings, $module)
    {
        $settings['show_filter'] = true;
        $settings['layout'] = 'theme';
        return PostGrid::filterBar((object) $settings);
    }

    public function noPostsFilterBar($settings, $query)
    {
        if (!$query->have_posts()) {
            $settings->show_filter = true;
            $settings->layout = 'theme';
            echo PostGrid::filterBar($settings);
        }
    }
}

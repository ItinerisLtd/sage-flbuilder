<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings;

use DateTime;
use Exception;
use Itineris\SageFLBuilder\InitializableInterface;
use TypeError;

/**
 * Custom Post Grid for the theme builder.
 */
class EventsArchive implements InitializableInterface
{
    public static function init(): void
    {
        // Actions
        add_action('fl_builder_posts_module_before_posts', static::class . '::beforePosts', 10, 2);
        add_action('fl_builder_posts_module_before_posts', static::class . '::beforePostsItemsWrap', 11, 2);
        add_action('fl_builder_posts_module_after_posts', static::class . '::afterPosts', 10, 2);
        add_action('fl_builder_posts_module_after_posts', static::class . '::afterPostsItemsWrap', 11, 2);
        add_action('pre_get_posts', static::class . '::modifyQuery');

        // Filters
        add_filter('fl_builder_module_custom_class', static::class . '::customClass', 10, 2);
        add_filter('fl_builder_register_settings_form', static::class . '::postGridSettings', 10, 2);
        add_filter('fl_builder_render_js', static::class . '::postGridJS', 10, 2);
    }

    public static function eventDate($format): void
    {
        if ('default' === $format) {
            the_field('event_start');
            return;
        }

        $date = get_field('event_start', false, false);

        try {
            $dateObj = new DateTime($date);
            echo $dateObj->format($format);
        } catch (TypeError | Exception $e) {
            // Do nothing.
        }
    }

    public static function beforePosts($settings, $query): void
    {
        if ('event' === $query->query_vars['post_type'] ?? null) {
            echo '<div class="container">';
            if (! empty($settings->section_title)) {
                echo '<h2>' . esc_html($settings->section_title) . '</h2>';
            }
        }
    }

    public static function beforePostsItemsWrap($settings, $query): void
    {
        if ('event' === $query->query_vars['post_type'] ?? null) {
            echo '<div class="events">';
        }
    }

    public static function afterPosts($settings, $query): void
    {
        if ('event' === $query->query_vars['post_type'] ?? null) {
            echo '</div>';
        }
    }

    public static function afterPostsItemsWrap($settings, $query): void
    {
        if ('event' === $query->query_vars['post_type'] ?? null) {
            echo '</div><!-- ./events -->';
            echo '<footer class="fl-builder-pagination-load-more btn-row hidden-xs">';
            echo '<a href="#" class="fl-button btn btn-sm btn-info">Load More</a>';
            echo '</footer>';
        }
    }

    public static function customClass($class, $module)
    {
        if ('post-grid' === $module->slug && 'event' === get_post_type()) {
            $class .= ' upcoming-events';
        }

        return $class;
    }

    public static function modifyQuery($query)
    {
        if (! is_admin() &&
            'event' === $query->get('post_type') &&
            $query->is_archive &&
            (
                $query->is_main_query() ||
                (isset($query->query['fl_builder_loop']) && $query->query['fl_builder_loop'])
            )
        ) {
            if (! isset($query->query['settings']->type) || 'post-grid' === $query->query['settings']->type) {
                $query->set('posts_per_page', 2); // TODO: remove when fixed
            }
        }

        return $query;
    }

    public static function fixInfiniteScroll($query)
    {
        $query->set('post_type', 'fl-theme-layout');
        $query->set('is_single', true);
        $query->is_single = true;
        $query->set('is_singular', true);
        $query->is_singular = true;
        $query->set('is_page', false);
        $query->is_page = false;

        return $query;
    }

    /**
     * Adds custom settings to the Posts module.
     *
     * @param array  $form
     * @param string $slug
     *
     * @return array
     */
    public static function postGridSettings($form, $slug)
    {
        if ('post-grid' !== $slug) {
            return $form;
        }

        $form['layout']['sections']['general']['fields']['layout']['options']['theme'] = __('Theme', 'fl-builder');
        $form['layout']['sections']['general']['fields']['layout']['toggle']['theme'] = [
            'fields' => [
                'section_title',
                'show_filter',
                'show_cat_desc',
            ],
        ];
        $form['layout']['sections']['general']['fields']['section_title'] = [
            'type' => 'text',
            'label' => __('Section title', 'fabric'),
            'default' => 'Upcoming Events',
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
    public static function postGridCSS($css, $nodes): string
    {
        foreach ($nodes['modules'] as $module) {
            if (! is_object($module)) {
                continue;
            }

            if ('post-grid' !== $module->settings->type) {
                continue;
            }

            $css .= file_get_contents(FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'css/fl-theme-builder-post-grid-woocommerce.css');

            $id = $module->node;
            $settings = $module->settings;

            ob_start();
            include FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'includes/post-grid-woocommerce.css.php';
            $css .= ob_get_clean();

            return $css;
        }

        return '';
    }

    /**
     * Renders custom JS for the post grid module.
     *
     * @param string $js
     * @param array  $nodes
     *
     * @return string
     */
    public static function postGridJS($js, $nodes): string
    {
        foreach ($nodes['modules'] as $module) {
            if (! is_object($module)) {
                continue;
            }

            if ('post-grid' !== $module->settings->type) {
                continue;
            }

            $js = str_replace(
                "else if(this.settings.layout == 'gallery') {",
                'else if(this.settings.layout == \'theme\') {
                            $(\'.event-box\').matchHeight();
                            $(\'.event-box .img\').each(function() {
                                var $el = $(this).find(\'> img\');
                                if ($el.length > 0) {
                                    $(this).css(\'background-image\', \'url(\' + $el.attr(\'src\') + \')\');
                                }
                            });
                        }else if(this.settings.layout == \'gallery\') {',
                $js
            );
        }

        return $js;
    }
}

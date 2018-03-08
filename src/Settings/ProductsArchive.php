<?php

namespace Itineris\SageFLBuilder\Settings;

/**
 * Custom Post Grid for the theme builder.
 *
 * @since 1.0
 */
final class ProductsArchive
{

    /**
     * @since 1.0
     * @return void
     */
    public static function init()
    {
        // Actions
        remove_action(
            'fl_builder_posts_module_before_posts',
            'FLThemeBuilderWooCommerceArchive::posts_module_before_posts'
        );
        add_action('fl_builder_posts_module_after_posts', __CLASS__, '::loadProductMarkupAfterPosts', 10, 2);
        add_action('fl_builder_posts_module_before_posts', __CLASS__ . '::loadFilterBar', 11, 2);
        // Filters
    }

    public static function loadProductMarkupAfterPosts($settings)
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

    public static function loadFilterBar($settings, $query)
    {
        if ('theme' === $settings->layout) {
            $html = '';
            $tax_query = $query->get('tax_query');
            $term = isset($tax_query[0]['terms'][0]) && is_numeric($tax_query[0]['terms'][0]) ?
                get_term($tax_query[0]['terms'][0], 'product_cat') : '';
            $cat_title = !empty($term) && !is_wp_error($term) ? $term->name : '';
            $post_type = $query->query_vars['post_type'];
            if ('product' === $post_type) {
                echo '<div class="container">';
                echo '<header class="woocommerce-products-header"><div class="row">';
                echo '<div class="col-sm-8">';
                echo '<h2 class="woocommerce-products-header__title page-title">';
                if (is_product_category()) {
                    single_term_title();
                } else {
                    echo $cat_title;
                }
                echo '</h2>';
                echo '</div>';
                echo '<div class="col-sm-4">';
                \FLThemeBuilderWooCommerceArchive::posts_module_before_posts($settings);
                echo '</div></div></header>';
                echo '<div class="product-row row"><ul class="products">';
            } else {
                if ($settings->show_filter) {
                    $html = PostGrid::filterBar($settings);
                }
                echo $html;
            }
        }
    }
}

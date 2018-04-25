<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings;

use Itineris\SageFLBuilder\InitializableInterface;
use function App\sage;

/**
 * Custom Post Grid for the theme builder.
 */
class ProductsArchive implements InitializableInterface
{
    public static function init(): void
    {
        remove_action(
            'fl_builder_posts_module_before_posts',
            'FLThemeBuilderWooCommerceArchive::posts_module_before_posts'
        );
        add_action('fl_builder_posts_module_after_posts', static::class . '::loadProductMarkupAfterPosts');
        add_action('fl_builder_posts_module_before_posts', static::class . '::loadFilterBar', 11, 2);
    }

    public static function loadProductMarkupAfterPosts($settings): void
    {
        if ('theme' !== $settings->layout) {
            return;
        }

        $postType = get_post_type() ?: $settings->post_type;

        if ('product' === $postType) {
            echo '</ul></div></div>';
        }
    }

    public static function loadFilterBar($settings, $query): void
    {
        if ('theme' !== $settings->layout) {
            return;
        }

        $tax_query = $query->get('tax_query');
        $term = isset($tax_query[0]['terms'][0]) && is_numeric($tax_query[0]['terms'][0]) ?
            get_term($tax_query[0]['terms'][0], 'product_cat') : '';
        $cat_title = ! empty($term) && ! is_wp_error($term) ? $term->name : '';
        $post_type = $query->query_vars['post_type'];
        if ('product' === $post_type) {
            echo '<div class="container">';
            echo '<header class="woocommerce-products-header"><div class="row">';
            echo '<div class="col-sm-8">';
            echo '<h2 class="woocommerce-products-header__title page-title">';
            if (function_exists('is_product_category') && is_product_category()) {
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
        } elseif ($settings->show_filter) {
            FilterBar::render($settings);
        }
    }
}

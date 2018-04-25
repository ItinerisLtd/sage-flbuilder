<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings;

use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\InitializableInterface;
use Itineris\SageFLBuilder\PostGridTemplateFinder;
use WP_Query;
use function App\sage;

class FilterBar implements InitializableInterface
{
    public static function init(): void
    {
        add_action('fl_builder_posts_module_after_pagination', self::class . '::renderNoPosts', 10, 2);
        add_filter('fl_builder_module_frontend_custom_fab_filter_bar', self::class . '::frontendHtml');
    }

    public static function frontendHtml(array $settings): string
    {
        $settings['show_filter'] = true;
        $settings['layout'] = 'theme';

        return self::html((object) $settings);
    }

    public static function html(object $settings): string
    {
        return self::getFromContainer()::toString($settings);
    }

    /**
     * @internal
     *
     * @param object $settings
     *
     * @return string
     */
    public static function toString(object $settings): string
    {
        $settings = (object) $settings;

        $show_filter = false;
        $tax_exists = false;
        $post_type = 'main_query' === $settings->data_source ? (get_post_type() ?: 'post') : $settings->post_type;

        if ($settings->show_filter) {
            // Get the taxonomy name.
            $category = ('post' === $post_type) ? 'category' : $post_type . '_cat';

            // Check if the taxonomy exists.
            $tax_exists = taxonomy_exists($category);

            // Whether or not to show the filter.
            $show_filter = $tax_exists;

            // Get the Term ID to filter by from $_GET['cat'].
            /* @var AbstractHelper $helper */
            $helper = sage(AbstractHelper::class);
            $term_id = $helper->getCat(true, $category, true);

            // Change the category if it is valid.
            if (! empty($term_id)) {
                $settings->{'tax_' . $post_type . '_' . $category} = $term_id;
            }
        }

        $path = PostGridTemplateFinder::templatePath(
            'filter-bar',
            $post_type
        );

        ob_start();

        include $path;

        return ob_get_clean();
    }

    private static function getFromContainer(): FilterBar
    {
        return sage(self::class);
    }

    public static function swap(string $newClass): void
    {
        sage()->bind(self::class, $newClass);
    }

    public static function renderNoPosts(object $settings, WP_Query $query): void
    {
        if ($query->have_posts()) {
            return;
        }

        $settings = (object) $settings;

        $settings->show_filter = true;
        $settings->layout = 'theme';

        self::render($settings);
    }

    public static function render(object $settings): void
    {
        echo self::html($settings);
    }
}

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
        add_filter('fl_builder_module_frontend_custom_FilterBar', [$god, 'filterBarFrontend']);
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
        if (isset($settings->tax_exists) && $settings->tax_exists) {
            $count++;
        }
        if ($settings->show_meta_filters) {
            $count++;
        }
        if (isset($settings->show_role) && $settings->show_role) {
            $count++;
        }

        return $count;
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

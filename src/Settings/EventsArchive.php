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
        add_action('pre_get_posts', static::class . '::modifyQuery');
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
                $query->set('post_parent', 0);
            }
        }

        return $query;
    }
}

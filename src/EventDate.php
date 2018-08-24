<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use DateTime;
use Exception;
use TypeError;

/**
 * Custom Post Grid for the theme builder.
 */
final class EventDate
{
    public static function echo(string $format): void
    {
        if ('default' === $format) {
            the_field('event_start');

            return;
        }

        $date = get_field('event_start', false, false);

        try {
            $dateObj = new DateTime($date);
            echo $dateObj->format($format);

            // See: Automattic/VIP-Coding-Standards#144 on Github.
            // phpcs:ignore
        } catch (TypeError | Exception $exception) {
            // Do nothing.
        }
    }
}

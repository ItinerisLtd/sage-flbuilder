<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\Archives;

use Itineris\SageFLBuilder\InitializableInterface;

final class EventsArchive implements InitializableInterface
{
    public static function init(): void
    {
        $archive = new Archive('event');

        add_action('pre_get_posts', [$archive, 'modifyQuery']);
    }
}

<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings;

use Itineris\SageFLBuilder\InitializableInterface;

final class RichText implements InitializableInterface
{
    public static function init(): void
    {
        add_filter('fl_builder_render_module_content', static::class . '::wrap', 10, 2);
    }

    public static function wrap(string $out, $module): string
    {
        if ('rich-text' !== $module->slug) {
            return $out;
        }

        return '<div class="content">' . $out . '</div>';
    }
}

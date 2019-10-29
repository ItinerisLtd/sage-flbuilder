<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

use Itineris\SageFLBuilder\InitializableInterface;

final class SingleThemeLayout implements InitializableInterface
{
    public static function init(): void
    {
        $themeLayout = new ThemeLayout(function (): bool {
            return is_single();
        }, 'fl-builder-single');

        add_filter('fl_theme_builder_template_include', [$themeLayout, 'locateTemplatePath'], 1000000);
    }
}

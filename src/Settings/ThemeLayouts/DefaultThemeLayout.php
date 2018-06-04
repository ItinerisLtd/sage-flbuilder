<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

use Itineris\SageFLBuilder\InitializableInterface;

final class DefaultThemeLayout implements InitializableInterface
{
    public static function init(): void
    {
        $themeLayout = new ThemeLayout(function (): bool {
            return 'fl-theme-layout' === get_post_type();
        }, 'fl-builder-archive');

        add_filter('fl_theme_builder_template_include', [$themeLayout, 'locateTemplatePath'], 1000020);
    }
}

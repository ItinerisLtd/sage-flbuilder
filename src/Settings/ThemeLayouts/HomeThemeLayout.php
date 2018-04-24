<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

class HomeThemeLayout extends AbstractThemeLayout
{
    protected static function shouldIncludeLayout(): bool
    {
        return is_home();
    }
}

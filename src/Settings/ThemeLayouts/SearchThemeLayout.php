<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

class SearchThemeLayout extends AbstractThemeLayout
{
    protected static function shouldIncludeLayout(): bool
    {
        return is_search();
    }
}

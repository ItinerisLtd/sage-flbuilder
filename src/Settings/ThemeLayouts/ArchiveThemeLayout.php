<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

class ArchiveThemeLayout
{
    protected static function shouldIncludeLayout(): bool
    {
        return is_archive();
    }
}

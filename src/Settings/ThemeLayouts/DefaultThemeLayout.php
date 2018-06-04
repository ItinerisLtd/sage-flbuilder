<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

class DefaultThemeLayout extends AbstractThemeLayout
{
    protected const PRIORITY = parent::PRIORITY + 20;

    protected static function shouldIncludeLayout(): bool
    {
        return 'fl-theme-layout' === get_post_type();
    }
}

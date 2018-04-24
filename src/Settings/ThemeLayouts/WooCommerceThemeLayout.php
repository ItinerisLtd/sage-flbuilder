<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

class WooCommerceThemeLayout extends AbstractThemeLayout
{
    protected const PRIORITY = parent::PRIORITY + 10;
    protected const TEMPLATE = 'woocommerce/fl-builder-woocommerce';

    protected static function shouldIncludeLayout(): bool
    {
        return is_woocommerce();
    }
}

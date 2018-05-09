<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\InitializableInterface;
use function App\sage;

abstract class AbstractThemeLayout implements InitializableInterface
{
    protected const PRIORITY = 1000000;
    protected const TEMPLATE = 'fl-builder-archive';

    public static function init(): void
    {
        add_filter('fl_theme_builder_template_include', static::class . '::locateTemplatePath', static::PRIORITY);
    }

    public static function locateTemplatePath(string $template): string
    {
        if (! static::shouldIncludeLayout()) {
            return $template;
        }

        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        return $helper->templatePath(
            $helper->locateTemplate(static::TEMPLATE)
        );
    }

    abstract protected static function shouldIncludeLayout(): bool;
}

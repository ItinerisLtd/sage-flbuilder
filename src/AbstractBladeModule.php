<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use FLBuilderModule;
use function App\sage;

/**
 * Add Laravel Blade support.
 */
abstract class AbstractBladeModule extends AbstractModule
{
    public static function init(): void
    {
        add_filter('fl_builder_render_module_html', [static::class, 'renderModuleHtml'], 10, 4);
        add_filter('fl_builder_module_frontend_file', [static::class, 'renderFrontendTemplate'], 10, 2);

        parent::init();
    }

    public static function renderModuleHtml(string $file, $_type, $_settings, FLBuilderModule $module): string
    {
        return static::renderFrontendTemplate($file, $module);
    }

    public static function renderFrontendTemplate(string $file, FLBuilderModule $module): string
    {
        if (static::class !== get_class($module)) {
            return $file;
        }

        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);
        $path = $helper->templatePath($module->dir . 'includes/frontend.blade.php');

        echo $helper->template($path);

        return __DIR__ . '/empty.php';
    }
}

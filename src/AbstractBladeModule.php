<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use FLBuilderModule;
use ReflectionClass;
use function App\sage;

abstract class AbstractBladeModule extends AbstractModule
{
    public static function init(): void
    {
        add_filter('fl_builder_module_frontend_file', [static::class, 'locateTemplate'], 10, 2);

        parent::init();
    }

    /**
     * Add Laravel Blade support.
     */
    public static function locateTemplate(string $file, FLBuilderModule $module): string
    {
        if (static::class !== get_class($module)) {
            return $file;
        }

        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        return $helper->templatePath(static::getDirPath() . '/includes/frontend.blade.php');
    }

    /**
     * Warning: `ReflectionClass` is slow.
     * For maximum performance, override this method with `return __DIR__;` in child class.
     *
     * @return string
     */
    protected static function getDirPath(): string
    {
        $classInfo = new ReflectionClass(static::class);
        $classPath = $classInfo->getFileName();

        return dirname($classPath);
    }
}

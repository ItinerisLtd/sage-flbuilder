<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use function Roots\view;
use function Roots\asset;

abstract class AbstractHelper
{
    /**
     * @param string $file
     * @param array  $data
     *
     * @return string
     */
    public function template($file, $data = []): string
    {
        return view($file, $data);
    }

    /**
     * Retrieve path to a compiled blade view
     *
     * @param       $file
     * @param array $data
     *
     * @return string
     */
    public function templatePath($file, $data = []): string
    {
        return view($file, $data)->getCompiled();
    }

    /**
     * @param $asset
     *
     * @return string
     */
    public function assetPath($asset): string
    {
        return asset($asset)->uri();
    }

    public function getModuleGroup(): string
    {
        return __('Itineris Standard Modules', 'fabric');
    }

    /**
     * Per project module group name
     *
     * @return string
     */
    abstract public function getSiteModuleGroup(): string;

    public function getModuleCategory(): string
    {
        return __('Custom Widgets', 'fabric');
    }

    /**
     * @param string|string[] $templates Relative path to possible template files.
     *
     * @return string Location of the template
     */
    abstract public function locateTemplate($templates): string;

    /**
     * Button Styles usable in the cutup
     *
     * @return array
     */
    abstract public function buttonStyles(): array;

    /**
     * @return string|false
     */
    abstract public function breadcrumbs();

    abstract public function getGravityForms(): array;
}

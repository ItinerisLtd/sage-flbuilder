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
    public function template(string $file, array $data = []): string
    {
        $file_path = "Theme::{$file}";

        if ($this->getModuleGroup() === $data['module']->group) {
            $file_path = "ItinerisSageFLBuilderModules::{$file}";
        }

        return view()->exists($file_path)
            ? view($file_path, $data)->render()
            : '';
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

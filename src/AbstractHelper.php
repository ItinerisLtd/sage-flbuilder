<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

abstract class AbstractHelper
{
    /**
     * @param string $file
     * @param array $data
     * @return string
     */
    public function template($file, $data = []): string
    {
        return \App\template($file, $data);
    }

    /**
     * Retrieve path to a compiled blade view
     * @param $file
     * @param array $data
     * @return string
     */
    public function templatePath($file, $data = []): string
    {
        return \App\template_path($file, $data);
    }

    /**
     * @param $asset
     * @return string
     */
    public function assetPath($asset): string
    {
        return \App\asset_path($asset);
    }

    /**
     * @param string|string[] $templates Relative path to possible template files
     * @return string Location of the template
     */
    abstract public function locateTemplate($templates): string;
}

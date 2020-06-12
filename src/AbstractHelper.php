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
        return view()->exists("ItinerisSageFLBuilder::{$file}")
            ? view("ItinerisSageFLBuilder::{$file}", $data)->render()
            : '';
    }

    /**
     * Retrieve path to a compiled blade view
     *
     * @param       $file
     * @param array $data
     *
     * @return string
     */
    public function templatePath(string $file, array $data = []): string
    {
        return view($file, $data)->makeLoader();
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
     * @param string|string[] $templates Possible template files.
     * @return array
     */
    public function filter_templates($templates)
    {
        $paths = apply_filters('sage/filter_templates/paths', [
            'views',
            'resources/views'
        ]);
        $paths_pattern = '#^(' . implode('|', $paths) . ')/#';

        return collect($templates)
            ->map(function ($template) use ($paths_pattern) {
                /** Remove .blade.php/.blade/.php from template names */
                $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

                /** Remove partial $paths from the beginning of template names */
                if (strpos($template, '/')) {
                    $template = preg_replace($paths_pattern, '', $template);
                }

                return $template;
            })
            ->flatMap(function ($template) use ($paths) {
                return collect($paths)
                    ->flatMap(function ($path) use ($template) {
                        return [
                            "{$path}/{$template}.blade.php",
                            "{$path}/{$template}.php",
                        ];
                    })
                    ->concat([
                        "{$template}.blade.php",
                        "{$template}.php",
                    ]);
            })
            ->filter()
            ->unique()
            ->all();
    }

    /**
     * @param string|string[] $templates Relative path to possible template files.
     *
     * @return string Location of the template
     */
    public function locateTemplate($templates): string
    {
        return \locate_template($this->filter_templates($templates));
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

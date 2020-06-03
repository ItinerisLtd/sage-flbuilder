<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

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
        return \App\template($file, $data);
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
        return \App\template_path($file, $data);
    }

    /**
     * @param $asset
     *
     * @return string
     */
    public function assetPath($asset): string
    {
        return \App\asset_path($asset);
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

    /**
     * Some times le wild <span class="blue hedgehog"> appears, which is when you need this function, to validate both
     * blue and hedgehog because sanitize_html_class doesn't allow spaces.
     *
     * @param  mixed $classes  "blue hedgehog goes shopping" or array("blue", "hedgehog", "goes", "shopping").
     * @param  mixed $fallback Anything you want returned in case of a failure.
     *
     * @return string
     */
    abstract public function sanitizeHtmlClasses($classes, $fallback = null): string;

    /**
     * @param string $videoUrl
     * @param bool   $isElement
     * @param int    $size
     * @param string $altText
     *
     * @return string|null
     */
    abstract public function videoThumb($videoUrl, $isElement = false, $size = '0', string $altText = '');

    /**
     * @param string $videoUrl
     * @param string $urlType
     *
     * @return string
     */
    abstract public function formatVideoUrl($videoUrl, $urlType = 'embed'): string;

    /**
     * Creates a responsive iframe and embeds a video player
     * or an embed URL for the video
     *
     * @param  string  $videoUrl URL of the video.
     * @param  boolean $isUrl    If true, returns the iframe URL, not the iframe.
     * @param  int     $width    The width of the iframe.
     * @param  int     $height   The height of the iframe.
     *
     * @return string|false Video embed URL or HTML for iframe embed
     */
    abstract public function videoEmbed($video_url, $width = null, $height = null);

    /**
     * Builds a navigation menu based on parent post, children and siblings
     */
    abstract public function getSecondaryNav();

    abstract public function getGravityForms(): array;
}

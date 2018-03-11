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
        return __('Custom Widgets', 'fabric');
    }

    public function getModuleCategory(): string
    {
        return __('Itineris Standard Modules', 'fabric');
    }

    /**
     * @param string|string[] $templates Relative path to possible template files
     *
     * @return string Location of the template
     */
    abstract public function locateTemplate($templates): string;

    /**
     * Link targets used for widgets
     *
     * @return array
     */
    abstract public function linkTargets(): array;

    /**
     * Button Styles usable in the cutup
     *
     * @return array
     */
    abstract public function buttonStyles(): array;

    /**
     * Builds a list of posts from specified post type
     *
     * @return string[]
     */
    abstract public function getPosts($post_type, $parent_id = ''): array;

    /**
     * Retrieves the category from $_GET['cat'] and sanitizes for use
     *
     * @param string $asTerm    Whether or not to return the term object
     * @param string $category  The category to check against for term object
     * @param string $asTermId  Whether or not to return the term object ID
     * @param string $termValue The value to check against for the term object
     * @param string $filter    The filter used to sanitize against the input
     *
     * @return int|string|object    The category value or object
     */
    abstract public function getCat(
        $asTerm = false,
        $category = '',
        $asTermId = false,
        $termValue = 'slug',
        $filter = FILTER_SANITIZE_STRING
    );

    /**
     * @return string|false
     */
    abstract public function breadcrumbs();

    /**
     * Some times le wild <span class="blue hedgehog"> appears, which is when you need this function, to validate both
     * blue and hedgehog because sanitize_html_class doesn't allow spaces.
     *
     * @param  mixed $class    "blue hedgehog goes shopping" or array("blue", "hedgehog", "goes", "shopping").
     * @param  mixed $fallback Anything you want returned in case of a failure.
     *
     * @return string
     */
    abstract public function sanitizeHtmlClasses($class, $fallback = null): string;

    /**
     * @param        $video_url
     * @param bool   $is_element
     * @param int    $size
     * @param string $alt_text
     *
     * @return string|false
     */
    abstract public function videoThumb($video_url, $is_element = false, $size = 0, $alt_text = '');

    /**
     * Creates a responsive iframe and embeds a video player
     * or an embed URL for the video
     *
     * @param  string  $video_url URL of the video
     * @param  boolean $is_url    If true, returns the iframe URL, not the iframe
     * @param  int     $width     The width of the iframe
     * @param  int     $height    The height of the iframe
     *
     * @return string|false Video embed URL or HTML for iframe embed
     */
    abstract public function videoEmbed($video_url, $is_url = false, $width = null, $height = null);

    /**
     * Creates a HTML taxonomy dropdown
     *
     * @param string $taxonomy The taxnonomy slug or name.
     * @param string $label    The name of the type of dropdown.
     */
    abstract public function taxonomyDropdown(
        $taxonomy,
        $post_type = null,
        $query_var = 'pc',
        $label = 'Category',
        $show_label = false
    );

    /**
     * Builds a navigation menu based on parent post, children and siblings
     */
    abstract public function getSecondaryNav(): string;

    /**
     * Grabs the data of a specified meta key
     *
     * @param  string  $key     The ID of the meta key.
     * @param  int     $post_id The ID of the post.
     * @param  boolean $single  Output as array or array value.
     * @param  boolean $raw     Whether to return filtered data or not.
     *
     * @return string|array     The requested meta value
     */
    abstract public function fabricGf($key, $post_id = 0, $single = true, $raw = false);
}

<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

use Closure;
use FLBuilderModel;
use FLThemeBuilderLayoutData;

use function Roots\view;

final class ThemeLayout
{
    /**
     * @var Closure
     */
    private Closure $shouldInclude;

    /**
     * @var string
     */
    private string $template;

    public function __construct(Closure $shouldInclude, string $template)
    {
        $this->shouldInclude = $shouldInclude;
        $this->template      = $template;
    }

    public function locateTemplatePath(string $template): string
    {
        if (! ($this->shouldInclude)()) {
            return $template;
        }

        $ids = FLThemeBuilderLayoutData::get_current_page_content_ids();

        if ('fl-theme-layout' === get_post_type() && count($ids) > 1) {
            $post_id = FLBuilderModel::get_post_id();
        } else {
            $post_id = $ids[0] ?? get_the_ID();
        }

        $data = [
            'post_id' => $post_id,
        ];

        if (view()->exists($this->template)) {
            return view($this->template, $data)->makeLoader();
        }

        if (view()->exists("ItinerisSageFLBuilderViews::{$this->template}")) {
            return view("ItinerisSageFLBuilderViews::{$this->template}", $data)->makeLoader();
        }

        return $template;
    }
}

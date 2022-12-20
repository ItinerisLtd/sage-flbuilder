<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

use Closure;

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

        if (view()->exists($this->template)) {
            return view($this->template)->makeLoader();
        }

        if (view()->exists("ItinerisSageFLBuilder::{$this->template}")) {
            return view("ItinerisSageFLBuilder::{$this->template}")->makeLoader();
        }

        return $template;
    }
}

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
    private $shouldInclude;

    /**
     * @var string
     */
    private $template;

    public function __construct(Closure $shouldInclude, string $template)
    {
        $this->shouldInclude = $shouldInclude;
        $this->template = $template;
    }

    public function locateTemplatePath(string $template): string
    {
        if (!($this->shouldInclude)()) {
            return $template;
        }

        return view()->exists($this->template)
            ? view($this->template)->makeLoader()
            : $template;
    }
}

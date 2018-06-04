<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

use Closure;
use function Itineris\SageFLBuilder\getHelper;

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
        if (! ($this->shouldInclude)()) {
            return $template;
        }

        $helper = getHelper();

        return $helper->templatePath(
            $helper->locateTemplate($this->template)
        );
    }
}

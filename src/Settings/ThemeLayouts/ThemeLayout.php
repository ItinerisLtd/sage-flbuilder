<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\ThemeLayouts;

use Closure;
use Itineris\SageFLBuilder\AbstractHelper;
use function Roots\app as sage;

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

        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        $newTemplate = $helper->locateTemplate($this->template);

        if (empty($newTemplate)) {
            return $template;
        }

        return $helper->templatePath($newTemplate);
    }
}

<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder;

use Itineris\SageFLBuilder\Modules\Accordion\Accordion;
use Itineris\SageFLBuilder\Modules\Alert\Alert;
use Itineris\SageFLBuilder\Modules\Breadcrumbs\Breadcrumbs;
use Itineris\SageFLBuilder\Modules\Button\Button;
use Itineris\SageFLBuilder\Modules\ContentImage\ContentImage;
use Itineris\SageFLBuilder\Modules\FilterBar\FilterBar;
use Itineris\SageFLBuilder\Modules\Gallery\Gallery;
use Itineris\SageFLBuilder\Modules\GravityForm\GravityForm;
use Itineris\SageFLBuilder\Modules\PageHeading\PageHeading;
use Itineris\SageFLBuilder\Modules\PageSlider\PageSlider;
use Itineris\SageFLBuilder\Modules\SecondaryNav\SecondaryNav;
use Itineris\SageFLBuilder\Modules\Table\Table;
use Itineris\SageFLBuilder\Modules\Testimonial\Testimonial;
use Itineris\SageFLBuilder\Settings\RichText;
use Itineris\SageFLBuilder\Settings\ThemeLayouts\ArchiveThemeLayout;
use Itineris\SageFLBuilder\Settings\ThemeLayouts\DefaultThemeLayout;
use Itineris\SageFLBuilder\Settings\ThemeLayouts\HomeThemeLayout;
use Itineris\SageFLBuilder\Settings\ThemeLayouts\SingleThemeLayout;
use function Roots\app as sage;

/**
 * Beaver Builder extensions
 */
final class SageFLBuilder
{
    private const DEFAULT_INITIALIZABLES = [
        Accordion::class,
        Alert::class,
        ArchiveThemeLayout::class,
        Breadcrumbs::class,
        Button::class,
        ContentImage::class,
        FilterBar::class,
        Gallery::class,
        GravityForm::class,
        HomeThemeLayout::class,
        PageHeading::class,
        PageSlider::class,
        RichText::class,
        SecondaryNav::class,
        SingleThemeLayout::class,
        Table::class,
        Testimonial::class,
        DefaultThemeLayout::class,
    ];

    /**
     * Class names of modules, settings and helpers.
     *
     * @var InitializableInterface[]
     */
    private $initializables;

    /**
     * @var AbstractHelper
     */
    private $helper;

    public function __construct(AbstractHelper $helper)
    {
        $this->helper = $helper;
        $this->initializables = self::DEFAULT_INITIALIZABLES;
    }

    public function add(string ...$initializables): self
    {
        $this->initializables = array_merge($this->initializables, $initializables);

        return $this;
    }

    public function remove(string ...$initializables): self
    {
        $this->initializables = array_diff($this->initializables, $initializables);

        return $this;
    }

    public function getInitializables()
    {
        return $this->initializables;
    }

    public function setInitializables($initializables): self
    {
        $this->initializables = $initializables;

        return $this;
    }

    public static function setDefaultModuleGroup(array $data): array
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        // Get the name of the projects module group.
        $group_name = $helper->getSiteModuleGroup();

        // Get the key of the projects module group.
        $group_key = sanitize_key($group_name);

        if (! $group_key) {
            return $data;
        }

        $module_views = collect($data['tabs']['modules']['views']);

        // Get our project module group.
        $project_modules = $module_views->first(function (array $group) use ($group_key): bool {
            return isset($group['handle']) && $group_key === $group['handle'];
        });

        if (null === $project_modules) {
            return $data;
        }

        // Remove our project module group.
        $module_views = $module_views->reject(function (array $group) use ($group_key): bool {
            return isset($group['handle']) && $group_key === $group['handle'];
        });

        if (null === $module_views) {
            return $data;
        }

        // Add our project module group to the start.
        $module_views->prepend($project_modules);
        $data['tabs']['modules']['views'] = $module_views->toArray();
        return $data;
    }

    public function addFilters(): void
    {
        add_filter('fl_builder_content_panel_data', [__CLASS__, 'setDefaultModuleGroup']);
    }

    public function init(): void
    {
        sage()->instance(AbstractHelper::class, $this->helper);

        foreach ($this->initializables as $initializable) {
            $initializable::init();
        }

        $this->addFilters();
    }
}

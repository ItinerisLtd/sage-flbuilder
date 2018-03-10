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
use Itineris\SageFLBuilder\Modules\MainBanner\MainBanner;
use Itineris\SageFLBuilder\Modules\PageHeading\PageHeading;
use Itineris\SageFLBuilder\Modules\PageSlider\PageSlider;
use Itineris\SageFLBuilder\Modules\SecondaryNav\SecondaryNav;
use Itineris\SageFLBuilder\Modules\Table\Table;
use Itineris\SageFLBuilder\Modules\Testimonial\Testimonial;
use Itineris\SageFLBuilder\Modules\Video\Video;
use Itineris\SageFLBuilder\Settings\EventsArchive;
use Itineris\SageFLBuilder\Settings\PostGrid;
use Itineris\SageFLBuilder\Settings\ProductsArchive;

/**
 * Beaver Builder extensions
 */
class FLBuilderBase
{
    public const MODULE_CAT = 'Custom Widgets';
    public const MODULE_GROUP = 'Itineris Standard Modules';

    protected const DEFAULT_INITIALIZABLES = [
        Accordion::class,
        Alert::class,
        Breadcrumbs::class,
        Button::class,
        ContentImage::class,
        EventsArchive::class,
        FilterBar::class,
        Gallery::class,
        God::class,
        MainBanner::class,
        PageHeading::class,
        PageSlider::class,
        PostGrid::class,
        ProductsArchive::class,
        SecondaryNav::class,
        Table::class,
        Testimonial::class,
        Video::class,
    ];

    /**
     * Class names of modules, settings and helpers.
     *
     * @var InitializableInterface[]
     */
    protected $initializables;

    public static function init(array $initializables): void
    {
        $builder = new self($initializables);

        $builder->initialize();
    }

    /**
     * FLBuilderBase constructor.
     *
     * @param InitializableInterface[] $initializables Class names of project-specific modules and settings.
     */
    public function __construct(array $initializables)
    {
        $this->initializables = array_merge(static::DEFAULT_INITIALIZABLES, $initializables);
    }

    public function initialize(): void
    {
        foreach ($this->initializables as $initializable) {
            $initializable::init();
        }
    }
}

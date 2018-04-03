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
use Itineris\SageFLBuilder\Modules\PageHeading\PageHeading;
use Itineris\SageFLBuilder\Modules\PageSlider\PageSlider;
use Itineris\SageFLBuilder\Modules\SecondaryNav\SecondaryNav;
use Itineris\SageFLBuilder\Modules\Table\Table;
use Itineris\SageFLBuilder\Modules\Testimonial\Testimonial;
use Itineris\SageFLBuilder\Modules\Video\Video;
use Itineris\SageFLBuilder\Settings\EventsArchive;
use Itineris\SageFLBuilder\Settings\PostGrid;
use Itineris\SageFLBuilder\Settings\ProductsArchive;
use function App\sage;

/**
 * Beaver Builder extensions
 */
class SageFLBuilder
{
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

    /**
     * @var AbstractHelper
     */
    protected $helper;

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

    public function init(): void
    {
        sage()->instance(AbstractHelper::class, $this->helper);

        foreach ($this->initializables as $initializable) {
            $initializable::init();
        }
    }
}

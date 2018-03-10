<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Breadcrumbs;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractModule;
use Itineris\SageFLBuilder\SageFLBuilder;
use function App\asset_path;

/**
 * Class Breadcrumbs
 */
class Breadcrumbs extends AbstractModule
{
    public static function register(): void
    {
        FLBuilder::register_module(__CLASS__, []);
    }

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Breadcrumbs', 'fabric'),
            'description' => __('Breadcrumbs widget', 'fabric'),
            'category' => 'Posts',
            'group' => SageFLBuilder::MODULE_GROUP,
            'url' => asset_path(__DIR__),
            'icon' => 'layout.svg',
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\Breadcrumbs;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\AbstractModule;
use function Roots\app;

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
        /** @var AbstractHelper $helper */
        $helper = app(AbstractHelper::class);

        parent::__construct([
            'name' => __('Breadcrumbs', 'fabric'),
            'description' => __('Breadcrumbs widget', 'fabric'),
            'category' => 'Posts',
            'group' => $helper->getModuleGroup(),
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'layout.svg',
        ]);
    }
}

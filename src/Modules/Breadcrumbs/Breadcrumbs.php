<?php

namespace Itineris\SageFLBuilder\Modules\Breadcrumbs;

/**
 * Class Breadcrumbs
 */
class Breadcrumbs extends \FLBuilderModule
{

    /**
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct([
            'name'          => __('Breadcrumbs', 'fabric'),
            'description'   => __('Breadcrumbs widget', 'fabric'),
            'category'      => 'Posts',
            'group'         => FLBuilder::FAB_FL_MODULE_GROUP,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'layout.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\Breadcrumbs', []);

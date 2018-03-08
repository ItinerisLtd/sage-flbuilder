<?php

namespace Itineris\SageFLBuilder\Modules\SecondaryNav;

/**
 * Class SecondaryNav
 */
class SecondaryNav extends \FLBuilderModule
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
            'name'          => __('Secondary nav', 'fabric'),
            'description'   => __('Secondary nav widget', 'fabric'),
            'category'      => 'Posts',
            'group'         => FAB_FL_MODULE_GROUP,
            'url'           => \App\asset_path(__DIR__),
            'icon'          => 'layout.svg'
        ]);
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\SecondaryNav', []);

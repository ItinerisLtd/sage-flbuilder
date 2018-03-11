<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\SecondaryNav;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\AbstractModule;
use function App\sage;

/**
 * Class SecondaryNav
 */
class SecondaryNav extends AbstractModule
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
        $helper = sage(AbstractHelper::class);

        parent::__construct([
            'name' => __('Secondary nav', 'fabric'),
            'description' => __('Secondary nav widget', 'fabric'),
            'category' => 'Posts',
            'group' => $helper->getModuleGroup(),
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'layout.svg',
        ]);
    }
}

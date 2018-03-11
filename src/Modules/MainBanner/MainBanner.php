<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\MainBanner;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractBladeModule;
use Itineris\SageFLBuilder\AbstractHelper;
use function App\sage;

/**
 * @class MainBanner
 */
class MainBanner extends AbstractBladeModule
{
    private const FORM_ID = 'main_banner_slides';

    public static function register(): void
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        FLBuilder::register_module(__CLASS__, [
            'general' => [
                'title' => __('General', 'fabric'),
                'sections' => [
                    'slides' => [
                        'title' => __('Slides', 'fabric'),
                        'fields' => [
                            'slides' => [
                                'type' => 'form',
                                'label' => __('Slide', 'fabric'),
                                'form' => self::FORM_ID,
                                'preview_text' => 'btn_text',
                                'multiple' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        /**
         * Register the slide settings form.
         */
        FLBuilder::register_settings_form(self::FORM_ID, [
            'title' => __('Column settings', 'fabric'),
            'tabs' => [
                'general' => [
                    'title' => __('General', 'fabric'),
                    'sections' => [
                        'general' => [
                            'fields' => [
                                'enabled' => [
                                    'type' => 'select',
                                    'label' => __('Status', 'fabric'),
                                    'default' => '1',
                                    'options' => [
                                        '1' => __('Show / Active', 'fabric'),
                                        '0' => __('Hide / Inactive', 'fabric'),
                                    ],
                                ],
                            ],
                        ],
                        'content' => [
                            'title' => __('Content Layout', 'fabric'),
                            'fields' => [
                                'image' => [
                                    'type' => 'photo',
                                    'label' => __('Slide background image', 'fabric'),
                                ],
                                'title' => [
                                    'type' => 'text',
                                    'label' => __('Slide title', 'fabric'),
                                    'default' => 'Making the most',
                                ],
                                'title_second' => [
                                    'type' => 'text',
                                    'label' => __('Slide title second line', 'fabric'),
                                    'default' => 'of everyday',
                                ],
                                'link' => [
                                    'type' => 'link',
                                    'label' => __('Link', 'fabric'),
                                    'help' => __(
                                        'The link applies to the entire slide. If choosing a call to action type below, this link will also be used for the text or button.',
                                        'fabric'
                                    ),
                                ],
                                'link_target' => [
                                    'type' => 'select',
                                    'label' => __('Link Target', 'fabric'),
                                    'default' => '_self',
                                    'options' => [
                                        '_self' => __('Same Window', 'fabric'),
                                        '_blank' => __('New Window', 'fabric'),
                                    ],
                                ],
                                'btn_text' => [
                                    'type' => 'text',
                                    'label' => __('Text', 'fabric'),
                                    'default' => 'Become a member',
                                ],
                                'btn_style' => [
                                    'type' => 'select',
                                    'label' => __('Style', 'fabric'),
                                    'default' => 'btn-warning',
                                    'options' => $helper->buttonStyles(),
                                ],
                                'link2' => [
                                    'type' => 'link',
                                    'label' => __('Link', 'fabric'),
                                    'help' => __(
                                        'The link applies to the entire slide. If choosing a call to action type below, this link will also be used for the text or button.',
                                        'fabric'
                                    ),
                                ],
                                'link_target2' => [
                                    'type' => 'select',
                                    'label' => __('Link Target', 'fabric'),
                                    'default' => '_self',
                                    'options' => [
                                        '_self' => __('Same Window', 'fabric'),
                                        '_blank' => __('New Window', 'fabric'),
                                    ],
                                ],
                                'btn_text2' => [
                                    'type' => 'text',
                                    'label' => __('Text', 'fabric'),
                                    'default' => 'Become a member',
                                ],
                                'btn_style2' => [
                                    'type' => 'select',
                                    'label' => __('Style', 'fabric'),
                                    'default' => 'btn-warning',
                                    'options' => $helper->buttonStyles(),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
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
            'name' => __('Main banner', 'fabric'),
            'description' => __('Main banner widget', 'fabric'),
            'category' => 'Layout',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'text.svg',
        ]);
    }

    /**
     * @method renderButtons
     */
    public function renderButtons()
    {
        if (! empty($this->settings->slides)) {
            foreach ($this->settings->slides as $slide) {
                $this->renderButton($slide);
            }
        }
    }

    /**
     * @method renderButton
     */
    public function renderButton($slide)
    {
        if (! empty($slide)) {
            print '<div class="slide">';
            if (! empty($slide->image)) {
                print '<div class="img">';
                print ' ' . wp_get_attachment_image($slide->image, 'page-banner') . ' ';
                print '</div>';
            }
            if (! empty($slide->title)) {
                print '<div class="container">
                <div class="text">
                <div class="row">
                <div class="col-sm-8">
                <div class="cell">
                <h2 class="h1">' . $slide->title . ' <span> ' . $slide->title_second . '</span></h2>
                <ul class="btn-holder hidden-xs">';
                if (! empty($slide->link)) {
                    print '<li><a href="' . esc_url($slide->link) . ' " class="btn ' . $slide->btn_style . ' waves-effect waves-ripple"> ' . $slide->btn_text . '</a></li>';
                }
                if (! empty($slide->link2)) {
                    print '<li><a href="' . esc_url($slide->link2) . ' " class="btn ' . $slide->btn_style2 . ' waves-effect waves-ripple"> ' . $slide->btn_text2 . '</a></li>';
                }
                print '</ul>
                </div>
                </div>
                </div>
                </div>
                </div>';
            }
            print '</div><!-- / slide -->';
        }
    }
}

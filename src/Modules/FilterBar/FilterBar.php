<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Modules\FilterBar;

use FLBuilder;
use Itineris\SageFLBuilder\AbstractHelper;
use Itineris\SageFLBuilder\AbstractModule;
use function App\sage;

/**
 * @class FilterBar
 */
class FilterBar extends AbstractModule
{


    public static function register(): void
    {
        /** @var AbstractHelper $helper */
        $helper = sage(AbstractHelper::class);

        FLBuilder::register_module(__CLASS__, [
            'layout' => [
                'title' => __('Layout', 'fabric'),
                'sections' => [
                    'general' => [
                        'fields' => [
                            'data_source' => [
                                'type' => 'select',
                                'label' => __('Data Source', 'fabric'),
                                'options' => [
                                    'main_query' => __('Main query', 'fabric'),
                                    'custom_query' => __('Custom query', 'fabric'),
                                ],
                                'toggle' => [
                                    'main_query' => [],
                                    'custom_query' => [
                                        'fields' => ['post_type'],
                                    ],
                                ],
                            ],
                            'post_type' => [
                                'type' => 'post-type',
                                'label' => __('Post Type', 'fabric'),
                                'help' => __('Choose the content type to relate the filter bar to', 'fabric'),
                                'default' => 'post',
                            ],
                            'auto_filter' => [
                                'type' => 'select',
                                'label' => __('Auto filter?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                            ],
                            'show_button' => [
                                'type' => 'select',
                                'label' => __('Show submit button?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '0' => __('No', 'fabric'),
                                    '1' => __('Yes', 'fabric'),
                                ],
                            ],
                            'show_search_filter' => [
                                'type' => 'select',
                                'label' => __('Show search box?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                            ],
                            'show_meta_filters' => [
                                'type' => 'select',
                                'label' => __('Show field filters?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                            ],
                            'show_cat_desc' => [
                                'type' => 'select',
                                'label' => __('Show category description?', 'fabric'),
                                'default' => '1',
                                'options' => [
                                    '1' => __('Yes', 'fl-builder'),
                                    '0' => __('No', 'fl-builder'),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        /**
         * Register the slide settings form.
         */
        FLBuilder::register_settings_form('main_banner_buttons', [
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
            'name' => __('Filter bar', 'fabric'),
            'description' => __('Filter bar widget', 'fabric'),
            'category' => 'Posts',
            'group' => $helper->getModuleGroup(),
            'dir' => __DIR__,
            'url' => $helper->assetPath(__DIR__),
            'icon' => 'layout.svg',
        ]);
    }

    /**
     * @method renderButtons
     */
    public function renderButtons()
    {
        if ($this->settings->show_buttons && ! empty($this->settings->buttons)) {
            foreach ($this->settings->buttons as $button) {
                $this->renderButton($button);
            }
        }
    }

    /**
     * @method renderButton
     */
    public function renderButton($button)
    {
        if (! empty($button)) {
            print '<a href="' . esc_url($button->link) . '" class="btn ' . sanitize_html_class($button->btn_style) .
                  '" target="' . esc_attr($button->link_target) . '">' . esc_html($button->btn_text) . '</a>';
        }
    }
}

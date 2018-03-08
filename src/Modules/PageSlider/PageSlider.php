<?php

namespace App\Plugins\FLBuilder\Modules;

/**
 * @class PageSlider
 */
class PageSlider extends \FLBuilderModule
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
            'name'          => __('Page Slider', 'fabric'),
            'description'   => __('Page Slider widget', 'fabric'),
            'category'      => FAB_FL_MODULE_CAT,
            'dir'           => __DIR__,
            'url'           => \App\asset_path(__DIR__),
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ]);
    }

    /**
     * @method renderBackground
     */
    public function renderBackground($slide, $sc = 0)
    {
        if (!empty($slide->bg_image_src)) {
            print '<div class="img" style="background-image: url('.
                  esc_url($slide->bg_image_src).')"><img src="'.esc_url($slide->bg_image_src).'"></div><!-- end img -->';
        }
    }

    /**
     * @method renderContent
     */
    public function renderContent($slide, $sc = 0)
    {
        if (is_object($slide) && 'none' === $slide->content_layout) {
            return;
        }

        $this->renderButton($slide);

        print '<figcaption><div class="container"><div class="block">';

        if (is_object($slide)) {
            if (!empty($slide->title1)) {
                printf('<h1>%1$s%2$s</h1>', $slide->title1, '<br><b>'.$slide->title2.'</b>');
            }
            if (!empty($slide->text)) {
                print wpautop($slide->text);
            }

        }

        print '</div><!-- end block --></div><!-- end container --></figcaption>';
    }

    /**
     * @method renderButton
     */
    public function renderButton($slide, $sc = 0)
    {
        if ($slide->show_sticker) {
            print '<div class="image-label"><div class="valign">';
            if (!empty($slide->sticker_title)) {
                print '<span class="title">'.esc_html($slide->sticker_title).'</span>';
            }
            if (!empty($slide->sticker_heading1)) {
                printf(
                    '<h3>%1$s%2$s</h3>',
                    esc_html($slide->sticker_heading1),
                    '<br>'.esc_html($slide->sticker_heading2)
                );
            }
            if ('none' === $slide->cta_type) {
                return;
            } elseif (isset($slide->cta_type) && 'button' === $slide->cta_type) {
                if (!isset($slide->btn_style)) {
                    $slide->btn_style = 'btn-transparent';
                }

                echo '<a href="'.esc_url($slide->link).'" class="btn '.sanitize_html_class($slide->btn_style).
                     '" target="'.esc_attr($slide->link_target).'">'.esc_html($slide->cta_text).'</a>';

            }
            print '</div><!-- end valign --></div><!-- end image-label -->';
        }
    }
}

/**
 * Register the module and its form settings.
 */
\FLBuilder::register_module('\App\Plugins\FLBuilder\Modules\PageSlider', [
    'general'       => [
        'title'         => __('General', 'fabric'),
        'sections'      => [
            'slides'       => [
                'fields'        => [
                    'slides'        => [
                        'type'          => 'form',
                        'label'         => __('Item', 'fabric'),
                        'form'          => 'banner_slides', // ID from registered form below
                        'preview_text'  => 'title1', // Name of a field to use for the preview text
                        'multiple'      => true
                    ]
                ]
            ]
        ]
    ]
]);

/**
 * Register the slide settings form.
 */
\FLBuilder::register_settings_form('banner_slides', [
    'title'         => __('Slide Settings', 'fabric'),
    'tabs'          => [
        'general'       => [ // Tab
            'title'         => __('General', 'fabric'), // Tab title
            'sections'      => [
                'general'       => [
                    'fields'        => [
                        'enabled'       => [
                            'type'          => 'select',
                            'label'         => __('Status', 'fabric'),
                            'default'       => '1',
                            'options'       => [
                                '1'             => __('Show / Active', 'fabric'),
                                '0'             => __('Hide / Inactive', 'fabric')
                            ]
                        ],
                        'bg_image'      => [
                            'type'          => 'photo',
                            'label'         => __('Background Image', 'fabric')
                        ],
                    ]
                ],
                'content'       => [
                    'title'         => __('Content Layout', 'fabric'),
                    'fields'        => [
                        'content_layout' => [
                            'type'          => 'select',
                            'label'         => __('Type', 'fabric'),
                            'default'       => 'none',
                            'help'          => __(
                                'This allows you to add content over or in addition to the background selection above. The location of the content layout can be selected in the style tab.', // @codingStandardsIgnoreLine
                                'fabric'
                            ),
                            'options'       => [
                                'text'          => __('Text', 'fabric'),
                                'none'          => _x('None', 'Content type.', 'fabric')
                            ],
                            'toggle'        => [
                                'text'          => [
                                    'fields'        => ['title1', 'title2', 'text'],
                                    'sections'      => ['text']
                                ],
                            ]
                        ],
                        'title1'         => [
                            'type'          => 'text',
                            'label'         => __('Title 1', 'fabric')
                        ],
                        'title2'         => [
                            'type'          => 'text',
                            'label'         => __('Title 2', 'fabric')
                        ],
                        'text'          => [
                            'type'          => 'editor',
                            'label'         => __('Content', 'fabric'),
                            'media_buttons' => false,
                            'rows'          => 6
                        ]
                    ]
                ],
                'cta'           => [
                    'title'         => __('Call to Actions', 'fabric'),
                    'fields'        => [
                        'show_sticker'  => [
                            'type'          => 'select',
                            'label'         => __('CTA sticker', 'fabric'),
                            'default'       => '1',
                            'options'       => [
                                '1'             => __('Show / Active', 'fabric'),
                                '0'             => __('Hide / Inactive', 'fabric')
                            ],
                            'toggle'        =>[
                                '0'             => [],
                                '1'             => [
                                    'fields'        => [
                                        'sticker_title',
                                        'sticker_heading1',
                                        'sticker_heading2',
                                        'cta_type',
                                        'link',
                                        'link_target',
                                        'cta_text',
                                        'btn_style'
                                    ]
                                ]
                            ]
                        ],
                        'sticker_title' => [
                            'type'          => 'text',
                            'label'         => __('Title', 'fabric'),
                            'default'       => 'Stories'
                        ],
                        'sticker_heading1'  => [
                            'type'          => 'text',
                            'label'         => __('Heading 1', 'fabric'),
                            'default'       => 'Watch'
                        ],
                        'sticker_heading2'  => [
                            'type'          => 'text',
                            'label'         => __('Heading 2', 'fabric'),
                            'default'       => 'Emily\'s Story'
                        ],
                        'cta_type'      => [
                            'type'          => 'select',
                            'label'         => __('Type', 'fabric'),
                            'default'       => 'none',
                            'options'       => [
                                'none'          => _x('None', 'Call to action.', 'fabric'),
                                'text'          => __('Text', 'fabric'),
                                'button'        => __('Button', 'fabric')
                            ],
                            'toggle'        => [
                                'none'          => [],
                                'text'          => [
                                    'fields'        => ['cta_text', 'link', 'link_target']
                                ],
                                'button'        => [
                                    'fields'        => ['cta_text', 'link', 'link_target', 'btn_style']
                                ]
                            ]
                        ],
                        'link'          => [
                            'type'          => 'link',
                            'label'         => __('Link', 'fabric'),
                            'help'          => __(
                                'The link applies to the entire slide. If choosing a call to action type below, this link will also be used for the text or button.',
                                'fabric'
                            ),
                        ],
                        'link_target'   => [
                            'type'          => 'select',
                            'label'         => __('Link Target', 'fabric'),
                            'default'       => '_self',
                            'options'       => [
                                '_self'         => __('Same Window', 'fabric'),
                                '_blank'        => __('New Window', 'fabric')
                            ]
                        ],
                        'cta_text'      => [
                            'type'          => 'text',
                            'label'         => __('Text', 'fabric'),
                        ],
                        'btn_style'     => [
                            'type'          => 'select',
                            'label'         => __('Style', 'fabric'),
                            'default'       => 'btn-primary',
                            'options'       => \App\button_styles()
                        ]
                    ]
                ]
            ]
        ]
    ]
]);

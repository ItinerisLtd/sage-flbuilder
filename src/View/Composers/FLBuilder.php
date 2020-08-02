<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\View\Composers;

use FLBuilderModel;
use FLThemeBuilderLayoutData;
use Roots\Acorn\View\Composer;

class FLBuilder extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'fl-builder-archive',
        'fl-builder-single',
        'ItinerisSageFLBuilder::fl-builder-archive',
        'ItinerisSageFLBuilder::fl-builder-single',
    ];

    protected function getPostId(): int
    {
        $ids = array_map('absint', FLThemeBuilderLayoutData::get_current_page_content_ids());

        if ('fl-theme-layout' === get_post_type() && count($ids) > 1) {
            $id = FLBuilderModel::get_post_id();
        } else {
            $id = $ids[0] ?? get_the_ID();
        }

        return apply_filters('itineris/sage-flbuilder/themer-layout-id', absint($id));
    }

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with(): array
    {
        return [
            'post_id' => $this->getPostId(),
        ];
    }
}

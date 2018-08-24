<?php

declare(strict_types=1);

namespace Itineris\SageFLBuilder\Settings\Archives;

use WP_Query;

final class Archive
{
    /**
     * @var string
     */
    private $postType;

    public function __construct(string $postType)
    {
        $this->postType = $postType;
    }

    public function modifyQuery(WP_Query $query): WP_Query
    {
        if ($this->shouldModify($query)) {
            $query->set('post_parent', 0);
        }

        return $query;
    }

    private function shouldModify(WP_Query $query): bool
    {
        return ! is_admin() &&
               $query->is_post_type_archive($this->postType) &&
               ($query->is_main_query() || $query->get('fl_builder_loop', false)) &&
               (! isset($query->query['settings']->type) || 'post-grid' === $query->query['settings']->type); // WPCS: precision alignment ok.
    }
}

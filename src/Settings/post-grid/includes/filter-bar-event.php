<?php
/**
 * Post Type Archive widget.
 * Used for displaying various types of content in a consistent manner
 *
 * @package Fabric
 */
// Show the posts filter.
$post_type = 'event';
$show_filter = true;
?>
<?php if ('theme' === $settings->layout && $show_filter) : ?>
    <section id="fab-search-block" class="filter-form events-filter" data-filter-auto="true">
        <form action="<?php echo esc_url(get_pagenum_link()); ?>" method="get">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <?php App\taxonomy_dropdown('event_category', 'event', 'ec', 'Category'); ?>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <?php App\taxonomy_dropdown('event_type', 'event', 'et', 'Type'); ?>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <select name="sort" class="form-control">
                        <option value="">- Select order -</option>
                        <option value="future">Future</option>
                        <option value="past">Past</option>
                    </select>
                </div>
            </div>
            <div class="events-calendar hidden-xs">
                <div class="input-date">
                    <input readonly placeholder="view our events calendar" type="text" class="form-control"
                           id="lbl-calendar">
                    <label class="ico" for="lbl-calendar"><i class="fa fa-calendar"></i></label>
                </div><!-- end input-date -->
            </div>
        </form>
    </section>
<?php endif; ?>

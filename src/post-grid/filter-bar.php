<?php
/**
 * Post Type Archive widget.
 * Used for displaying various types of content in a consistent manner
 *
 * @package Fabric
 */

use Itineris\SageFLBuilder\AbstractHelper;
use function App\sage;

/** @var AbstractHelper $helper */
$helper = sage(AbstractHelper::class);

// Show the posts filter.
$show_filter = false;
$tax_exists = false;
$post_type = (array) ('main_query' === $settings->data_source ? (get_post_type() ?: 'post') : $settings->post_type);
$post_type = reset($post_type);
if ($settings->show_filter ?? false) {
    // Get the taxonomy name.
    $category = ('post' === $post_type) ? 'category' : ('product' === $post_type ? 'product_cat' : $post_type . '_category');
    // Check if the taxonomy exists.
    $tax_exists = taxonomy_exists($category);

    // Whether or not to show the filter.
    $show_filter = $tax_exists ? true : false;

    // Get the Term ID to filter by from $_GET['cat'].
    $term_id = $helper->getCat(true, $category, true);
    // Change the category if it is valid.
    if (! empty($term_id)) {
        $settings->{'tax_' . $post_type . '_' . $category} = $term_id;
    }
}
$list_class = 'news';
if (('job_vacancy' === $post_type || 'volunteer_vacancy' === $post_type) && 'theme' === $settings->layout) {
    $list_class = 'jobs';
} elseif ('team' === $post_type && 'theme' === $settings->layout) {
    $list_class = 'team';
} elseif ('product' === $post_type && 'theme' === $settings->layout) {
    $list_class = 'product';
}
$filter_count = Itineris\SageFLBuilder\God::flGetFilterCount($settings);
if ('post' === $post_type) {
    // TODO: `\App\get_posts` only accepts 2 parameters.
    $authors = $helper->getPosts('team', '', true);
    $filter_count++;
}
if (1 === $filter_count) {
    $filter_col = 12;
} elseif (2 === $filter_count) {
    $filter_col = 6;
} elseif (3 === $filter_count) {
    $filter_col = 6;
} elseif (4 === $filter_count) {
    $filter_col = 3;
}
$kw = get_query_var('kw');
?>
<?php if ('theme' === $settings->layout && $show_filter) : ?>
    <section id="fab-search-block"
             class="filter-form main-form<?php (! ($settings->auto_filter ?? false)) || ($settings->show_button ?? false) && print ' no-labels'; ?>"<?php ($settings->auto_filter ?? false) && print ' data-filter-auto="true"'; ?>>
        <form action="<?php echo esc_url(get_pagenum_link()); ?>" method="get" id="searchform">
            <div class="row">
                <?php if ($settings->show_search_filter ?? false) : ?>
                    <div class="col-xs-12 col-sm-<?php echo sanitize_html_class($filter_col); ?>">
                        <div class="sfFormBox">
                            <div class="sfFieldWrap">
                                <input type="text" name="kw" class="sfTxt"
                                       value="<?php echo ! empty($kw) ? esc_attr($kw) : ''; ?>"
                                       placeholder="Enter keywords here...">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($tax_exists ?? false) : ?>
                    <div class="col-xs-12 col-sm-<?php echo sanitize_html_class($filter_col); ?>">
                        <?php $helper->taxonomyDropdown($category, 'Category', $post_type); ?>
                    </div>
                <?php endif; ?>
                <?php if ($settings->show_meta_filters ?? false) : ?>
                    <?php $locations = Itineris\SageFLBuilder\God::flGetLocations($post_type); ?>
                    <?php if (! empty($locations)) : ?>
                        <?php $current = get_query_var('location'); ?>
                        <div class="col-xs-12 col-sm-<?php echo sanitize_html_class($filter_col); ?>">
                            <div class="form-group">
                                <div class="input-box dropdown-box">
                                    <select name="vacancy-location" id="location-filter" class="selectpicker">
                                        <option value="" selected>-- Select location --</option>
                                        <?php foreach ($locations as $key => $location) : ?>
                                            <option value="<?php echo esc_attr($key); ?>"<?php $current === $key && print ' selected'; ?>><?php echo esc_html($location); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if ($settings->show_button ?? false) : ?>
                <input type="submit" class="btn btn-primary" value="Search"/>
            <?php endif; ?>
        </form>
    </section>
    <?php if ($settings->show_cat_desc ?? false) : ?>
        <div class="filter-description"><?php echo term_description($term_id, $category); ?></div>
    <?php endif; ?>
<?php endif; ?>

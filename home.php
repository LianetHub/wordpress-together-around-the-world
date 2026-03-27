<?php

/**
 * The template for displaying the tours catalogue (posts archive).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Together_Around_The_World
 */

get_header();

require(TEMPLATE_PATH . '/components/breadcrumbs.php');

$date_from_raw = $_GET['date_from'] ?? '';
$date_to_raw   = $_GET['date_to'] ?? '';
$direction     = $_GET['direction'] ?? '0';
$no_date       = isset($_GET['no_date']) && $_GET['no_date'] === '1';

$current_date = date('Ymd');
$acf_date_from = '';
$acf_date_to = '';
$title_date_from = '';
$title_date_to = '';

if (!empty($date_from_raw)) {
    $dt_from = DateTime::createFromFormat('d.m.Y', $date_from_raw);
    if ($dt_from) {
        $acf_date_from = $dt_from->format('Ymd');
        $title_date_from = wp_date('j F Y', $dt_from->getTimestamp());
    }
}

if (!empty($date_to_raw)) {
    $dt_to = DateTime::createFromFormat('d.m.Y', $date_to_raw);
    if ($dt_to) {
        $acf_date_to = $dt_to->format('Ymd');
        $title_date_to = wp_date('j F Y', $dt_to->getTimestamp());
    }
}

$args = [
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => ['relation' => 'AND'],
    'tax_query'      => [],
    'orderby'        => 'meta_value',
    'meta_key'       => 'tour_date_from',
    'order'          => 'ASC',
];

$args['meta_query']['start_date_clause'] = [
    'key'     => 'tour_date_from',
    'value'   => $current_date,
    'compare' => '>=',
    'type'    => 'DATE'
];

if (!$no_date) {
    if (!empty($acf_date_from)) {
        $args['meta_query']['start_date_clause']['value'] = $acf_date_from;
    }

    if (!empty($acf_date_to)) {
        $args['meta_query'][] = [
            'key'     => 'tour_date_to',
            'value'   => $acf_date_to,
            'compare' => '<=',
            'type'    => 'DATE'
        ];
    }
}

$page_title = 'Наши туры';
$has_filters = false;
$title_parts = [];

if (!$no_date) {
    if ($title_date_from) {
        $title_parts[] = 'от ' . $title_date_from;
        $has_filters = true;
    }
    if ($title_date_to) {
        $title_parts[] = 'до ' . $title_date_to;
        $has_filters = true;
    }
}

if ($direction !== '0') {
    $args['tax_query'][] = [
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $direction,
    ];

    $cat_obj = get_category($direction);
    if ($cat_obj) {
        $title_parts[] = 'по направлению ' . $cat_obj->name;
        $has_filters = true;
    }
}

if ($has_filters) {
    $page_title = 'Результат подбора ' . implode(' ', $title_parts);
} elseif (is_archive()) {
    $page_title = get_the_archive_title();
}

$tours_query = new WP_Query($args);
?>

<section class="tours tours--selection">
    <div class="container">
        <h1 class="tours__title title">
            <?php echo esc_html($page_title); ?>
        </h1>

        <?php require_once(TEMPLATE_PATH . '_form-selection.php'); ?>

        <?php if ($tours_query->have_posts()) : ?>
            <div class="tours__grid">
                <?php while ($tours_query->have_posts()) : $tours_query->the_post(); ?>
                    <?php get_template_part('templates/components/tour-card'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="tours__empty text-center">
                <p>К сожалению, по вашим параметрам актуальных туров не найдено.</p>
                <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>"
                    class="btn btn-secondary">Сбросить фильтры</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
<?php

/**
 * The template for displaying category archives.
 *
 * @package Together_Around_The_World
 */

get_header();

require(TEMPLATE_PATH . '/components/breadcrumbs.php');

$current_cat = get_queried_object();
$current_date = date('Ymd');

$args = [
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'cat'            => $current_cat->term_id,
    'meta_query'     => [
        [
            'key'     => 'tour_date_from',
            'value'   => $current_date,
            'compare' => '>=',
            'type'    => 'DATE'
        ]
    ],
    'orderby'        => 'meta_value',
    'meta_key'       => 'tour_date_from',
    'order'          => 'ASC',
];

$tours_query = new WP_Query($args);
?>

<section class="tours tours--categories">
    <div class="container">
        <h1 class="tours__title title">
            <?php echo esc_html($current_cat->name); ?>
        </h1>

        <?php if ($tours_query->have_posts()) : ?>
            <div class="tours__grid">
                <?php while ($tours_query->have_posts()) : $tours_query->the_post(); ?>
                    <?php get_template_part('templates/components/tour-card'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="tours__empty">
                <p>Актуальных туров в категории «<?php echo esc_html($current_cat->name); ?>» пока нет.</p>
                <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="btn btn-secondary">Смотреть все направления</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
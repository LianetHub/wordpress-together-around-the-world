<?php
$current_date = date('Ymd');

$tours_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => [
        [
            'key'     => 'tour_date_from',
            'value'   => $current_date,
            'compare' => '>=',
            'type'    => 'DATE'
        ]
    ]
]);

$archive_link = get_post_type_archive_link('post');
?>

<section class="tours">
    <div class="container">
        <h2 class="tours__title title text-center">Новые туры</h2>

        <div class="tours__grid">
            <?php if ($tours_query->have_posts()) : ?>
                <?php while ($tours_query->have_posts()) : $tours_query->the_post(); ?>
                    <?php get_template_part('templates/components/tour-card'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="text-center">Туров пока нет!</p>
            <?php endif; ?>
        </div>

        <?php if ($archive_link) : ?>
            <div class="tours__actions text-center">
                <a href="<?php echo esc_url($archive_link); ?>" class="btn btn-primary">
                    Смотреть все туры
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
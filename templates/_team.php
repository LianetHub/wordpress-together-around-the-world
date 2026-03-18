<?php
$team_title   = get_field('team_section_title');
$team_desc    = get_field('team_section_description');

$experts_query = new WP_Query([
    'post_type'      => 'experts',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);
?>

<section class="team">
    <div class="container">
        <h2 class="team__title title text-center">
            <?php echo esc_html($team_title); ?>
        </h2>
        <div class="team__content">
            <?php if ($team_desc) : ?>
                <div class="team__info typography-block">
                    <?php echo $team_desc; ?>
                </div>
            <?php endif; ?>

            <div class="team__slider swiper">
                <div class="swiper-wrapper">
                    <?php if ($experts_query->have_posts()) : ?>
                        <?php while ($experts_query->have_posts()) : $experts_query->the_post();
                            $position = get_field('position');
                        ?>
                            <div class="expert swiper-slide">
                                <div class="expert__image">
                                    <?php
                                    if (has_post_thumbnail()) :
                                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                    ?>
                                        <img
                                            src="<?php echo esc_url($img_url); ?>"
                                            alt="<?php the_title_attribute(); ?>"
                                            class="cover-image">
                                    <?php else : ?>
                                        <img
                                            src="<?php echo get_template_directory_uri(); ?>/assets/img/expert-placeholder.svg"
                                            alt="<?php the_title_attribute(); ?>"
                                            class="cover-image">
                                    <?php endif; ?>
                                </div>
                                <div class="expert__content text-center">
                                    <div class="expert__name"><?php the_title(); ?></div>
                                    <?php if ($position) : ?>
                                        <p class="expert__position">
                                            <?php echo esc_html($position); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
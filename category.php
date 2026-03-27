<?php

/**
 * The template for displaying category archives.
 *
 * @package Together_Around_The_World
 */

get_header(); ?>

<?php require(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
<section class="tours tours--categories">
    <div class="container">
        <h1 class="tours__title title">
            <?php single_cat_title(); ?>
        </h1>

        <?php if (category_description()) : ?>
            <div class="tours__description">
                <?php echo category_description(); ?>
            </div>
        <?php endif; ?>

        <div class="tours__grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('templates/components/tour-card'); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-center">В этой рубрике туров пока нет!</p>
            <?php endif; ?>
        </div>

        <div class="tours__pagination">
            <?php
            the_posts_pagination(array(
                'prev_text' => 'Назад',
                'next_text' => 'Вперед',
            ));
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
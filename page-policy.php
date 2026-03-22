<?php

/**
 * Template Name: Privacy Policy Page
 */
?>

<?php get_header(); ?>

<?php require(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="policy">
    <div class="container">
        <h1 class="policy__title title"><?php the_title() ?></h1>
        <div class="policy__content typography-block">
            <?php the_content(); ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
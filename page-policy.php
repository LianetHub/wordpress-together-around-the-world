<?php

/**
 * Template Name: Privacy Policy Page
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<section class="policy">
    <div class="container">
        <div class="policy__content">
            <div class="policy__text typography-block">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>
<?php

/**
 * Template for the main landing page (Home)
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>
<?php require_once(TEMPLATE_PATH . '_selection-of-tour.php'); ?>
<?php require_once(TEMPLATE_PATH . '_tours.php'); ?>
<?php require_once(TEMPLATE_PATH . '_team.php'); ?>

<?php
while (have_posts()) :
    the_post();
    the_content();
endwhile;
?>




<?php get_footer(); ?>


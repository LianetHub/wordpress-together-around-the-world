<?php

/**
 * The template for displaying the tours catalogue (posts archive).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Together_Around_The_World
 */

get_header(); ?>

<?php require(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<div class="catalogue-filters">
    <div class="container">
        <?php require_once(TEMPLATE_PATH . '_form-selection.php'); ?>
    </div>
</div>

<?php get_footer(); ?>
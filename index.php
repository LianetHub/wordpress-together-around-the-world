<?php

/**
 * The main template file. Used as a fallback if no other template matches.
 */
?>

<?php get_header();
require(TEMPLATE_PATH . '/components/breadcrumbs.php');
?>

<?php if (trim(get_the_content())) : ?>
    <section class="policy">
        <div class="container">
            <h1 class="policy__title title"><?php the_title() ?></h1>
            <div class="policy__content typography-block">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php get_footer(); ?>
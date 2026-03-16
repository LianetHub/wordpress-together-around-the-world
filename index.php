<?php

/**
 * The main template file. Used as a fallback if no other template matches.
 */
?>

<?php get_header(); ?>
<?php if (trim(get_the_content())) : ?>
    <section class="article">
        <div class="container">
            <div class="article__body">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php get_footer(); ?>
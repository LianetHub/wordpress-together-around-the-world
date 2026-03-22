<?php

/**
 * The template for displaying 404 pages (Not Found)
 */
?>

<?php get_header(); ?>

<?php
$error_background = get_field('error_background', 'option');
$error_title      = get_field('error_title', 'option') ?? "Такой страницы не существует";
$error_subtitle   = get_field('error_subtitle', 'option');
$btn_home_text    = get_field('error_btn_home', 'option');
$btn_cat_text     = get_field('error_btn_catalog', 'option');
$archive_link     = get_post_type_archive_link('post');
?>

<section class="error" style="background-image: url('<?php echo esc_url($error_background); ?>');">
    <div class="container">
        <div class="error__header">

            <div class="error__code">404</div>

            <div class="error__content">
                <?php if ($error_title) : ?>
                    <h1 class="error__title title">
                        <?php echo nl2br(esc_html($error_title)); ?>
                    </h1>
                <?php endif; ?>

                <?php if ($error_subtitle) : ?>
                    <p class="error__subtitle">
                        <?php echo nl2br(esc_html($error_subtitle)); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="error__btns">
            <a
                href="<?php echo esc_url(home_url('/')); ?>"
                class="error__btn btn btn-primary-outline">
                <?php echo esc_html($btn_home_text ?: 'На главную'); ?>
            </a>
            <a
                href="<?php echo esc_url($archive_link); ?>"
                class="error__btn btn btn-primary">
                <?php echo esc_html($btn_cat_text ?: 'Подобрать тур'); ?>
            </a>
        </div>
    </div>
</section>
<?php get_footer(); ?>
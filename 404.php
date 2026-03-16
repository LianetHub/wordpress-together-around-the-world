<?php

/**
 * The template for displaying 404 pages (Not Found)
 */
?>

<?php get_header(); ?>

<?php
$option_page = 'option';
$image_404 = get_field('image_404', $option_page);
$title_404 = get_field('title_404', $option_page);
$txt_404 = get_field('txt_404', $option_page);
$btn_404 = get_field('btn_404', $option_page) ?: "Вернуться на главную";
$marquee_text = get_field('marquee_404', $option_page) ?: "Идёт застройка";
?>

<section class="error">
    <div class="container">
        <div class="error__content">
            <?php if ($image_404): ?>
                <div class="error__image">
                    <img src="<?php echo esc_url($image_404['url']); ?>" alt="<?php echo esc_attr($image_404['alt']); ?>">
                </div>
            <?php endif; ?>

            <?php if ($title_404): ?>
                <h1 class="error__title title-md"><?php echo $title_404; ?></h1>
            <?php endif; ?>

            <?php if ($txt_404): ?>
                <p class="error__subtitle subtitle"><?php echo $txt_404; ?></p>
            <?php endif; ?>

            <?php if ($btn_404): ?>
                <a href="<?php echo home_url(); ?>" class="error__btn btn btn-primary">
                    <?php echo esc_html($btn_404); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="error__marquees">
        <div class="error__marquee marquee marquee--yellow">
            <div class="marquee__slider swiper">
                <div class="swiper-wrapper">
                    <?php for ($i = 0; $i < 12; $i++): ?>
                        <div class="marquee__slide swiper-slide">
                            <?php echo esc_html($marquee_text); ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="error__marquee marquee marquee--dark">
            <div class="marquee__slider swiper" data-direction="reverse">
                <div class="swiper-wrapper">
                    <?php for ($i = 0; $i < 12; $i++): ?>
                        <div class="marquee__slide swiper-slide">
                            <?php echo esc_html($marquee_text); ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
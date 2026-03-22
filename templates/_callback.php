<?php
$title     = get_field('callback_title') ?? "Подберите тур своей мечты";
$subtitle  = get_field('callback_subtitle');
$tagline   = get_field('callback_tagline');
?>

<section class="callback">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="callback__title title text-center">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($subtitle) : ?>
            <p class="callback__subtitle text-center">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>

        <div class="callback__form">
            <?php echo do_shortcode('[contact-form-7 id="9a974fc" title="Контактная форма Подберите тур своей мечты"]') ?>
        </div>

        <?php if ($tagline) : ?>
            <div class="callback__tagline text-center">
                <?php echo esc_html($tagline); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
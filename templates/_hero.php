<?php
$image_url = get_field('hero_bg');
$title_raw = get_field('hero_title');
$subtitle  = get_field('hero_subtitle');
$main_btn  = get_field('hero_main_button');
$badge_text = get_field('hero_badge_text');

$tg_link   = get_field('telegram', 'option');
$max_link  = get_field('max', 'option');

if ($title_raw) {
    $title_formatted = preg_replace('/\*(.*?)\*/', '<span class="color-accent">$1</span>', esc_html($title_raw));
}
?>

<section class="hero" style="background-image: url('<?php echo esc_url($image_url); ?>');">
    <div class="container">
        <div class="hero__inner">
            <div class="hero__content">
                <?php if ($title_raw): ?>
                    <h1 class="hero__title">
                        <?php echo $title_formatted; ?>
                    </h1>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <p class="hero__subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <?php if ($main_btn): ?>
                    <a href="<?php echo esc_url($main_btn['url']); ?>"
                        class="hero__btn-main btn btn-primary"
                        target="<?php echo esc_attr($main_btn['target']); ?>">
                        <?php echo esc_html($main_btn['title']); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="hero__footer">
                <div class="hero__socials">
                    <?php if ($tg_link): ?>
                        <a href="<?php echo esc_url($tg_link); ?>"
                            class="hero__socials-btn btn btn-primary-outline"
                            target="_blank"
                            rel="nofollow">Написать в Telegram</a>
                    <?php endif; ?>
                    <?php if ($max_link): ?>
                        <a href="<?php echo esc_url($max_link); ?>"
                            class="hero__socials-btn btn btn-primary-outline"
                            target="_blank"
                            rel="nofollow">Написать в Max</a>
                    <?php endif; ?>
                </div>

                <?php if ($badge_text): ?>
                    <div class="hero__badge">
                        <div class="hero__badge-icon">
                            <img
                                src="<?php echo get_template_directory_uri() ?>/assets/img/icons/shield.svg"
                                alt="Иконка">
                        </div>
                        <div class="hero__badge-info"><?php echo wp_kses_post($badge_text); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
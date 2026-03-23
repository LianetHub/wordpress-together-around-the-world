<?php
$date_from = get_field('tour_date_from');
$date_to   = get_field('tour_date_to');
$badge     = get_field('tour_badge');
$price     = get_field('tour_price');
$is_from   = get_field('tour_price_from');

$date_str = get_formatted_tour_dates($date_from, $date_to, 'card');

$price_str = '';
if ($price) {
    $price_formatted = number_format($price, 0, '', ' ') . ' ₽';
    $price_str = $is_from ? 'от ' . $price_formatted : $price_formatted;
}
?>

<div class="tour-card">
    <a href="<?php the_permalink(); ?>" class="tour-card__link">
        <div class="tour-card__image">
            <?php
            if (has_post_thumbnail()) {
                $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                echo '<img src="' . esc_url($img_url) . '" alt="' . the_title_attribute(['echo' => false]) . '">';
            } else {
                echo '<img src="' . get_template_directory_uri() . '/assets/img/tour-placeholder.svg" alt="' . the_title_attribute(['echo' => false]) . '" class="placeholder">';
            }
            ?>

            <?php if ($badge && $badge !== 'none') : ?>
                <span class="tour-card__badge tour-card__badge--<?php echo esc_attr($badge); ?>">
                    <?php
                    if ($badge === 'hot') echo 'Горящие места';
                    if ($badge === 'sold') echo 'Мест нет';
                    if ($badge === 'new') echo 'Новинка <span class="tour-card__badge-icon">✨</span>';
                    ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="tour-card__content">
            <h3 class="tour-card__title"><?php the_title(); ?></h3>

            <?php if ($date_str) : ?>
                <div class="tour-card__dates"><?php echo esc_html($date_str); ?></div>
            <?php endif; ?>

            <div class="tour-card__footer">
                <?php if ($price_str) : ?>
                    <div class="tour-card__price"><?php echo esc_html($price_str); ?></div>
                <?php endif; ?>

                <span class="tour-card__btn btn btn-outline-primary">Забронировать тур</span>
            </div>
        </div>
    </a>
</div>
<?php

/**
 * The template for displaying a single blog post
 */
?>

<?php get_header(); ?>

<?php require(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="tour">
    <?php
    $tour_booking_text   = get_field('tour_booking_text', 'option');
    $date_from = get_field('tour_date_from');
    $date_to   = get_field('tour_date_to');
    $price     = get_field('tour_price');
    $is_from   = get_field('tour_price_from');

    $departure_time = get_field('tour_departure_time');
    $departure_text = get_field('tour_departure_text');
    $tour_included  = get_field('tour_included');
    $tour_conditions = get_field('tour_conditions');

    $tour_gallery = get_field('tour_gallery');
    $tour_bottom_description = get_field('tour_bottom_description');

    $date_str = get_formatted_tour_dates($date_from, $date_to, 'tour_page');
    $departure_full = get_formatted_tour_departure($date_from, $departure_time);

    $html_datetime = '';
    if ($date_from) {
        $dt_obj = DateTime::createFromFormat('d/m/Y', $date_from);
        if ($dt_obj) {
            $html_datetime = $dt_obj->format('Y-m-d');

            if ($departure_time) {
                $t_obj = DateTime::createFromFormat('H:i:s', $departure_time);
                if ($t_obj) {
                    $html_datetime .= 'T' . $t_obj->format('H:i');
                }
            }
        }
    }

    $badge = get_field('tour_badge');
    $is_sold_out = ($badge === 'sold');
    ?>

    <div class="container">
        <h1 class="tour__title title"><?php the_title() ?></h1>

        <div class="tour__booking" id="booking-block">
            <div class="tour__booking-header">
                <?php if ($date_str) : ?>
                    <div class="tour__booking-date"><?php echo esc_html($date_str); ?></div>
                <?php endif; ?>

                <?php if ($price) : ?>
                    <div class="tour__booking-price">
                        <div class="tour__booking-price-value">
                            <?php echo ($is_from ? 'от ' : '') . number_format($price, 0, '', ' '); ?>
                        </div>
                        <div class="tour__booking-price-per">
                            рублей <br>
                            на человека
                        </div>
                    </div>
                <?php endif; ?>

                <div class="tour__booking-actions">
                    <?php if ($is_sold_out) : ?>
                        <span class="tour__booking-sold-out btn">Мест нет</span>
                    <?php else : ?>
                        <a href="#callback" data-fancybox class="tour__booking-order btn btn-primary">Оставить заявку</a>
                        <button type="button" class="tour__booking-btn btn btn-primary">Забронировать тур</button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="tour__booking-desc">
                <p class="tour__booking-text typography-block">
                    <?php echo esc_html($tour_booking_text); ?>
                </p>
                <?php
                $tel = get_field('tel', 'option');
                if ($tel) :
                    $tel_clean = preg_replace('/[^0-9+]/', '', $tel);
                ?>
                    <a href="tel:<?php echo $tel_clean; ?>" class="tour__booking-phone btn btn-secondary">
                        <?php echo esc_html($tel); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php
            if (!$is_sold_out) {
                require(TEMPLATE_PATH . '_booking-form.php');
            }
            ?>
        </div>

        <div class="tour__details">
            <?php if ($tour_gallery) : ?>
                <div class="tour__gallery swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($tour_gallery as $item) :
                            $image_data = $item['image'];
                            $is_large   = $item['is_large'];

                            if ($image_data) :
                                $full_url  = $image_data['url'];
                                $thumb_url = $image_data['sizes']['large'];
                                $alt       = !empty($image_data['alt']) ? $image_data['alt'] : get_the_title();
                        ?>
                                <a href="<?php echo esc_url($full_url); ?>"
                                    data-fancybox="tour-gallery"
                                    class="tour__gallery-item swiper-slide <?php echo $is_large ? 'tour__gallery-item--large' : ''; ?>">
                                    <img
                                        src="<?php echo esc_url($thumb_url); ?>"
                                        alt="<?php echo esc_attr($alt); ?>"
                                        class="tour__gallery-img cover-image"
                                        loading="lazy">
                                </a>
                        <?php endif;
                        endforeach; ?>
                    </div>
                    <div class="tour__gallery-pagination swiper-pagination"></div>
                </div>
            <?php endif; ?>
            <div class="tour__departure">
                <div class="tour__departure-header">
                    <div class="tour__departure-title">Выезд</div>
                    <?php if ($departure_full) : ?>
                        <time datetime="<?php echo esc_attr($html_datetime); ?>" class="tour__departure-time">
                            <?php echo esc_html($departure_full); ?>
                        </time>
                    <?php endif; ?>
                </div>
                <?php if ($departure_text) : ?>
                    <div class="tour__departure-text typography-block">
                        <?php echo $departure_text; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="tour__info">
                <div class="tour__conditions">
                    <div class="tour__conditions-title">В стоимость входит:</div>
                    <?php if ($tour_included) : ?>
                        <ul class="tour__conditions-list">
                            <?php foreach ($tour_included as $item) :
                                $inc_text = $item['item'];
                                if ($inc_text) : ?>
                                    <li><?php echo esc_html($inc_text); ?></li>
                            <?php endif;
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="tour__included">
                    <?php if ($price) : ?>
                        <div class="tour__included-price">
                            Стоимость тура <strong><?php echo ($is_from ? 'от ' : '') . number_format($price, 0, '', ' '); ?></strong> рублей
                        </div>
                    <?php endif; ?>

                    <?php if ($tour_conditions) : ?>
                        <div class="tour__included-text typography-block">
                            <?php echo $tour_conditions; ?>
                        </div>
                    <?php endif; ?>
                </div>


            </div>
            <?php if ($tour_bottom_description) : ?>
                <div class="tour__bottom-desc typography-block">
                    <?php echo $tour_bottom_description; ?>
                </div>
            <?php endif; ?>
            <?php if (!$is_sold_out) : ?>
                <div class="tour__actions">
                    <a href="#callback" data-fancybox class="tour__btn btn btn-secondary">Оставить заявку</a>
                    <a href="#booking-block" class="tour__btn btn btn-primary js-anchor-booking">Забронировать тур</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="tour__description">
            <?php the_content() ?>
        </div>
    </div>
</section>
<section class="questions">
    <div class="container">
        <div class="questions__body">
            <h2 class="questions__title title">Остались вопросы</h2>
            <div class="questions__actions">
                <?php
                $tg_link   = get_field('telegram', 'option');
                $max_link  = get_field('max', 'option');
                $tel       = get_field('tel', 'option');
                ?>
                <?php if ($tg_link): ?>
                    <a href="<?php echo esc_url($tg_link); ?>"
                        class="questions__btn btn btn-secondary"
                        target="_blank"
                        rel="nofollow">Написать в Telegram</a>
                <?php endif; ?>
                <?php if ($max_link): ?>
                    <a href="<?php echo esc_url($max_link); ?>"
                        class="questions__btn btn btn-secondary"
                        target="_blank"
                        rel="nofollow">Написать в Max</a>
                <?php endif; ?>
                <?php if ($tel) :
                    $tel_clean = preg_replace('/[^0-9+]/', '', $tel);
                ?>
                    <a
                        href="tel:<?php echo $tel_clean; ?>"
                        class="questions__btn btn btn-primary icon-phone">
                        Позвонить
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="questions__bottom">
            <h3 class="questions__bottom-title title">Задать вопрос без бронирования</h3>
            <div class="questions__bottom-form">
                <?php echo do_shortcode('[contact-form-7 id="8ee8018" title="Контактная форма Задать вопрос без бронирования"]') ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
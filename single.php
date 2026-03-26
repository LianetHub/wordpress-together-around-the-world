<?php

/**
 * The template for displaying a single blog post
 */
?>

<?php get_header(); ?>

<?php require(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="tour">
    <?php
    $date_from = get_field('tour_date_from');
    $date_to   = get_field('tour_date_to');
    $price     = get_field('tour_price');
    $is_from   = get_field('tour_price_from');

    $date_str  = get_formatted_tour_dates($date_from, $date_to, 'tour_page');
    ?>
    <div class="container">
        <h1 class="tour__title title"><?php the_title() ?></h1>
        <div class="tour__booking">
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
                    <a href="#booking-form" class="tour__booking-btn btn btn-primary">Оставить заявку</a>
                    <button type="button" class="tour__booking-btn btn btn-primary">Забронировать тур</button>
                </div>
            </div>

            <div class="tour__booking-desc">
                <div class="tour__booking-text typography-block">
                    <p>
                        Все туры Вы можете забронировать с помощью формы на сайте. После заполнения данных с Заказчиком
                        свяжется менеджер для проверки данных, обсуждения вопросов и внесения предоплаты в зависимости
                        от условий бронирования тура.
                    </p>
                </div>
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
            <?php require(TEMPLATE_PATH . '_booking-form.php'); ?>
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
<?php

/**
 * The template for displaying a single blog post
 */
?>

<?php get_header(); ?>

<?php require(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>

<section class="tour">
    <div class="container">
        <h1 class="tour__title title"><?php the_title() ?></h1>
        <div class="tour__booking">
            <div class="tour__booking-header">
                <div class="tour__booking-date">13-15 марта</div>
                <div class="tour__booking-price">
                    <div class="tour__booking-price-value">12 000</div>
                    <div class="tour__booking-price-per">
                        рублей <br>
                        на человека
                    </div>
                </div>
                <div class="tour__booking-actions">
                    <a href="" class="tour__booking-btn btn btn-primary">Оставить заявку</a>
                    <a href="" class="tour__booking-btn btn btn-primary">Забронировать тур</a>
                </div>
            </div>
            <div class="tour__booking-desc">
                <div class="tour__booking-text typography-block">
                    <p>
                        Все туры Вы можнте забронировать с помощью формы на сайте. После заполнения данных с Заказчиком
                        свяжется менеджер для проверки данных, обсуждения вопросов и внесения предоплаты в зависимости
                        от условий бронирования тура.
                    </p>
                </div>
                <?php
                $tel = get_field('tel', 'option');
                ?>
                <?php if ($tel) :
                    $tel_clean = preg_replace('/[^0-9+]/', '', $tel);
                ?>
                    <a
                        href="tel:<?php echo $tel_clean; ?>"
                        class="tour__booking-phone btn btn-secondary">
                        <?php echo $tel ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php require(TEMPLATE_PATH . '_booking-form.php'); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
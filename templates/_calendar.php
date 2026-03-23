<?php
$tours_raw = get_all_tours_data();
?>

<section id="calendar" class="booking-calendar">
    <div class="container">
        <h2 class="booking-calendar__title title text-center">Календарь туров</h2>
        <div class="booking-calendar__header">
            <div class="booking-calendar__filters">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <button
                            type="button"
                            class="booking-calendar__filter swiper-slide active"
                            data-id="all">
                            Все туры
                        </button>
                        <?php
                        $categories = get_categories(['taxonomy' => 'category', 'hide_empty' => true]);
                        foreach ($categories as $cat) : ?>
                            <button
                                type="button"
                                class="booking-calendar__filter swiper-slide"
                                data-id="<?php echo $cat->term_id; ?>">
                                <?php echo $cat->name; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="button" class="booking-calendar__filters-prev swiper-button-prev"></button>
                <button type="button" class="booking-calendar__filters-next swiper-button-next"></button>
            </div>
            <div class="booking-calendar__controls">
                <button
                    type="button"
                    disabled
                    class="booking-calendar__prev icon-chevron-left"></button>
                <div class="booking-calendar__month"></div>
                <button type="button" class="booking-calendar__next icon-chevron-right"></button>
            </div>
        </div>
        <div class="booking-calendar__content">
            <div class="booking-calendar__block">
                <div id="booking-calendar"></div>
            </div>
            <div class="booking-calendar__side" id="calendar-side-panel"></div>
        </div>
    </div>
</section>
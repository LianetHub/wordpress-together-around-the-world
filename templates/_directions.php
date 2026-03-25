<section class="directions">
    <div class="container">
        <h2 class="directions__title title text-center">Популярные направления</h2>

        <div class="directions-slider swiper">
            <div class="swiper-wrapper">
                <?php
                $all_categories = get_categories([
                    'taxonomy'   => 'category',
                    'hide_empty' => true,
                ]);

                $popular_categories = array_filter($all_categories, function ($cat) {
                    $cat_id = 'category_' . $cat->term_id;
                    $show = get_field('category_show_popular', $cat_id);

                    return ($show !== false);
                });

                usort($popular_categories, function ($a, $b) {
                    $pop_a = (int)get_field('category_popularity', 'category_' . $a->term_id) ?: 0;
                    $pop_b = (int)get_field('category_popularity', 'category_' . $b->term_id) ?: 0;
                    return $pop_b <=> $pop_a;
                });

                if (!empty($popular_categories)) :
                    $chunks = array_chunk($popular_categories, 4);

                    foreach ($chunks as $chunk) : ?>
                        <div class="swiper-slide">
                            <div class="popular-directions__grid">
                                <?php foreach ($chunk as $index => $cat) :
                                    $cat_id = 'category_' . $cat->term_id;
                                    $image = get_field('category_image', $cat_id);
                                    $tour_data = get_category_tour_data($cat->term_id);

                                    $grid_class = '';
                                    if ($index === 0) $grid_class = 'popular-directions__item--wide';
                                    if ($index === 3) $grid_class = 'popular-directions__item--tall';

                                    $price_val = (int)$tour_data['price'];
                                    $price_formatted = number_format($price_val, 0, '', '&#8239;');

                                    $days_val = (int)$tour_data['days'];
                                    $days_word = ($days_val == 1) ? 'день' : (($days_val > 1 && $days_val < 5) ? 'дня' : 'дней');
                                ?>
                                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                                        class="popular-directions__item <?php echo esc_attr($grid_class); ?>">

                                        <div class="popular-directions__image">
                                            <?php if ($image) : ?>
                                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                                            <?php else : ?>
                                                <div class="popular-directions__placeholder"></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="popular-directions__info">
                                            <span class="badge badge--name">
                                                <?php echo esc_html($cat->name); ?>
                                            </span>

                                            <?php if ($price_val > 0) : ?>
                                                <span class="badge badge--info">
                                                    от&#8239;<?php echo $price_formatted; ?>&#8239;₽
                                                    <?php if ($days_val > 0) : ?>
                                                        &#8239;<?php echo $days_val; ?>&#8239;<?php echo $days_word; ?>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>

                                            <div class="arrow">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 11L11 1M11 1H3M11 1V9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                <?php endforeach;
                else:
                    echo "<p style='text-align:center;'>Рубрики не найдены. Убедитесь, что в них есть посты.</p>";
                endif; ?>
            </div>

            <div class="slider-controls">
                <button type="button" class="swiper-button-prev"></button>
                <button type="button" class="swiper-button-next"></button>
            </div>
        </div>

        <div class="directions__footer">
            <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>"
                class="directions__all-link">
                Смотреть все направления
            </a>
        </div>
    </div>
</section>
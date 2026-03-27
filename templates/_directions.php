<section class="directions">
    <div class="container">
        <h2 class="directions__title title text-center">Популярные направления</h2>

        <div class="directions__slider swiper">
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

                    foreach ($chunks as $chunk) :
                        $count = count($chunk);
                ?>
                        <div class="swiper-slide directions__grid directions__grid--count-<?php echo $count; ?>">
                            <?php foreach ($chunk as $cat) :
                                $cat_id = 'category_' . $cat->term_id;
                                $image = get_field('category_image', $cat_id);
                                $tour_data = get_category_tour_data($cat->term_id);

                                $price_val = (int)$tour_data['price'];
                                $price_formatted = number_format($price_val, 0, '', '&#8239;');

                                $days_val = (int)$tour_data['days'];
                                $days_word = ($days_val == 1) ? 'день' : (($days_val > 1 && $days_val < 5) ? 'дня' : 'дней');
                            ?>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                                    class="directions__item">
                                    <div class="directions__image">
                                        <?php if ($image) : ?>
                                            <img
                                                src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($cat->name); ?>"
                                                class="cover-image"
                                                loading="lazy">
                                        <?php endif; ?>
                                    </div>

                                    <div class="directions__info">
                                        <div class="directions__info-blocks">
                                            <span class="directions__info-day">
                                                <?php echo esc_html($cat->name); ?>
                                            </span>

                                            <?php if ($price_val > 0) : ?>
                                                <span class="directions__info-details">
                                                    от&#8239;<?php echo $price_formatted; ?>&#8239;₽
                                                    <?php if ($days_val > 0) : ?>
                                                        &#8239;<?php echo $days_val; ?>&#8239;<?php echo $days_word; ?>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="directions__info-arrow icon-arrow"></span>

                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                <?php endforeach;
                else:
                    echo "<p style='text-align:center;'>Рубрики не найдены.</p>";
                endif; ?>
            </div>
        </div>

        <div class="directions__footer">
            <div class="directions__controls">
                <button type="button" aria-label="Пролистать влево" class="directions__prev swiper-button-prev"></button>
                <button type="button" aria-label="Пролистать вправо" class="directions__next swiper-button-next"></button>
            </div>
            <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="directions__all-link">
                Смотреть все направления
            </a>
        </div>
    </div>
</section>
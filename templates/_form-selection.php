<?php
$archive_link = get_post_type_archive_link('post');
?>
<form
    action="<?php echo esc_url($archive_link); ?>"
    method="GET"
    class="selection__form filter-form">
    <div class="selection__form-row">
        <label class="selection__form-field form__field">
            <span class="form__field-label">дата поездки от:</span>
            <input
                type="text"
                name="date_from"
                class="form__control form__control--green"
                placeholder="Выбрать дату"
                value="<?php echo esc_attr($_GET['date_from'] ?? ''); ?>">
        </label>

        <label class="selection__form-field form__field">
            <span class="form__field-label">дата поездки до:</span>
            <input
                type="text"
                name="date_to"
                class="form__control form__control--green"
                placeholder="Выбрать дату"
                value="<?php echo esc_attr($_GET['date_to'] ?? ''); ?>">
        </label>

        <label class="selection__form-field form__field">
            <span class="form__field-label">Направление</span>
            <div class="dropdown">
                <?php
                $current_direction = $_GET['direction'] ?? '0';
                $categories = get_categories([
                    'hide_empty' => 1,
                    'exclude'    => 1
                ]);

                $current_label = 'Не важно';
                if ($current_direction !== '0') {
                    $cat_obj = get_category($current_direction);
                    if ($cat_obj) $current_label = $cat_obj->name;
                }
                ?>
                <input type="hidden" name="direction" value="<?php echo esc_attr($current_direction); ?>">

                <button type="button" class="dropdown__button" aria-expanded="false" aria-haspopup="true">
                    <span class="dropdown__button-text"><?php echo esc_html($current_label); ?></span>
                </button>

                <div class="dropdown__body" aria-hidden="true">
                    <div class="dropdown__content">
                        <ul class="dropdown__list" role="listbox">
                            <li role="option" data-value="0"
                                class="dropdown__list-item <?php echo $current_direction === '0' ? 'selected' : ''; ?>">
                                Не важно
                            </li>
                            <?php foreach ($categories as $cat) : ?>
                                <li role="option"
                                    data-value="<?php echo esc_attr($cat->term_id); ?>"
                                    class="dropdown__list-item <?php echo ($current_direction == $cat->term_id) ? 'selected' : ''; ?>">
                                    <?php echo esc_html($cat->name); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </label>

        <button type="submit" class="selection__form-submit btn btn-primary">Подобрать тур</button>
    </div>

    <label class="selection__form-checkbox checkbox">
        <input type="checkbox" name="no_date" value="1" class="checkbox__input hidden" <?php checked($_GET['no_date'] ?? '', '1'); ?>>
        <span class="checkbox__text">даты поездки не важны</span>
    </label>
</form>
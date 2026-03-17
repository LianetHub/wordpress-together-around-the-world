<form action="<?php echo esc_url(home_url('/')); ?>" method="GET" class="selection__form filter-form">
    <div class="selection__form-row">
        <label class="selection__form-field form__field">
            <span class="form__field-label">дата поездки от:</span>
            <input
                type="text"
                name="date_from"
                class="form__control"
                placeholder="Выбрать дату"
                value="<?php echo esc_attr($_GET['date_from'] ?? ''); ?>">
        </label>

        <label class="selection__form-field form__field">
            <span class="form__field-label">дата поездки до:</span>
            <input
                type="text"
                name="date_to"
                class="form__control"
                placeholder="Выбрать дату"
                value="<?php echo esc_attr($_GET['date_to'] ?? ''); ?>">
        </label>

        <label class="selection__form-field form__field">
            <span class="form__field-label">Направление</span>
            <div class="form__select">
                <select name="direction" class="form__control">
                    <option value="0">Не важно</option>
                    <option value="1" <?php selected($_GET['direction'] ?? '', '1'); ?>>1</option>
                    <option value="2" <?php selected($_GET['direction'] ?? '', '2'); ?>>2</option>
                    <option value="3" <?php selected($_GET['direction'] ?? '', '3'); ?>>3</option>
                </select>
            </div>
        </label>

        <button type="submit" class="selection__form-submit btn btn-primary">Подобрать тур</button>
    </div>

    <label class="selection__form-checkbox checkbox">
        <input type="checkbox" name="no_date" value="1" class="checkbox__input hidden" <?php checked($_GET['no_date'] ?? '', '1'); ?>>
        <span class="checkbox__text">даты поездки не важны</span>
    </label>
</form>
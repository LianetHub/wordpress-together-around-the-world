<form action="<?php echo esc_url(home_url('/')); ?>" method="GET" class="selection__form filter-form">
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
                <input type="hidden" name="direction" value="1">

                <button type="button" class="dropdown__button" aria-expanded="false" aria-haspopup="true">
                    <span class="dropdown__button-text">1</span>
                </button>

                <div class="dropdown__body" aria-hidden="true">
                    <div class="dropdown__content">
                        <ul class="dropdown__list" role="listbox">
                            <li role="option" data-value="0" aria-checked="false" class="dropdown__list-item">Не важно</li>
                            <li role="option" data-value="1" aria-checked="true" class="dropdown__list-item selected">1</li>
                            <li role="option" data-value="2" aria-checked="false" class="dropdown__list-item">2</li>
                            <li role="option" data-value="3" aria-checked="false" class="dropdown__list-item">3</li>
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
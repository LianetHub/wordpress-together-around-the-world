<form
    action="#"
    method="post"
    class="tour__booking-form booking-form"
    style="display: none;">

    <div class="booking-form__header">
        <fieldset class="booking-form__block">
            <legend class="booking-form__caption">Данные заказчика</legend>
            <div class="booking-form__body">
                <div class="booking-form__side">
                    <div class="form__field">
                        <input
                            type="tel"
                            name="customer_phone"
                            data-required
                            class="form__control"
                            placeholder="Контактный номер">
                    </div>

                    <div class="booking-form__options">
                        <div class="booking-form__options-caption">Предпочтительный способ связи:</div>
                        <div class="booking-form__options-list">
                            <label class="form__option">
                                <input
                                    type="radio"
                                    name="communication_method"
                                    value="telegram"
                                    checked
                                    class="form__option-input hidden" hidden>
                                <span class="form__option-btn">Телеграм</span>
                            </label>
                            <label class="form__option">
                                <input
                                    type="radio"
                                    name="communication_method"
                                    value="whatsapp"
                                    class="form__option-input hidden"
                                    hidden>
                                <span class="form__option-btn">WA</span>
                            </label>
                            <label class="form__option">
                                <input
                                    type="radio"
                                    name="communication_method"
                                    value="call"
                                    class="form__option-input hidden"
                                    hidden>
                                <span class="form__option-btn">Звонок</span>
                            </label>
                        </div>
                    </div>
                </div>
                <textarea name="comment" class="form__control" placeholder="Комментарий к заказу, или вы можете задать вопрос без бронирования"></textarea>
            </div>
        </fieldset>
    </div>

    <div class="booking-form__passengers">
        <fieldset class="booking-form__block">
            <legend class="booking-form__caption">Пассажир 1</legend>
            <div class="booking-form__row">
                <div class="form__field">
                    <input type="text" name="passengers[0][last_name]" data-required class="form__control" placeholder="Фамилия (как в паспорте)">
                </div>
                <div class="form__field">
                    <input type="text" name="passengers[0][first_name]" data-required class="form__control" placeholder="Имя (как в паспорте)">
                </div>
                <div class="form__field">
                    <input type="text" name="passengers[0][middle_name]" data-required class="form__control" placeholder="Отчество (как в паспорте)">
                </div>
                <div class="form__field">
                    <input type="text" name="passengers[0][birth_date]" data-required class="form__control" placeholder="Дата рождения">
                </div>
            </div>
            <div class="booking-form__controls">
                <button type="button" class="booking-form__remove btn btn-secondary">-</button>
                <button type="button" class="booking-form__add btn btn-primary">+</button>
            </div>
        </fieldset>
    </div>

    <div class="booking-form__bottom">
        <button type="submit" class="booking-form__submit btn btn-primary">Забронировать тур</button>
        <label class="checkbox">
            <input type="checkbox" name="agreement" data-required class="checkbox__input hidden">
            <span class="checkbox__text">Я принимаю условия <a href="#">пользовательского соглашения</a></span>
        </label>
    </div>
</form>
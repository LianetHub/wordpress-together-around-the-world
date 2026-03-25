<form
    action="#"
    method="post"
    class="tour__booking-form booking-form">
    <fieldset class="booking-form__block">
        <legend class="booking-form__caption">Данные заказчика</legend>
        <div class="booking-form__body">
            <div class="booking-form__side">
                <input type="tel" name="phone" class="form__control" placeholder="Контактный номер">
                <div class="booking-form__options">
                    <div class="booking-form__options-caption">Предпочтительный способ связи:</div>
                    <div class="booking-form__options-list">
                        <label class="form__option">
                            <input
                                type="radio"
                                name="communication_method"
                                value="1"
                                checked
                                class="form__option-input hidden" hidden>
                            <span class="form__option-btn">Телеграм</span>
                        </label>
                        <label class="form__option">
                            <input
                                type="radio"
                                name="communication_method"
                                value="2"
                                class="form__option-input hidden"
                                hidden>
                            <span class="form__option-btn">МАХ</span>
                        </label>
                        <label class="form__option">
                            <input
                                type="radio"
                                name="communication_method"
                                value="3"
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
</form>
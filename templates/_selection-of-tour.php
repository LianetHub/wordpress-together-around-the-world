<section id="selection-of-tour" class="selection">
    <div class="container">
        <h2 class="selection__title title text-center">Быстрый подбор тура</h2>
        <form action="#" class="selection__form">
            <div class="selection__form-row">
                <label class="selection__form-field form__field">
                    <span class="form__field-label">
                        дата поездки от:
                    </span>
                    <input type="text" name="date_from" class="form__control" placeholder="Выбрать дату">
                </label>
                <label class="selection__form-field form__field">
                    <span class="form__field-label">
                        дата поездки до:
                    </span>
                    <input type="text" name="date_to" class="form__control" placeholder="Выбрать дату">
                </label>
                <label class="selection__form-field form__field">
                    <span class="form__field-label">
                        Направление
                    </span>
                    <div class="form__select">
                        <select name="direction" class="form__control">
                            <option value="0">Не важно</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </label>
                <button type="submit" class="selection__form-submit btn btn-primary">Подобрать тур</button>
            </div>
            <label class="selection__form-checkbox checkbox">
                <input type="checkbox" name="" class="checkbox__input hidden">
                <span class="checkbox__text">даты поездки не важны</span>
            </label>
        </form>
    </div>
</section>
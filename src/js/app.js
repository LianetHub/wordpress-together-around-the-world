"use strict";

$(function () {

    //  init Fancybox
    if (typeof Fancybox !== "undefined" && Fancybox !== null) {
        Fancybox.bind("[data-fancybox]", {
            dragToClose: false,
            on: {
                "Carousel.ready": (fancyboxRef) => {
                    const slide = fancyboxRef.getSlide();
                    if (slide && (slide.triggerEl.classList.contains('case-card') || slide.triggerEl.classList.contains('clients__item')) && slide.triggerEl.dataset.type === "ajax") {
                        slide.el.classList.add("is-case-popup-slide");
                    }
                },
            },
        });
    }

    // detect user OS
    const isMobile = {
        Android: () => /Android/i.test(navigator.userAgent),
        BlackBerry: () => /BlackBerry/i.test(navigator.userAgent),
        iOS: () => /iPhone|iPad|iPod/i.test(navigator.userAgent),
        Opera: () => /Opera Mini/i.test(navigator.userAgent),
        Windows: () => /IEMobile/i.test(navigator.userAgent),
        any: function () {
            return this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows();
        },
    };

    function getNavigator() {
        if (isMobile.any() || $(window).width() < 992) {
            $('body').removeClass('_pc').addClass('_touch');
        } else {
            $('body').removeClass('_touch').addClass('_pc');
        }
    }

    getNavigator();

    $(window).on('resize', () => {
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(() => {
            getNavigator();
        }, 100);
    });

    // event handlers
    $(document).on('click', (e) => {
        const $target = $(e.target);
        const $menu = $('.menu');
        const $toggler = $('.header__menu-toggler');


        if ($target.closest('.header__menu-toggler').length) {
            $toggler.toggleClass("active");
            $menu.toggleClass("menu--open");
            $('body').toggleClass('menu-lock');
            return;
        }

        if ($target.is('.menu') && $menu.hasClass('menu--open')) {
            $toggler.removeClass("active");
            $menu.removeClass("menu--open");
            $('body').removeClass('menu-lock');
        }

        if ($menu.hasClass('menu--open') && $target.closest('.menu-item a').length) {
            $toggler.removeClass("active");
            $menu.removeClass("menu--open");
            $('body').removeClass('menu-lock');
        }
    });


    // sliders
    class MobileSwiper {
        constructor(sliderName, options, condition = 767.98) {
            this.$slider = $(sliderName);
            this.options = options;
            this.init = false;
            this.swiper = null;
            this.condition = condition;

            if (this.$slider.length) {
                this.handleResize();
                $(window).on("resize", () => this.handleResize());
            }
        }

        handleResize() {
            if (window.innerWidth <= this.condition) {
                if (!this.init) {
                    this.init = true;
                    this.swiper = new Swiper(this.$slider[0], this.options);
                }
            } else if (this.init) {
                this.swiper.destroy();
                this.swiper = null;
                this.init = false;
            }
        }
    }

    if ($('.team__slider').length) {
        new MobileSwiper('.team__slider', {
            slidesPerView: 3,
            spaceBetween: 8,
            pagination: {
                el: '.team__slider-pagination',
                clickable: true
            }
        })
    }

    if ($('.tour__gallery').length) {
        new MobileSwiper('.tour__gallery', {
            slidesPerView: 1.5,
            spaceBetween: 8,
            pagination: {
                el: '.tour__gallery-pagination',
                clickable: true
            }
        })
    }


    if ($('.directions__slider').length) {
        new Swiper('.directions__slider', {
            slidesPerView: 1,
            autoHeight: true,
            navigation: {
                prevEl: '.directions__prev',
                nextEl: '.directions__next'
            }
        })
    }

    // Phone Input Mask Russia

    const $phoneInputs = $('input[type="tel"]');

    const getInputNumbersValue = (input) => {
        return input.value.replace(/\D/g, '');
    };

    const onPhoneInput = function (e) {
        let input = e.target,
            inputNumbersValue = getInputNumbersValue(input),
            selectionStart = input.selectionStart,
            formattedInputValue = "";

        if (!inputNumbersValue) {
            return input.value = "";
        }

        if (input.value.length != selectionStart) {
            if (e.originalEvent.data && /\D/g.test(e.originalEvent.data)) {
                input.value = inputNumbersValue;
            }
            return;
        }

        if (["7", "8", "9"].indexOf(inputNumbersValue[0]) > -1) {
            if (inputNumbersValue[0] == "9") inputNumbersValue = "7" + inputNumbersValue;
            let firstSymbols = (inputNumbersValue[0] == "8") ? "8" : "+7";
            formattedInputValue = firstSymbols + " ";

            if (inputNumbersValue.length > 1) {
                formattedInputValue += '(' + inputNumbersValue.substring(1, 4);
            }
            if (inputNumbersValue.length >= 5) {
                formattedInputValue += ') ' + inputNumbersValue.substring(4, 7);
            }
            if (inputNumbersValue.length >= 8) {
                formattedInputValue += '-' + inputNumbersValue.substring(7, 9);
            }
            if (inputNumbersValue.length >= 10) {
                formattedInputValue += '-' + inputNumbersValue.substring(9, 11);
            }
        } else {
            formattedInputValue = '+' + inputNumbersValue.substring(0, 16);
        }
        input.value = formattedInputValue;
    };

    const onPhoneKeyDown = function (e) {
        let inputValue = e.target.value.replace(/\D/g, '');
        if (e.keyCode == 8 && inputValue.length == 1) {
            e.target.value = "";
        }
    };

    const onPhonePaste = function (e) {
        let input = e.target,
            inputNumbersValue = getInputNumbersValue(input);
        let pasted = e.originalEvent.clipboardData || window.clipboardData;
        if (pasted) {
            let pastedText = pasted.getData('Text');
            if (/\D/g.test(pastedText)) {
                input.value = inputNumbersValue;
            }
        }
    };

    $phoneInputs
        .on('keydown', onPhoneKeyDown)
        .on('input', onPhoneInput)
        .on('paste', onPhonePaste);

    // custom select
    class CustomSelect {
        static openDropdown = null;
        static eventsBound = false;

        constructor(dropdownElement) {
            this.$dropdown = $(dropdownElement);
            this.$input = this.$dropdown.find('input[type="hidden"]');
            this.$button = this.$dropdown.find('.dropdown__button');
            this.$buttonText = this.$dropdown.find('.dropdown__button-text');
            this.$listItems = this.$dropdown.find('.dropdown__list-item');

            this.initialValue = this.$input.val();
            this.initialText = this.$buttonText.text();

            this.init();
        }

        init() {
            this.setupEvents();
            this.bindGlobalEvents();
            this.syncStateWithInput();
        }

        bindGlobalEvents() {
            if (CustomSelect.eventsBound) return;

            $(document).on('click.customSelectGlobal', (event) => {
                if (CustomSelect.openDropdown && !$(event.target).closest('.dropdown').length) {
                    CustomSelect.openDropdown.closeDropdown();
                }
            });

            $(document).on('keydown.customSelectGlobal', (event) => {
                if (event.key === 'Escape' && CustomSelect.openDropdown) {
                    CustomSelect.openDropdown.closeDropdown();
                }
            });

            CustomSelect.eventsBound = true;
        }

        setupEvents() {
            this.$button.on('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                const isOpen = this.$dropdown.hasClass('visible');
                this.toggleDropdown(!isOpen);
            });

            this.$dropdown.on('click', '.dropdown__list-item', (event) => {
                event.preventDefault();
                event.stopPropagation();
                const item = $(event.currentTarget);

                if (!item.hasClass('disabled')) {
                    this.selectOption(item);
                }
            });

            this.$input.closest('form').on('reset', () => {
                setTimeout(() => this.restoreInitialState(), 0);
            });
        }

        toggleDropdown(isOpen) {
            if (isOpen && CustomSelect.openDropdown && CustomSelect.openDropdown !== this) {
                CustomSelect.openDropdown.closeDropdown();
            }

            const body = this.$dropdown.find('.dropdown__body');
            const list = this.$dropdown.find('.dropdown__list');
            const hasScroll = list.length && list[0].scrollHeight > list[0].clientHeight;

            this.$dropdown.toggleClass('visible', isOpen);
            this.$button.attr('aria-expanded', isOpen);
            body.attr('aria-hidden', !isOpen);

            if (isOpen) {
                CustomSelect.openDropdown = this;
                this.$dropdown.removeClass('dropdown-top');

                const dropdownRect = body[0].getBoundingClientRect();
                const viewportHeight = window.innerHeight;

                if (dropdownRect.bottom > viewportHeight) {
                    this.$dropdown.addClass('dropdown-top');
                }
                list.toggleClass('has-scroll', hasScroll);
            } else {
                if (CustomSelect.openDropdown === this) {
                    CustomSelect.openDropdown = null;
                }
            }
        }

        closeDropdown() {
            this.toggleDropdown(false);
        }

        selectOption(item) {
            const value = item.data('value');
            const text = item.text();

            this.$listItems.removeClass('selected').attr('aria-checked', 'false');
            item.addClass('selected').attr('aria-checked', 'true');

            this.$button.addClass('selected');
            this.$buttonText.text(text);

            this.$input.val(value).trigger('change');

            this.closeDropdown();
        }

        restoreInitialState() {
            this.$input.val(this.initialValue);
            this.$buttonText.text(this.initialText);

            this.$listItems.removeClass('selected').attr('aria-checked', 'false');
            const initialItem = this.$listItems.filter((_, el) => $(el).data('value') == this.initialValue);

            if (initialItem.length) {
                initialItem.addClass('selected').attr('aria-checked', 'true');
                this.$button.addClass('selected');
            } else {
                this.$button.removeClass('selected');
            }
        }

        syncStateWithInput() {
            const currentValue = this.$input.val();
            const currentItem = this.$listItems.filter((_, el) => $(el).data('value') == currentValue);

            if (currentItem.length) {
                this.$listItems.removeClass('selected').attr('aria-checked', 'false');
                currentItem.addClass('selected').attr('aria-checked', 'true');
                this.$buttonText.text(currentItem.text());
                this.$button.addClass('selected');
            }
        }
    }

    $('.dropdown').each((index, element) => {
        new CustomSelect(element);
    });

    // Calendar 
    if ($('.selection__form').length > 0) {
        if (typeof window.VanillaCalendarPro === 'undefined') return;

        const { Calendar } = window.VanillaCalendarPro;
        const $form = $('.selection__form');
        const $dateFrom = $form.find('input[name="date_from"]');
        const $dateTo = $form.find('input[name="date_to"]');
        const $noDateCheckbox = $form.find('input[name="no_date"]');

        const calendars = {
            from: null,
            to: null
        };

        function parseDate(dateStr) {
            if (!dateStr) return null;
            const parts = dateStr.split('.');
            if (parts.length !== 3) return null;
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }

        const calendarOptions = {
            inputMode: true,
            positionToInput: 'auto',
            parentMode: document.body,
            selectedTheme: 'light',
            locale: "ru-RU",
            dateMin: new Date().toISOString().split('T')[0],
            dateDisplay: 'DD.MM.YYYY',
            onChangeToInput(self) {
                const input = self.context.inputElement;
                if (!input) return;

                const $input = $(input);
                const isFrom = $input.attr('name') === 'date_from';
                const $parent = $input.closest('.form__field');
                const $clearBtn = $parent.find('.form__field-clear');

                if (self.context.selectedDates.length > 0) {
                    const selectedDate = self.context.selectedDates[0];
                    const dateParts = selectedDate.split('-');
                    const formattedDate = `${dateParts[2]}.${dateParts[1]}.${dateParts[0]}`;

                    $input.val(formattedDate);
                    $clearBtn.removeClass('hidden');

                    if (isFrom && calendars.to) {
                        calendars.to.dateMin = selectedDate;
                        calendars.to.update();
                    } else if (!isFrom && calendars.from) {
                        calendars.from.dateMax = selectedDate;
                        calendars.from.update();
                    }

                    self.hide();
                } else {
                    $input.val('');
                    $clearBtn.addClass('hidden');

                    if (isFrom && calendars.to) {
                        calendars.to.dateMin = new Date().toISOString().split('T')[0];
                        calendars.to.update();
                    } else if (!isFrom && calendars.from) {
                        calendars.from.dateMax = '2470-12-31';
                        calendars.from.update();
                    }
                }
            },
        };

        const valFrom = parseDate($dateFrom.val());
        const valTo = parseDate($dateTo.val());

        calendars.from = new Calendar($dateFrom[0], {
            ...calendarOptions,
            selectedDates: valFrom ? [valFrom] : [],
            dateMax: valTo ? valTo : '2470-12-31'
        });

        calendars.to = new Calendar($dateTo[0], {
            ...calendarOptions,
            selectedDates: valTo ? [valTo] : [],
            dateMin: valFrom ? valFrom : new Date().toISOString().split('T')[0]
        });

        calendars.from.init();
        calendars.to.init();


        $form.on('click', '.form__field-clear', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = $(this);
            const $parent = $btn.closest('.form__field');
            const $input = $parent.find('input');
            const inputName = $input.attr('name');

            $input.val('');
            if ($input[0]) {
                $input[0].value = '';
            }

            $btn.addClass('hidden');

            if (inputName === 'date_from' && calendars.from) {
                calendars.from.context.selectedDates = [];
                calendars.from.update();

                if (calendars.to) {
                    calendars.to.dateMin = new Date().toISOString().split('T')[0];
                    calendars.to.update();
                }
            } else if (inputName === 'date_to' && calendars.to) {
                calendars.to.context.selectedDates = [];
                calendars.to.update();

                if (calendars.from) {
                    calendars.from.dateMax = '2470-12-31';
                    calendars.from.update();
                }
            }

            return false;
        });

        function toggleDateInputs() {
            const isNoDate = $noDateCheckbox.is(':checked');
            const $dateFields = $dateFrom.add($dateTo).closest('.form__field');

            if (isNoDate) {
                $dateFields.addClass('disabled');
                $dateFrom.add($dateTo).val('').prop('disabled', true);
                $form.find('.form__field-clear').addClass('hidden');

                if (calendars.from && calendars.to) {
                    calendars.from.context.selectedDates = [];
                    calendars.to.context.selectedDates = [];
                    calendars.from.dateMax = '2470-12-31';
                    calendars.to.dateMin = new Date().toISOString().split('T')[0];

                    calendars.from.update();
                    calendars.to.update();
                    calendars.from.hide();
                    calendars.to.hide();
                }
            } else {
                $dateFields.removeClass('disabled');
                $dateFrom.add($dateTo).prop('disabled', false);
                $dateFrom.add($dateTo).each(function () {
                    if ($(this).val()) {
                        $(this).closest('.form__field').find('.form__field-clear').removeClass('hidden');
                    }
                });
            }
        }

        $noDateCheckbox.on('change', toggleDateInputs);
        toggleDateInputs();
    }

    // Booking Form
    if ($('.tour__booking-form').length > 0) {
        const $form = $('.tour__booking-form');
        const $passengersContainer = $('.booking-form__passengers');

        function initPassengerCalendar(input) {
            if (typeof window.VanillaCalendarPro === 'undefined' || !input) return;
            if (input.dataset.calendarInitialized) return;

            const { Calendar } = window.VanillaCalendarPro;

            const cal = new Calendar(input, {
                inputMode: true,
                positionToInput: 'auto',
                parentMode: document.body,
                selectedTheme: 'light',
                locale: "ru-RU",
                dateMin: '1920-01-01',
                dateMax: new Date().toISOString().split('T')[0],
                dateDisplay: 'DD.MM.YYYY',
                onChangeToInput(self) {
                    if (self.context.selectedDates.length > 0) {
                        const selectedDate = self.context.selectedDates[0];
                        const [year, month, day] = selectedDate.split('-');
                        input.value = `${day}.${month}.${year}`;

                        $(input).closest('.form__field').removeClass('has-error').find('.form__field-error').remove();
                        self.hide();
                    }
                },
            });

            cal.init();
            input.dataset.calendarInitialized = 'true';
        }

        function updatePassengerIndices() {
            $passengersContainer.find('.booking-form__block').each(function (index) {
                const passengerNumber = index + 1;
                const $block = $(this);

                $block.find('.booking-form__caption').text('Пассажир ' + passengerNumber);

                $block.find('input').each(function () {
                    const $input = $(this);
                    const placeholder = ($input.attr('placeholder') || '').toLowerCase();

                    let fieldName = '';
                    if (placeholder.includes('фамилия')) fieldName = 'last_name';
                    else if (placeholder.includes('имя')) fieldName = 'first_name';
                    else if (placeholder.includes('отчество')) fieldName = 'middle_name';
                    else if (placeholder.includes('рождения')) fieldName = 'birth_date';

                    if (fieldName) {
                        $input.attr('name', `passengers[${index}][${fieldName}]`);
                        if (fieldName === 'birth_date') {
                            initPassengerCalendar($input[0]);
                        }
                    }
                });
            });
        }

        $('.tour__booking-btn').on('click', function (e) {
            e.preventDefault();
            $form.stop().slideToggle(400);
        });

        $passengersContainer.on('click', '.booking-form__add', function () {
            const $currentBlock = $(this).closest('.booking-form__block');
            const $newBlock = $currentBlock.clone();

            $newBlock.find('input').val('').removeAttr('data-calendar-initialized');
            $newBlock.find('.form__field').removeClass('has-error');
            $newBlock.find('.form__field-error').remove();

            $newBlock.appendTo($passengersContainer);
            updatePassengerIndices();
        });

        $passengersContainer.on('click', '.booking-form__remove', function () {
            if ($('.booking-form__block').length > 1) {
                $(this).closest('.booking-form__block').remove();
                updatePassengerIndices();
            }
        });

        $form.on('input change', '.has-error input, .has-error textarea', function () {
            const $parent = $(this).closest('.form__field, .checkbox');
            $parent.removeClass('has-error');
            $parent.find('.form__field-error').remove();
        });

        $form.on('submit', function (e) {
            e.preventDefault();
            let isValid = true;
            const $requiredFields = $form.find('[data-required]');

            $form.find('.form__field, .checkbox').removeClass('has-error');
            $form.find('.form__field-error').remove();

            $requiredFields.each(function () {
                const $input = $(this);
                const $parent = $input.closest('.form__field');
                if (!($input.val() || '').trim()) {
                    isValid = false;
                    $parent.addClass('has-error').append('<div class="form__field-error">Заполните это поле</div>');
                }
            });

            if (!$form.find('.checkbox__input').is(':checked')) {
                isValid = false;
                $form.find('.checkbox').addClass('has-error');
            }

            if (!isValid) {
                const $firstError = $('.has-error').first();
                if ($firstError.length) {
                    $('html, body').animate({ scrollTop: $firstError.offset().top - 100 }, 500);
                }
                return false;
            }

            const $submitBtn = $form.find('.booking-form__submit');
            const formUrl = $form.attr('action');

            $submitBtn.addClass('_loading');

            $.ajax({
                url: formUrl,
                type: 'POST',
                dataType: 'json',
                data: $form.serialize() + '&action=send_booking_form',
                success: function (response) {
                    $submitBtn.removeClass('_loading');

                    if (response.success) {
                        getSuccessSubmitting();

                        $form[0].reset();
                        $passengersContainer.find('.booking-form__block:not(:first)').remove();
                        updatePassengerIndices();

                        $form.slideUp(400);
                    } else {
                        getErrorSubmitting();
                    }
                },
                error: function () {
                    $submitBtn.removeClass('_loading');
                    getErrorSubmitting();
                }
            });
        });

        $('.js-anchor-booking').on('click', function (e) {
            if ($form.is(':hidden')) {
                $form.stop().slideDown(400);
            }
        });

        updatePassengerIndices();
    }

    function getSuccessSubmitting() {
        Fancybox.close();
        Fancybox.show([{
            src: "#success-submitting",
            type: "inline"
        }]);
    }

    function getErrorSubmitting() {
        Fancybox.close();
        Fancybox.show([{
            src: "#error-submitting",
            type: "inline"
        }]);
    }

    document.addEventListener('wpcf7mailsent', function () {

        getSuccessSubmitting()
    }, false);

    document.addEventListener('wpcf7mailfailed', function () {
        getErrorSubmitting()
    }, false);
})

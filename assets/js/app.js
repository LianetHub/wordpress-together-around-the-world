"use strict";


const initApp = () => {

    if (typeof $ === "undefined" || typeof Swiper === "undefined" || typeof Fancybox === "undefined") {
        return false;
    }

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


        // Open/close the mobile menu
        if ($target.closest('.icon-menu').length) {
            $('.icon-menu').toggleClass("active");
            $('.menu').toggleClass("menu--open");
            $('body').toggleClass('menu-lock');
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
                const $parent = $input.closest('.form__field');
                const $clearBtn = $parent.find('.form__field-clear');

                if (self.context.selectedDates.length > 0) {
                    const dateParts = self.context.selectedDates[0].split('-');
                    const formattedDate = `${dateParts[2]}.${dateParts[1]}.${dateParts[0]}`;

                    $input.val(formattedDate);
                    $clearBtn.removeClass('hidden');
                    self.hide();
                } else {
                    $input.val('');
                    $clearBtn.addClass('hidden');
                }
            },
        };

        // Читаем даты из инпутов (для GET параметров)
        const valFrom = parseDate($dateFrom.val());
        const valTo = parseDate($dateTo.val());

        // Создаем экземпляры с предустановленными датами
        const calFrom = new Calendar($dateFrom[0], {
            ...calendarOptions,
            selectedDates: valFrom ? [valFrom] : []
        });

        const calTo = new Calendar($dateTo[0], {
            ...calendarOptions,
            selectedDates: valTo ? [valTo] : []
        });

        calFrom.init();
        calTo.init();

        // Логика кнопки очистки
        $form.on('click', '.form__field-clear', function (e) {
            e.preventDefault();
            const $btn = $(this);
            const $parent = $btn.closest('.form__field');
            const $input = $parent.find('input');

            $input.val('');
            $btn.addClass('hidden');

            if ($input.attr('name') === 'date_from') {
                calFrom.context.selectedDates = [];
                calFrom.update();
            } else {
                calTo.context.selectedDates = [];
                calTo.update();
            }
        });

        function toggleDateInputs() {
            const isNoDate = $noDateCheckbox.is(':checked');
            const $dateFields = $dateFrom.add($dateTo).closest('.form__field');

            if (isNoDate) {
                $dateFields.addClass('disabled');
                $dateFrom.add($dateTo).val('').prop('disabled', true);
                $form.find('.form__field-clear').addClass('hidden');

                calFrom.context.selectedDates = [];
                calTo.context.selectedDates = [];
                calFrom.update();
                calTo.update();

                calFrom.hide();
                calTo.hide();
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

    return true;

}

const runAppInit = () => {
    if (initApp()) return;

    const checkLibs = setInterval(() => {
        if (initApp()) {
            clearInterval(checkLibs);
        }
    }, 100);

    setTimeout(() => clearInterval(checkLibs), 10000);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runAppInit);
} else {
    runAppInit();
}
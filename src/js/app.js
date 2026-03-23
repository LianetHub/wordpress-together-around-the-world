"use strict";

// const { default: Swiper } = require("swiper");

// const { Calendar } = require("vanilla-calendar-pro");

$(function () {



    // Smooth Scroll Anchors
    $('a[href^="#"]').not('[data-fancybox]').on('click', function (event) {
        const href = this.getAttribute('href');

        if (href === '#') return;

        const target = $(href);
        const header = $('.header');

        if (target.length) {
            event.preventDefault();

            const headerHeight = header.outerHeight() || 0;
            const targetPosition = target.offset().top - headerHeight;

            $('html, body').stop().animate({
                scrollTop: targetPosition
            }, 800);
        }
    });

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

    // Spollers
    // class Spollers {
    //     constructor() {
    //         this.$spollersArray = $("[data-spollers]");
    //         if (this.$spollersArray.length > 0) {
    //             this.init();
    //         }
    //     }

    //     init() {
    //         const $spollersRegular = this.$spollersArray.filter((index, item) => {
    //             return !$(item).data("spollers").split(",")[0];
    //         });

    //         if ($spollersRegular.length > 0) {
    //             this.initSpollers($spollersRegular);
    //         }

    //         const $spollersMedia = this.$spollersArray.filter((index, item) => {
    //             return $(item).data("spollers").split(",")[0];
    //         });

    //         if ($spollersMedia.length > 0) {
    //             this.initMediaSpollers($spollersMedia);
    //         }
    //     }

    //     initMediaSpollers($spollersMedia) {
    //         const breakpointsArray = [];
    //         $spollersMedia.each(function () {
    //             const params = $(this).data("spollers");
    //             const paramsArray = params.split(",");
    //             breakpointsArray.push({
    //                 value: paramsArray[0],
    //                 type: paramsArray[1] ? paramsArray[1].trim() : "max",
    //                 item: $(this)
    //             });
    //         });

    //         let mediaQueries = breakpointsArray.map((item) => {
    //             return `(${item.type}-width: ${item.value}px),${item.value},${item.type}`;
    //         });
    //         mediaQueries = [...new Set(mediaQueries)];

    //         mediaQueries.forEach((breakpoint) => {
    //             const paramsArray = breakpoint.split(",");
    //             const mediaBreakpoint = paramsArray[1];
    //             const mediaType = paramsArray[2];
    //             const matchMedia = window.matchMedia(paramsArray[0]);

    //             const filteredSpollers = breakpointsArray.filter((item) => {
    //                 return item.value === mediaBreakpoint && item.type === mediaType;
    //             });

    //             matchMedia.addEventListener("change", () => {
    //                 this.initSpollers(filteredSpollers, matchMedia);
    //             });
    //             this.initSpollers(filteredSpollers, matchMedia);
    //         });
    //     }

    //     initSpollers(spollersArray, matchMedia = false) {
    //         const items = Array.isArray(spollersArray) ? spollersArray : spollersArray.toArray();

    //         items.forEach((spollerItem) => {
    //             const $spollersBlock = matchMedia ? spollerItem.item : $(spollerItem);
    //             if (!matchMedia || matchMedia.matches) {
    //                 $spollersBlock.addClass("_init");
    //                 this.initSpollerBody($spollersBlock, true);
    //                 $spollersBlock.off("click", "[data-spoller]").on("click", "[data-spoller]", (e) => this.setSpollerAction(e));
    //             } else {
    //                 $spollersBlock.removeClass("_init");
    //                 this.initSpollerBody($spollersBlock, false);
    //                 $spollersBlock.off("click", "[data-spoller]");
    //             }
    //         });
    //     }

    //     initSpollerBody($spollersBlock, hideSpollerBody = true) {
    //         const $spollerTitles = $spollersBlock.find("[data-spoller]");
    //         if ($spollerTitles.length > 0) {
    //             $spollerTitles.each(function () {
    //                 const $title = $(this);
    //                 const $body = $title.next();
    //                 const $parent = $title.parent();
    //                 if (hideSpollerBody) {
    //                     $title.removeAttr("tabindex");
    //                     if (!$title.hasClass("_active")) {
    //                         $body.hide();
    //                         $parent.removeClass("_spoller-open");
    //                     } else {
    //                         $parent.addClass("_spoller-open");
    //                     }
    //                 } else {
    //                     $title.attr("tabindex", "-1");
    //                     $body.show();
    //                     $parent.removeClass("_spoller-open");
    //                 }
    //             });
    //         }
    //     }

    //     setSpollerAction(e) {
    //         const $el = $(e.target);
    //         const $spollerTitle = $el.has("[data-spoller]") ? $el : $el.closest("[data-spoller]");
    //         const $spollersBlock = $spollerTitle.closest("[data-spollers]");
    //         const isOneSpoller = $spollersBlock.is("[data-one-spoller]");
    //         const $body = $spollerTitle.next();
    //         const $parent = $spollerTitle.parent();

    //         if (!$spollersBlock.find(":animated").length) {
    //             if (isOneSpoller && !$spollerTitle.hasClass("_active")) {
    //                 this.hideSpollersBody($spollersBlock);
    //             }

    //             $spollerTitle.toggleClass("_active");
    //             $parent.toggleClass("_spoller-open");
    //             $body.slideToggle(300);
    //         }
    //         e.preventDefault();
    //     }

    //     hideSpollersBody($spollersBlock) {
    //         const $activeTitle = $spollersBlock.find("[data-spoller]._active");
    //         if ($activeTitle.length) {
    //             $activeTitle.removeClass("_active");
    //             $activeTitle.parent().removeClass("_spoller-open");
    //             $activeTitle.next().slideUp(300);
    //         }
    //     }
    // }

    // window.spollers = new Spollers();


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
    // const { Calendar } = window.VanillaCalendarPro;
    // const bookingCalendar = new Calendar('#booking-calendar', {
    //     type: 'default',
    //     locale: "ru-RU"
    // });
    // bookingCalendar.init();

    // Calendar



})


"use strict";

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

    // Form Controller

    // class FormController {
    //     constructor() {
    //         this.selectors = {
    //             field: '.form__field',
    //             errorClass: '_error',
    //             loadingClass: '_loading',
    //             requiredAttr: '[data-required]',
    //             fileInput: '.form__file-input',
    //             fileContainer: '.form__file',
    //             fileRemove: '.form__file-remove',
    //             submitBtn: '[type="submit"]'
    //         };
    //         this.init();
    //     }

    //     init() {
    //         const self = this;

    //         $('form').each(function () {
    //             self.bindSubmit($(this));
    //         });

    //         $(document).on('input change', this.selectors.requiredAttr, (e) => {
    //             const $field = $(e.target);
    //             if ($field.hasClass(this.selectors.errorClass) || $field.closest(this.selectors.field).hasClass(this.selectors.errorClass)) {
    //                 this.toggleErrorState($field, true);
    //             }
    //         });

    //         $(document).on('keydown', 'input[type="tel"]', (e) => this.onPhoneKeyDown(e));
    //         $(document).on('input', 'input[type="tel"]', (e) => this.onPhoneInput(e));
    //         $(document).on('paste', 'input[type="tel"]', (e) => this.onPhonePaste(e));
    //         $(document).on('focus', 'input[type="tel"]', (e) => {
    //             if (!e.target.value) {
    //                 e.target.value = "+7 ";
    //             }
    //         });

    //         $(document).off('change', this.selectors.fileInput).on('change', this.selectors.fileInput, (e) => this.handleFileChange(e));
    //         $(document).off('click', this.selectors.fileRemove).on('click', this.selectors.fileRemove, (e) => this.handleFileRemove(e));
    //     }

    //     bindSubmit($form) {
    //         $form.on('submit', async (e) => {
    //             e.preventDefault();

    //             if (this.validateForm($form)) {
    //                 await this.sendForm($form);
    //             }
    //         });
    //     }

    //     async sendForm($form, isSilent = false) {
    //         console.log('submit from form controller');
    //         const url = $form.attr('action');
    //         const method = $form.attr('method') || 'POST';
    //         const formData = new FormData($form[0]);
    //         formData.append('page_url', window.location.href);
    //         const $submitBtn = $form.find(this.selectors.submitBtn);

    //         $submitBtn.addClass(this.selectors.loadingClass);

    //         try {
    //             const response = await fetch(url, {
    //                 method: method,
    //                 body: formData
    //             });

    //             if (response.ok) {
    //                 const result = await response.json();

    //                 if (result.success) {

    //                     $form[0].reset();
    //                     $form.find('.form__file-preview').remove();
    //                     $form.find('.uploaded').removeClass('uploaded');

    //                     if (!isSilent) {
    //                         const instance = Fancybox.getInstance();
    //                         if (instance) {
    //                             instance.destroy();
    //                         }

    //                         let successPopupId = "#success-submitting";

    //                         Fancybox.show([{
    //                             src: successPopupId,
    //                             type: "inline"
    //                         }]);
    //                     }

    //                 } else {
    //                     console.error('Ошибка логики сервера:', result.data.message);
    //                     this.showErrorPopup();
    //                 }
    //             } else {
    //                 console.error('Ошибка сервера (HTTP статус)');
    //                 this.showErrorPopup();
    //             }
    //         } catch (error) {
    //             console.error('Ошибка сети', error);
    //             this.showErrorPopup();
    //         } finally {
    //             $submitBtn.removeClass(this.selectors.loadingClass);
    //         }
    //     }

    //     showErrorPopup() {
    //         const instance = Fancybox.getInstance();
    //         if (instance) {
    //             instance.destroy();
    //         }
    //         Fancybox.show([{
    //             src: "#error-submitting",
    //             type: "inline"
    //         }]);
    //     }

    //     validateField($field) {
    //         if (!$field.is(':visible')) {
    //             this.toggleErrorState($field, true);
    //             return true;
    //         }

    //         const type = $field.attr('type');
    //         const name = $field.attr('name');
    //         const val = $field.val() ? $field.val().trim() : '';
    //         let isValid = true;

    //         if (type === 'checkbox') {
    //             isValid = $field.is(':checked');
    //         } else if (name === 'username') {
    //             isValid = /^[^\d]+$/.test(val) && val.length > 1;
    //         } else if (type === 'tel') {
    //             const numbers = val.replace(/\D/g, '');
    //             isValid = numbers.length >= 11;
    //         } else if (type === 'email') {
    //             isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    //         } else if (name === 'city') {
    //             isValid = val.length >= 2;
    //         } else if (name === 'address') {
    //             isValid = val.length >= 5;
    //         } else {
    //             isValid = val !== '';
    //         }

    //         this.toggleErrorState($field, isValid);
    //         return isValid;
    //     }

    //     toggleErrorState($field, isValid) {
    //         $field.closest(this.selectors.field).toggleClass(this.selectors.errorClass, !isValid);
    //         $field.toggleClass(this.selectors.errorClass, !isValid);
    //     }

    //     validateForm($form) {
    //         let isAllValid = true;
    //         const self = this;

    //         $form.find(this.selectors.requiredAttr).each(function () {
    //             if (!self.validateField($(this))) {
    //                 isAllValid = false;
    //             }
    //         });

    //         return isAllValid;
    //     }

    //     handleFileChange(e) {
    //         const $input = $(e.currentTarget);
    //         const $container = $input.closest(this.selectors.fileContainer);
    //         const file = e.target.files[0];
    //         const maxSize = 10 * 1024 * 1024;

    //         $container.find('.form__error').remove();

    //         if (file && file.size > maxSize) {
    //             $input.val('');
    //             $container.append('<span class="form__error">Файл слишком большой. <br> Максимальный размер — 10 МБ.</span>');
    //             $container.removeClass('uploaded');
    //             $container.find('.form__file-preview').remove();
    //             return;
    //         }

    //         $container.find('.form__file-preview').remove();
    //         $container.removeClass('uploaded');

    //         if (file) {
    //             const isImage = file.type.match('image.*');
    //             const reader = new FileReader();

    //             reader.onload = (event) => {
    //                 let previewContent = '';
    //                 if (isImage) {
    //                     previewContent = `
    //             <span class="form__file-image">
    //                 <img src="${event.target.result}" alt="Превью" class="cover-image">
    //             </span>
    //         `;
    //                 }
    //                 const previewHtml = `
    //         <div class="form__file-preview">
    //             ${previewContent}
    //             <span class="form__file-name">${file.name}</span>
    //             <button type="button" aria-label="Удалить" class="form__file-remove icon-cross"></button>
    //         </div>
    //     `;
    //                 $container.append(previewHtml);
    //                 $container.addClass('uploaded');
    //             };
    //             reader.readAsDataURL(file);
    //         }
    //     }
    //     handleFileRemove(e) {
    //         e.preventDefault();
    //         e.stopPropagation();

    //         const $btn = $(e.currentTarget);
    //         const $container = $btn.closest(this.selectors.fileContainer);
    //         const $preview = $btn.closest('.form__file-preview');

    //         $container.find(this.selectors.fileInput).val('');
    //         $container.removeClass('uploaded');
    //         $preview.remove();
    //     }

    //     onPhoneInput(e) {
    //         const input = e.target;
    //         let inputNumbersValue = input.value.replace(/\D/g, '');
    //         const selectionStart = input.selectionStart;
    //         let formattedInputValue = "";

    //         if (!inputNumbersValue) {
    //             return input.value = "";
    //         }

    //         if (input.value.length != selectionStart) {
    //             if (e.originalEvent.data && /\D/g.test(e.originalEvent.data)) {
    //                 input.value = inputNumbersValue;
    //             }
    //             return;
    //         }

    //         if (inputNumbersValue.length > 11) {
    //             inputNumbersValue = inputNumbersValue.substring(0, 11);
    //         }

    //         formattedInputValue = "+7 (";

    //         if (inputNumbersValue.length >= 2) {
    //             formattedInputValue += inputNumbersValue.substring(1, 4);
    //         }
    //         if (inputNumbersValue.length >= 5) {
    //             formattedInputValue += ") " + inputNumbersValue.substring(4, 7);
    //         }
    //         if (inputNumbersValue.length >= 8) {
    //             formattedInputValue += "-" + inputNumbersValue.substring(7, 9);
    //         }
    //         if (inputNumbersValue.length >= 10) {
    //             formattedInputValue += "-" + inputNumbersValue.substring(9, 11);
    //         }

    //         input.value = formattedInputValue;
    //     }

    //     onPhoneKeyDown(e) {
    //         const inputValue = e.target.value.replace(/\D/g, '');
    //         if (e.keyCode == 8 && inputValue.length == 1) {
    //             e.target.value = "";
    //         }
    //     }

    //     onPhonePaste(e) {
    //         const input = e.target;
    //         const inputNumbersValue = input.value.replace(/\D/g, '');
    //         const pasted = e.originalEvent.clipboardData || window.clipboardData;
    //         if (pasted) {
    //             const pastedText = pasted.getData('Text');
    //             if (/\D/g.test(pastedText)) {
    //                 input.value = inputNumbersValue;
    //             }
    //         }
    //     }
    // }

    // window.formController = new FormController();

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



})


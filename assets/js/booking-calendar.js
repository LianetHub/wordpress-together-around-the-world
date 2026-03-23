"use strict";

const initBookingCalendar = () => {
    if (!window.VanillaCalendarPro || !window.Swiper || !window.calendarData) {
        return false;
    }

    const { Calendar } = window.VanillaCalendarPro;
    const sidePanel = document.querySelector('#calendar-side-panel');
    const prevBtn = document.querySelector('.booking-calendar__prev');
    const nextBtn = document.querySelector('.booking-calendar__next');
    const monthDisplay = document.querySelector('.booking-calendar__month');
    const calendarContent = document.querySelector('.booking-calendar__content');

    if (!calendarContent) return true;

    const rawTours = window.calendarData.tours || {};
    const todayStr = new Date().toISOString().split('T')[0];

    const allTours = {};
    for (const date in rawTours) {
        if (date >= todayStr) {
            allTours[date] = rawTours[date];
        }
    }

    let currentFilter = 'all';
    let activeDate = null;
    let filterSwiper = null;

    if (document.querySelector('.booking-calendar__filters .swiper')) {
        filterSwiper = new Swiper('.booking-calendar__filters .swiper', {
            slidesPerView: "auto",
            spaceBetween: 4,
            watchOverflow: true,
            slideToClickedSlide: true,
            centeredSlides: false,
            navigation: {
                prevEl: ".booking-calendar__filters-prev",
                nextEl: ".booking-calendar__filters-next",
            },
            freeMode: {
                enabled: true,
                sticky: true,
            }
        });
    }

    const renderSidePanel = (dateString) => {
        const dayTours = allTours[dateString] || [];
        const tours = dayTours.filter(t => currentFilter === 'all' || String(t.cat_id) === String(currentFilter));

        if (!dateString || tours.length === 0) {
            sidePanel.innerHTML = '<div class="booking-calendar__empty">На этот день запланированных туров пока нет.</div>';
            return;
        }

        const parts = dateString.split('-');
        const formattedDate = `${parts[2]}.${parts[1]}.${parts[0]}`;

        let html = `<div class="booking-calendar__caption">Туры с отправлением ${formattedDate}</div>`;
        html += '<ul class="booking-calendar__list tours-list">';
        tours.forEach(tour => {
            html += `
                <li class="tours-list__item">
                    <a href="${tour.link}" class="tours-list__link">
                        <span class="tours-list__main">
                            <span class="tours-list__name">${tour.title}</span>
                            <span class="tours-list__duration">${tour.duration}</span>
                        </span>
                        <span class="tours-list__price">${tour.price} р</span>
                    </a>
                </li>`;
        });
        html += '</ul>';
        sidePanel.innerHTML = html;
    };

    const updateControls = (self) => {
        const todayDate = new Date();
        const currentYear = todayDate.getFullYear();
        const currentMonth = todayDate.getMonth();
        const viewYear = self.selectedYear;
        const viewMonth = self.selectedMonth;

        if (prevBtn) {
            if (viewYear < currentYear || (viewYear === currentYear && viewMonth <= currentMonth)) {
                prevBtn.setAttribute('disabled', 'true');
            } else {
                prevBtn.removeAttribute('disabled');
            }
        }

        if (monthDisplay) {
            const date = new Date(viewYear, viewMonth);
            let monthName = date.toLocaleString('ru-RU', { month: 'long' });
            monthName = monthName.charAt(0).toUpperCase() + monthName.slice(1);
            monthDisplay.textContent = viewYear > currentYear ? `${monthName} ${viewYear}` : monthName;
        }
    };

    const syncCalendarState = () => {
        const enabledDates = [];
        for (const date in allTours) {
            const matches = allTours[date].filter(t => currentFilter === 'all' || String(t.cat_id) === String(currentFilter));
            if (matches.length) enabledDates.push(date);
        }

        const prefix = `${calendar.selectedYear}-${String(calendar.selectedMonth + 1).padStart(2, '0')}`;
        const datesInMonth = enabledDates.filter(d => d.startsWith(prefix)).sort();

        if (datesInMonth.length > 0) {
            activeDate = datesInMonth[0];
            calendar.set({
                enableDates: enabledDates,
                selectedDates: [activeDate]
            });
        } else {
            activeDate = null;
            calendar.set({
                enableDates: enabledDates,
                selectedDates: []
            });
        }

        calendar.update();
        renderSidePanel(activeDate);
        updateControls(calendar);
    };

    const availableDates = Object.keys(allTours).sort();
    let startYear = new Date().getFullYear();
    let startMonth = new Date().getMonth();

    if (availableDates.length > 0) {
        const [y, m] = availableDates[0].split('-');
        startYear = parseInt(y, 10);
        startMonth = parseInt(m, 10) - 1;
    }

    const calendar = new Calendar('#booking-calendar', {
        type: 'default',
        locale: 'ru-RU',
        selectionDatesMode: 'single',
        dateMin: todayStr,
        disableAllDates: true,
        enableDates: availableDates,
        selectedYear: startYear,
        selectedMonth: startMonth,
        onInit(self) {
            syncCalendarState();
        },
        onClickDate(self, event) {
            const dayBtn = event.target.closest('[data-vc-date]');
            const clickedDate = dayBtn ? dayBtn.dataset.vcDate : null;

            if (!clickedDate || !self.enableDates.includes(clickedDate)) {
                self.set({ selectedDates: [activeDate] });
                self.update();
                return;
            }

            activeDate = clickedDate;
            self.set({ selectedDates: [activeDate] });
            self.update();
            renderSidePanel(activeDate);
        },
        onCreateDateEls(self, dateEl) {
            const date = dateEl.dataset.calendarDate;
            if (allTours[date]) {
                dateEl.classList.add('has-tour');
                const innerBtn = dateEl.querySelector('button');
                if (innerBtn) innerBtn.style.pointerEvents = 'none';
            }
        }
    });

    calendar.init();

    if (calendarContent) {
        calendarContent.classList.add('is-loaded');
    }

    if (prevBtn) {
        prevBtn.onclick = () => {
            if (prevBtn.hasAttribute('disabled')) return;
            calendar.selectedMonth -= 1;
            if (calendar.selectedMonth < 0) {
                calendar.selectedMonth = 11;
                calendar.selectedYear -= 1;
            }
            syncCalendarState();
        };
    }

    if (nextBtn) {
        nextBtn.onclick = () => {
            calendar.selectedMonth += 1;
            if (calendar.selectedMonth > 11) {
                calendar.selectedMonth = 0;
                calendar.selectedYear += 1;
            }
            syncCalendarState();
        };
    }

    document.querySelectorAll('.booking-calendar__filter').forEach((btn, index) => {
        btn.onclick = (e) => {
            e.preventDefault();
            document.querySelector('.booking-calendar__filter.active')?.classList.remove('active');
            btn.classList.add('active');
            if (filterSwiper) filterSwiper.slideTo(index);
            currentFilter = btn.getAttribute('data-id') || 'all';
            syncCalendarState();
        };
    });

    return true;
};

const runInitialization = () => {
    if (initBookingCalendar()) {
        console.log('Calendar initialized');
        return true;
    }
    
    const checkReady = setInterval(() => {
        if (initBookingCalendar()) {
            clearInterval(checkReady);
            console.log('Calendar initialized via interval');
        }
    }, 100);

    setTimeout(() => {
        clearInterval(checkReady);
    }, 10000);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runInitialization);
} else {
    runInitialization();
}
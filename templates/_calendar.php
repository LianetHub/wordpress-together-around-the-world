<?php
$tours_debug = get_all_tours_data();
?>
<section class="booking-calendar">
    <div class="container">
        <h2 class="booking-calendar__title title text-center">Календарь туров</h2>
        <div class="booking-calendar__header">
            <div class="booking-calendar__filters">
                <a href="#" class="booking-calendar__filter active" data-id="all">Все туры</a>
                <?php
                $categories = get_categories(['taxonomy' => 'category', 'hide_empty' => true]);
                foreach ($categories as $cat) : ?>
                    <a href="#" class="booking-calendar__filter" data-id="<?php echo $cat->term_id; ?>">
                        <?php echo $cat->name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="booking-calendar__controls">
                <button type="button" class="booking-calendar__prev icon-chevron-left"></button>
                <div class="booking-calendar__month">
                    <?php
                    $current_date = new DateTime();
                    $formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                    $formatter->setPattern('LLLL');
                    echo mb_convert_case($formatter->format($current_date), MB_CASE_TITLE, "UTF-8");
                    ?>
                </div>
                <button type="button" class="booking-calendar__next icon-chevron-right"></button>
            </div>
        </div>
        <div class="booking-calendar__content">
            <div class="booking-calendar__block">
                <div id="booking-calendar"></div>
            </div>
            <div class="booking-calendar__side" id="calendar-side-panel">
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const {
                Calendar
            } = window.VanillaCalendarPro;
            const monthDisplay = document.querySelector('.booking-calendar__month');
            const sidePanel = document.querySelector('#calendar-side-panel');
            const allTours = <?php echo json_encode(get_all_tours_data()); ?>;

            let currentFilter = 'all';
            let viewMonth = new Date().getMonth();
            let viewYear = new Date().getFullYear();

            const allDates = Object.keys(allTours).sort();
            if (allDates.length > 0) {
                const [y, m] = allDates[0].split('-');
                viewYear = parseInt(y, 10);
                viewMonth = parseInt(m, 10) - 1;
            }

            const getFilteredTours = () => {
                if (currentFilter === 'all') return allTours;
                const filtered = {};
                for (const date in allTours) {
                    const matches = allTours[date].filter(t => String(t.cat_id) === String(currentFilter));
                    if (matches.length) filtered[date] = matches;
                }
                return filtered;
            };

            const updateMonthTitle = () => {
                const date = new Date(viewYear, viewMonth);
                let monthName = date.toLocaleString('ru-RU', {
                    month: 'long'
                });
                monthName = monthName.charAt(0).toUpperCase() + monthName.slice(1);
                const currentYear = new Date().getFullYear();
                monthDisplay.textContent = viewYear > currentYear ? `${monthName} ${viewYear}` : monthName;
            };

            const renderSidePanel = (dateString, tours) => {
                if (!dateString || !tours || !tours.length) {
                    sidePanel.innerHTML = '<div class="booking-calendar__empty">На этот день запланированных туров пока нет. Выберите другую дату.</div>';
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

            const selectFirstAvailable = () => {
                const filtered = getFilteredTours();
                const currentMonthPrefix = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}`;

                const datesInMonth = Object.keys(filtered)
                    .filter(d => d.startsWith(currentMonthPrefix))
                    .sort();

                const selectedDates = datesInMonth.length > 0 ? [datesInMonth[0]] : [];

                calendar.set({
                    selectedMonth: viewMonth,
                    selectedYear: viewYear,
                    selectedDates: selectedDates
                });

                if (datesInMonth.length > 0) {
                    renderSidePanel(datesInMonth[0], filtered[datesInMonth[0]]);
                } else {
                    renderSidePanel(null, null);
                }
            };

            const calendar = new Calendar('#booking-calendar', {
                type: 'default',
                locale: 'ru-RU',
                selectionDatesMode: 'single',
                dateMin: new Date().toISOString().split('T')[0],
                selectedMonth: viewMonth,
                selectedYear: viewYear,

                onInit() {
                    updateMonthTitle();
                    selectFirstAvailable();
                },

                onClickDate(self) {
                    if (self.selectedDates && self.selectedDates.length > 0) {
                        const date = self.selectedDates[0];
                        renderSidePanel(date, getFilteredTours()[date]);
                    }
                },

                onCreateDateEls(self, dateEl) {
                    const date = dateEl.dataset.calendarDate;
                    const filtered = getFilteredTours();

                    if (filtered && filtered[date]) {
                        dateEl.classList.add('has-tour');
                    } else {
                        dateEl.classList.add('vc-date_disabled');
                        const btn = dateEl.querySelector('.vc-date__btn') || dateEl.querySelector('button');
                        if (btn) btn.style.pointerEvents = 'none';
                    }
                }
            });

            calendar.init();

            document.querySelector('.booking-calendar__prev').onclick = () => {
                const now = new Date();
                const minMonth = now.getMonth();
                const minYear = now.getFullYear();

                if (viewYear > minYear || (viewYear === minYear && viewMonth > minMonth)) {
                    viewMonth--;
                    if (viewMonth < 0) {
                        viewMonth = 11;
                        viewYear--;
                    }
                    updateMonthTitle();
                    selectFirstAvailable();
                }
            };

            document.querySelector('.booking-calendar__next').onclick = () => {
                viewMonth++;
                if (viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                updateMonthTitle();
                selectFirstAvailable();
            };

            document.querySelectorAll('.booking-calendar__filter').forEach(btn => {
                btn.onclick = (e) => {
                    e.preventDefault();
                    document.querySelector('.booking-calendar__filter.active')?.classList.remove('active');
                    btn.classList.add('active');
                    currentFilter = btn.getAttribute('data-id') || 'all';

                    selectFirstAvailable();
                };
            });
        });
    </script>
</section>
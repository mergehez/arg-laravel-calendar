@props([
    "bookings" => [],
    "formAction" => "",
    "allowPast" => config("arg-calendar.booking.allowPast"),
    "bookingOptions" => config("arg-calendar.booking.options"),
    "showOccupation" => trans(config("arg-calendar.booking.showOccupation")),
    "dayNames" => trans(config("arg-calendar.localizationKeys.dayNamesShort")),
    "monthNames" => trans(config("arg-calendar.localizationKeys.monthNames")),
])

<style>
    [x-cloak] { 
        display: none !important; 
    }

    .calendar-cells *{
        aspect-ratio: 1 !important;
    }

    .calendar-hover-bg-gray:hover{
        background-color: var(--bs-gray-200) !important;
    }

    .calendar-box{
        border-width: {{ config("arg-calendar.booking.hoverBorderWidth") ?? 'initial' }};
        border-radius: {{ config("arg-calendar.booking.boxBorderRadius") ?? 'initial' }};
        @if(!$showOccupation)
            background-color: {{ config("arg-calendar.booking.boxBackColorWhenNoOccupation") ?? 'initial' }};
        @endif
    }
    .calendar-box:hover{
        border-color: {{ config("arg-calendar.booking.hoverBorderColor") ?? 'initial' }};
    }

    .calendar-row-cols-7 > *{
        width: 14.28% !important;
        flex: 0 0 auto !important;
    }
    .calendar-today{
        color: {{ config("arg-calendar.booking.todayTextColor") ?? 'initial' }};
    }
    .calendar-selected{
        border-color: {{ config("arg-calendar.booking.selectedBorderColor") ?? 'initial' }};
        border-width: {{ config("arg-calendar.booking.selectedBorderWidth") ?? 'initial' }};
    }
    .calendar-free{
        background-color: {{ config("arg-calendar.booking.freeBackColor") ?? 'initial' }};
        opacity: {{ config("arg-calendar.booking.backColorOpacity") ?? '1' }};
    }
    .calendar-occupied{
        background-color: {{ config("arg-calendar.booking.occupiedBackColor") ?? 'initial' }};
    }
</style>

<div x-cloak x-data='calendarData({
        allowPast :         @json($allowPast), 
        dayNames :          @json($dayNames),
        monthNames :        @json($monthNames),
        bookingOptions :    @json($bookingOptions), 
        bookings :          @json($bookings)
    })' class="calendar">
    <h2 class="text-center fw-bold mb-3">@lang('Availability Calendar')</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex shadow-lg">
                <div class="d-flex align-items-center col justify-content-center shadow-lg">

                    <div class="mt-12 rounded-2 p-2">

                        <div class="align-items-center d-flex justify-content-between pb-2 px-1 ps-2">
                            <div>
                                <span x-text="monthNames[month]" class="fs-3 fw-bold"></span>
                                <span x-text="year" class="ms-2 text-secondary"></span>
                            </div>
                            <div>
                                <a class="border btn btn-light calendar-hover-bg-gray p-1 rounded-circle"
                                    x-on:click="changeMonth(-1)">
                                    <svg style="height: 24px; width: 24px" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                                <a class="border btn btn-light calendar-hover-bg-gray p-1 rounded-circle"
                                    x-on:click="changeMonth(1)">
                                    <svg style="height: 24px; width: 24px" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex mb-1">
                            <div class="row m-0 calendar-row-cols-7 w-100">
                                <template x-for="day in dayNames">
                                    <div x-text="day" class="text-primary text-center small"></div>
                                </template>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="row m-0 calendar-row-cols-7 calendar-cells">
                                <template x-for="day in days_of_prev">
                                    <div class="p-2">
                                        <div x-text="day"
                                            class="lh-lg small text-center text-muted opacity-50 d-flex align-items-center justify-content-center">
                                        </div>
                                    </div>
                                </template>

                                <template x-for="day in days_of_current">
                                    <div class="p-2">
                                        <div class="btn btn-sm p-0 d-flex flex-column align-items-center justify-content-center calendar-box"
                                            x-on:click="selectDay(day.value)"
                                            :class="{ 'calendar-today': isToday(day.value), 'calendar-selected' : isSelectedDate(day.value) }"
                                            style="gap: 1px">
                                            @if($showOccupation)
                                                <template x-for="occupied in day.occupiedArr">
                                                    <div class="col w-100 calendar-free" :class="{'calendar-occupied':occupied}"></div>
                                                </template>
                                            @endif
                                            <div x-text="day.value" class="position-absolute fw-bold"></div>
                                        </div>
                                    </div>
                                </template>
                                <template x-for="day in days_of_next">
                                    <div class="p-2">
                                        <div x-text="day"
                                            class="lh-lg small text-center text-muted opacity-50 d-flex align-items-center justify-content-center">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-nowrap h-100 m-0 shadow" x-ref="panel">
                    <div class="border-2 border-danger border-start p-3" style="">
                        <h4 class="fw-bold" x-text="getSelectedStr()"></h4>
                        <div>
                            <template x-if="selectedPast">
                                <div class="text-danger">@lang('Past dates cannot be booked!') </div>
                            </template>
                            <template x-if="!selectedPast">
                                <form class="mt-3 form flex flex-column" x-ref="form" method="GET"
                                    action="{{ $formAction }}">
                                    <template x-if="selected.occupiedArr.some(t => !t)">
                                        <div>@lang('Please choose a time period:')</div>
                                    </template>
                                    <template x-if="!selected.occupiedArr.some(t => !t)">
                                        <div class="text-danger">@lang('This day is occupied.') </div>
                                    </template>
                                    <input type="hidden" name="year" x-bind:value="year">
                                    <input type="hidden" name="month" x-bind:value="month">
                                    <input type="hidden" name="day" x-bind:value="selected.date.getDate()">
                                    <input type="hidden" name="dayOfWeek" x-bind:value="selected.date.getDay()">

                                    <template x-for="opt in bookingOptions">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hours"
                                                x-bind:id="'radio-'+opt.id" x-model="opt.checked"
                                                x-bind:disabled="!isRangeFree(opt.id)">
                                            <label class="form-check-label" x-text="opt.text"
                                                :class="{ 'text-decoration-line-through text-muted' : !isRangeFree(opt.id) }"
                                                x-bind:for="'radio-'+opt.id"></label>
                                        </div>
                                    </template>

                                    <div class="text-center">
                                        <input class="btn btn-success btn-sm mt-2 px-2 align-self-center" type="submit"
                                            value="@lang(" Continue")"
                                            x-bind:disabled="!bookingOptions.some(t => t.checked)"
                                            x-on:click.prevent="submit">
                                    </div>
                                </form>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function calendarData(config) {
        return {
            dayNames: config.dayNames,
            monthNames: config.monthNames,
            month: '',
            year: '',
            days_of_current: [],
            days_of_prev: [],
            days_of_next: [],
            today: new Date(),
            selected: {
                date: new Date(),
                occupiedArr: []
            },
            allowPast: config.allowPast,
            selectedPast: false,
            bookings: config.bookings,
            bookingHours: [],
            bookingOptions: [],
            init() {
                this.today.setHours(0, 0, 0, 0);
                this.month = this.today.getMonth();
                this.year = this.today.getFullYear();
                this.selected.date = this.today;

                const hours = [];
                for (const key in config.bookingOptions) {
                    key.split("-").map(t => parseInt(t)).forEach(t => {
                        if (!hours.includes(t))
                            hours.push(t);
                    })
                    this.bookingOptions.push({
                        "id": key,
                        "text": key.replace("-", ":00 - ") + ":00 " + config.bookingOptions[key],
                        "checked": false
                    });
                }
                this.bookingHours = hours.sort((a, b) => a - b);

                this.setDaysOfCalendar();
                this.selectDay(this.today.getDate());

                document.addEventListener("DOMContentLoaded", () => {
                    this.$refs.panel.style.width = this.$refs.panel.getBoundingClientRect().width + "px";
                });
            },
            date(year, month, day) {
                return new Date(year, month, day, 0, 0, 0, 0);
            },
            getSelectedStr() {
                const date = this.selected.date;
                return this.dayNames[date.getDay()] + ", " + date.getDate() + ". " + this.monthNames[date.getMonth()] +
                    " " + date.getFullYear();
            },
            isSelectedDate(day) {
                return this.selected.date.toDateString() === this.date(this.year, this.month, day).toDateString();
            },

            isToday(day) {
                return this.today.toDateString() === this.date(this.year, this.month, day).toDateString();
            },

            isRangeFree(optId) { // for selected day
                const i1 = this.bookingHours.indexOf(parseInt(optId.split("-")[0]));
                const i2 = this.bookingHours.indexOf(parseInt(optId.split("-")[1]));
                const arr = this.selected.occupiedArr;
                for (let i = 0; i < arr.length; i++) {
                    if (arr[i] && (i1 == i || i2 == i + 1 || i > i1 && i < i2))
                        return false;
                }
                return true;
            },

            getDateByMonthChange(change) {
                let newMonth = this.month + change;
                let newYear = newMonth < 0 ? this.year - 1 : (newMonth > 11 ? this.year + 1 : this.year);
                return this.date(newYear, (newMonth + 12) % 12 + 1, 0);
            },

            changeMonth(change) {
                const d = this.getDateByMonthChange(change);
                this.month = d.getMonth();
                this.year = d.getFullYear();
                this.setDaysOfCalendar()
            },

            selectDay(day) {
                this.selected = this.days_of_current.filter(t => t.value == day).map(t => {
                    return {
                        date: this.date(this.year, this.month, t.value, 0, 0, 0),
                        occupiedArr: t.occupiedArr
                    }
                })[0];
                this.bookingOptions.forEach(t => t.checked = false);
                if (!config.allowPast && (this.selected.date.getTime() < this.today.getTime())) {
                    this.selectedPast = true;
                    // alert("Cant select past day");
                } else
                    this.selectedPast = false;
            },

            submit() {
                let checked = this.bookingOptions.filter(t => t.checked);
                if (checked.length > 0) {
                    let url = new URL(this.$refs.form.action);
                    url.searchParams.append("year", this.selected.date.getFullYear())
                    url.searchParams.append("month", this.selected.date.getMonth())
                    url.searchParams.append("day", this.selected.date.getDate())
                    url.searchParams.append("dayOfWeek", this.selected.date.getDay())
                    url.searchParams.append("hours", checked[0].id)
                    location.href = url.toString();
                } else
                    alert(
                        "You have not selected a period! (Normally you shouldn't have seen this warning! Apparently someone changed a code!)"
                        );
            },

            setDaysOfCalendar() {
                const dayFirstIndex = this.date(this.year, this.month, 1).getDay();
                const dayCount = this.date(this.year, this.month + 1, 0).getDate();
                const dayLastIndex = (dayFirstIndex + dayCount) % 7;

                const dayLastPrev = this.getDateByMonthChange(-1).getDate();

                this.days_of_prev = new Array(dayFirstIndex).fill(dayLastPrev - dayFirstIndex).map((t, i) => t + i + 1);
                this.days_of_current = new Array(dayCount).fill(0).map((t, i) => {
                    let res = {
                        value: i + 1,
                        occupiedArr: new Array(this.bookingHours.length - 1).fill(0)
                    };
                    let rangesArr = config.bookings.filter(t => t.year == this.year && t.month == this.month +
                            1 && t.day == res.value)
                        .map(t => t.ranges);
                    if (rangesArr.length > 0)
                        res.occupiedArr = rangesArr.reduce((a, b) => a.map((c, i) => b[i] || c));

                    return res;
                });


                let daysOfNext = new Array(7 - dayLastIndex).fill(0).map((t, i) => i + 1);
                if (dayCount + this.days_of_prev.length < 35) {
                    daysOfNext = daysOfNext.concat(new Array(7).fill(daysOfNext.length).map((t, i) => i + 1))
                }
                this.days_of_next = daysOfNext
            }
        }
    }
</script>

import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";

export const Statistic = {
    data: function () {
        return {
            months: {
                1: 'Январь',
                2: 'Февраль',
                3: 'Март',
                4: 'Апрель',
                5: 'Май',
                6: 'Июнь',
                7: 'Июль',
                8: 'Август',
                9: 'Сентябрь',
                10: 'Октябрь',
                11: 'Ноябрь',
                12: 'Декабрь'
            },
            years: [2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030],
            filter: {
                month: null,
                year: null
            },
            currentMonth: {
                current: new Date().getMonth() + 1,
                prev: (new Date().getMonth() + 1) - 1
            }
        }
    },
    watch: {
        filter: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get(route(route().current()),
                    pickBy(this.filter),
                    { preserveState: true }
                )}, 150),
        },
    },
}

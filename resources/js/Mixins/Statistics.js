export const Statistic = {
    data: function () {
        return {
            months: {
                0: 'Январь',
                1: 'Февраль',
                2: 'Март',
                3: 'Апрель',
                4: 'Май',
                5: 'Июнь',
                6: 'Июль',
                7: 'Август',
                8: 'Сентябрь',
                9: 'Октябрь',
                10: 'Ноябрь',
                11: 'Декабрь'
            },
            years: [2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030],
            formQuery: {
                month: new Date().getMonth(),
                year: new Date().getFullYear()
            }
        }
    }
}

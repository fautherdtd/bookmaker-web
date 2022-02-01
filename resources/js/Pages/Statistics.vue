<template>
    <app-layout title="Стастика">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Статистика
                </h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  bg-white">
                <div class="py-12">
                    <div class="flex">
                        <select name="country" id="country" class="mr-3 w-48" v-model="this.formQuery.month">
                            <option v-for="(value, key) in months"  :value="key">
                                {{ value }}
                            </option>`
                        </select>
                        <select name="year" id="year" class="mr-3 w-48" v-model="this.formQuery.year">
                            <option v-for="year in years"  :value="year">
                                {{ year }}
                            </option>`
                        </select>
                    </div>
                    <div class="underline font-semibold text-xl mt-2">
                        <h2>Статистика на {{ this.months[this.formQuery.month] }} {{ this.formQuery.year }}</h2>
                    </div>
                    <div class="mt-2">
                        <ul>
                            <li>- Всего БК NaN на сумму NaN</li>
                            <li>- БК в ожидании 3  сумму NaN</li>
                            <li>- БК на верификации NaN на сумму NaN</li>
                            <li>- БК на выводе NaN на сумму NaN</li>
                            <li>- БК выведено NaN на сумму NaN</li>
                            <li>- Готовим документы NaN на сумму NaN</li>
                            <li>- Ожидание дропа NaN на сумму NaN</li>
                            <li>- БК на списании NaN на сумму NaN</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
export default defineComponent({
    components: {
        AppLayout,
    },
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
    },
    computed: {
    },
    props: {
        data: Object
    }
})
</script>

<style scoped>

</style>

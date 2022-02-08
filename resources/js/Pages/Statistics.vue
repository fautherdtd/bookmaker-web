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
                        <el-radio-group v-model="this.filter.month" size="large">
                            <el-radio-button :label="this.currentMonth.current">
                                На сегодня
                            </el-radio-button>
                            <el-radio-button :label="this.currentMonth.prev">
                                За прошлый месяц
                            </el-radio-button>
                        </el-radio-group>
                        <select name="month" id="month" class="ml-4 mr-3 w-48" v-model="this.filter.month">
                            <option value="null" disabled selected>Выбрать месяц</option>
                            <option v-for="(value, key) in months"  :value="key">
                                {{ value }}
                            </option>`
                        </select>
                        <select name="year" id="year" class="mr-3 w-48" v-model="this.filter.year">
                            <option value="null"  disabled selected>Выбрать год</option>
                            <option v-for="year in years"  :value="year">
                                {{ year }}
                            </option>`
                        </select>
                    </div>
                    <div class="mt-8">
                        <h3 class="font-semibold text-xl mb-4">Всего БК {{ this.common.data.count }} на сумму {{ this.common.data.cash }} €</h3>
                        <el-row :gutter="20">
                            <el-col :span="8" v-for="stat in this.statistics.data">
                                <span class="text-lg">БК {{ stat }} €</span>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";

export default defineComponent({
    components: {
        AppLayout
    },
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
                year: new Date().getFullYear(),
                month: new Date().getMonth() + 1
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
    props: {
        common: Object,
        statistics: Object
    }
})
</script>

<style scoped>

</style>

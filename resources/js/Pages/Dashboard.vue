<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Дашбоард
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  bg-white">
                <div class="py-12">
                    <div class="flex" style="align-items:center">
                        <h2 class="font-bold text-xl mr-2">Общая сводка:</h2>
                        <el-radio-group v-model="this.filter.common.month" size="large">
                            <el-radio-button :label="this.currentMonth.current">
                                На сегодня
                            </el-radio-button>
                            <el-radio-button :label="this.currentMonth.prev">
                                За прошлый месяц
                            </el-radio-button>
                        </el-radio-group>
                        <select name="month" id="month" class="ml-4 mr-3 w-48" v-model="this.filter.common.month">
                            <option value="null" disabled selected>Выбрать месяц</option>
                            <option v-for="(value, key) in months"  :value="key">
                                {{ value }}
                            </option>`
                        </select>
                        <select name="year" id="year" class="mr-3 w-48" v-model="this.filter.common.year">
                            <option value="null"  disabled selected>Выбрать год</option>
                            <option v-for="year in years"  :value="year">
                                {{ year }}
                            </option>`
                        </select>
                    </div>
                    <div class="flex justify-between mt-2">
                        <ul>
                            <li>- Всего дропов: {{ this.common.count.count ?? 0 }}</li>
                            <li>- Активных дропов: {{ this.common.count.active ?? 0 }}</li>
                            <li>- Дропов в блоке: {{ this.common.count.trouble ?? 0 }}</li>
                            <li>- Выведено дропов: {{ this.common.count.withdrawn ?? 0 }}</li>
                        </ul>
                        <ul>
                            <li>- Общая сумма по дропам: {{ this.common.cash.all ?? 0 }} €</li>
                            <li>- Сумма активных дропов: {{ this.common.cash.active ?? 0 }} €</li>
                            <li>- Сумма дропов в блоке: {{ this.common.cash.trouble ?? 0 }} €</li>
                            <li>- Сумма выведенных дропов: {{ this.common.cash.withdrawn ?? 0 }} €</li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="py-12">
                    <div class="flex" style="align-items:center">
                        <h2 class="font-bold text-xl mr-2">Подробная сводка</h2>
                        <el-radio-group v-model="this.filter.responsible.month" size="large">
                            <el-radio-button :label="this.currentMonth.current">
                                На сегодня
                            </el-radio-button>
                            <el-radio-button :label="this.currentMonth.prev">
                                За прошлый месяц
                            </el-radio-button>
                        </el-radio-group>
                        <select name="month" class="ml-4 mr-3 w-48" v-model="this.filter.responsible.month">
                            <option value="null" disabled selected>Выбрать месяц</option>
                            <option v-for="(value, key) in months"  :value="key">
                                {{ value }}
                            </option>`
                        </select>
                        <select name="year" class="mr-3 w-48" v-model="this.filter.responsible.year">
                            <option value="null"  disabled selected>Выбрать год</option>
                            <option v-for="year in years"  :value="year">
                                {{ year }}
                            </option>
                        </select>
                    </div>
                    <div class="flex mt-2">
                        <ul class="w-48 statistics-ul">
                            <li>- Передали шт. БК</li>
                            <li>- Сумма</li>
                            <li>- Вывели шт.БК</li>
                            <li>- Сумма</li>
                        </ul>
                        <el-card
                            class="box-card"
                            shadow="never" >
                            <template #header>
                                <div class="card-header">
                                    Всего
                                </div>
                            </template>
                            <div class="text-center">
                                {{ this.detailed.common.data.handed ?? 0}}
                                <el-divider></el-divider>
                                {{ this.detailed.common.data.cash ?? 0}} €
                                <el-divider></el-divider>
                                {{ this.detailed.common.data.withdrawn ?? 0}}
                                <el-divider></el-divider>
                                {{ this.detailed.common.data.withdrawncash ?? 0}} €
                            </div>
                        </el-card>
                        <el-card
                            class="box-card" v-for="detailed in this.detailed.responsible"
                            shadow="never" >
                            <template #header>
                                <div class="card-header">
                                    <span>{{ detailed.name }}</span>
                                </div>
                            </template>
                            <div class="text-center">
                                {{ detailed.handed ?? 0 }}
                                <el-divider></el-divider>
                                {{ detailed.cash ?? 0 }} €
                                <el-divider></el-divider>
                                {{ detailed.withdrawn ?? 0 }}
                                <el-divider></el-divider>
                                {{ detailed.withdrawncash ?? 0 }} €
                            </div>
                        </el-card>
                    </div>
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import {
        Statistic
    } from "../Mixins/Statistics";
    import throttle from "lodash/throttle";
    import pickBy from "lodash/pickBy";

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
        },
        data: function () {
            return {
                filter: {
                    common: {
                        year: new Date().getFullYear(),
                        month: new Date().getMonth() + 1
                    },
                    responsible: {
                        year: new Date().getFullYear(),
                        month: new Date().getMonth() + 1
                    }
                }
            }
        },
        mixins: [
            Statistic
        ],
        props: {
            common: Object,
            detailed: Object
        },
    })
</script>
<style scoped>
    .statistics-ul {
        padding-top: 65px;
        line-height: 70px;
        text-align: right;
        margin-right: 25px;
    }
    .el-card {
        border: 0
    }
</style>

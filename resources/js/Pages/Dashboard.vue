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
                        <h2 class="font-bold text-xl mr-2">
                            Общая сводка (<span class="underline">{{ this.months[this.formQuery.month] }} {{ this.formQuery.year }}</span>):
                        </h2>
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
                    <div class="flex justify-between mt-2">
                        <ul>
                            <li>- Всего дропов: 0</li>
                            <li>- Активных дропов: 0</li>
                            <li>- Дропов в блоке: 0</li>
                            <li>- Выведено дропов: 0</li>
                        </ul>
                        <ul>
                            <li>- Общая сумма по дропам: 0 €</li>
                            <li>- Сумма активных дропов: 0 €</li>
                            <li>- Сумма дропов в блоке: 0 €</li>
                            <li>- Сумма выведенных дропов: 0 €</li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="py-12">
                    <div class="flex" style="align-items:center">
                        <h2 class="font-bold text-xl mr-2">
                            Подробная сводка (<span class="underline">{{ this.months[this.formQuery.month] }} {{ this.formQuery.year }}</span>):
                        </h2>
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
                    <div class="flex mt-2">
                        <ul class="w-48 statistics-ul">
                            <li>- Передали шт. БК</li>
                            <li>- Сумма</li>
                            <li>- Вывели шт.БК</li>
                            <li>- Сумма</li>
                        </ul>
                        <el-table :data="this.data" width="70%">
                            <el-table-column prop="date" label="Всего" width="180" />
                        </el-table>
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

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
        },
        data: function () {
            return {
                data: [
                ]
            }
        },
        mixins: [
            Statistic
        ]
    })
</script>
<style>
    .statistics-ul {
        padding-top: 42px;
        line-height: 37px;
        text-align: right;
        margin-right: 25px;
    }
</style>

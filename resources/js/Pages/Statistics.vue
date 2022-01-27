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
                        <button class="underline font-bold mr-2">На сегодня</button>
                        <button class="underline mr-2">За прошлый месяц</button>
                        <select name="country" id="country" class="mr-3 w-48">
                            <option value="0" selected disabled>{{ this.currentMonth }}</option>
                            <hr>
                            <option v-for="month in months"  :value="month">
                                {{month }}
                            </option>`
                        </select>
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
            currentMonth: new Date().toLocaleString('ru', {
                month: 'long'
            }),
            months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Ноябрь', 'Декабрь']
        }
    },
    computed: {
    }
})
</script>

<style scoped>

</style>

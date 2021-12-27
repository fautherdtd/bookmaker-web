<template>
    <app-layout title="Платежки">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Платежки
                </h2>
                <jet-secondary-button class="bg-green-100">
                    Добавить
                </jet-secondary-button>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <select name="country" id="country" class="mr-3 w-48">
                        <option value="0" selected disabled>Страна</option>
                        <option value="1">Россия</option>
                    </select>
                    <select name="drop" id="drop" class="mr-3 w-48">
                        <option value="0" selected disabled>Дроп</option>
                        <option value="1">Тест</option>
                    </select>
                    <select name="types" id="types" class="mr-3 w-48">
                        <option value="0" selected disabled>Тип платежки</option>
                        <option value="1">Тест</option>
                    </select>
                    <select name="status" id="status" class="mr-3 w-48">
                        <option value="0" selected disabled>Статус</option>
                        <option value="1">Тест</option>
                    </select>
                    <button class="underline">Сбросить фильтры</button>
                </div>
            </div>
            <hr class="mb-6 mt-6">
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default defineComponent({
    components: {
        AppLayout,
        JetSecondaryButton
    },
})
</script>

<style scoped>

</style>

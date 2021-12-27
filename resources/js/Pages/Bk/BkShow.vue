<template>
    <app-layout title="БК">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                БК - {{ $page['props']['id'] }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-10 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-between">
                        <div class="content">
                            <h2 class="text-lg font-bold mb-4"><b>ОБЩАЯ ИНФОРМАЦИЯ:</b></h2>
                            <ul>
                                <li><b>Страна:</b> </li>
                                <li><b>ФИО:</b> </li>
                                <li><b>Почта:</b> </li>
                                <li><b>Пароль:</b> </li>
                                <li><b>Адрес:</b> </li>
                                <li><b>Документы:</b> </li>
                                <li><b>Доп.информация:</b> </li>
                                <li><b>Дроповод:</b> </li>
                            </ul>
                        </div>
                        <div class="content">
                            <h2 class="text-lg font-bold mb-4"><b>СВЯЗАННЫЕ ДАННЫЕ:</b></h2>
                            <p><b>БК:</b></p>
                            <p><b>Платежки:</b></p>
                        </div>
                    </div>
                    <div class="content mt-6 mb-6">
                        <h2 class="text-lg font-bold mb-4"><b>ИСТОРИЯ:</b></h2>
                    </div>
                    <div class="bg-gray-50 p-6">
                        <div class="flex justify-between">
                            <p class="font-bold text-lg"><b>Сумма:</b> </p>
                            <p class="font-bold text-lg"><b>Статус:</b> </p>
                        </div>
                        <div class="flex justify-between">
                            <p class="font-bold text-lg"><b>Валюта:</b> </p>
                            <p class="font-bold text-lg"><b>Ответственный:</b> </p>
                        </div>
                        <div class="text-center mt-5">
                            <jet-secondary-button class="ml-2">
                                Изменить
                            </jet-secondary-button>
                        </div>
                    </div>
                </div>
            </div>
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
    data: function () {
        return {}
    },
    props: {
        user: Object,
    },
})
</script>

<style scoped>

</style>

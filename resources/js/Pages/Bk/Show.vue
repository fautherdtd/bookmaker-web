<template>
    <app-layout title="БК">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <Link :href="route('bk.index')">
                    <i class="lni lni-arrow-left-circle"></i>
                </Link>
                <span class="ml-2">
                    БК - {{ item['data']['drop'] }}
                </span>
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-10 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-indigo-50 content mt-6 mb-6" v-if="item['data']['touch_updated'] != null">
                        <p>Обновление пришло с первой системы: {{ item['data']['touch_updated'] }}</p>
                    </div>
                    <div class="flex justify-between">
                        <div class="content">
                            <h2 class="text-lg font-bold mb-4"><b>ОБЩАЯ ИНФОРМАЦИЯ:</b></h2>
                            <ul>
                                <li><b>Страна:</b> {{ item['data']['country'] }}</li>
                                <li><b>ФИО:</b> {{ item['data']['drop'] }}</li>
                                <li><b>Логин:</b> {{ item['data']['email'] }}</li>
                                <li><b>Пароль:</b> {{ item['data']['password'] }}</li>
                                <li><b>Адрес:</b> {{ item['data']['address'] }}</li>
                                <li><b>Документы:</b> {{ item['data']['document'] }}</li>
                                <li><b>Доп.информация:</b> {{ item['data']['info'] }}</li>
                                <li><b>Дроповод:</b> {{ item['data']['drop_guide'] }}</li>
                            </ul>
                        </div>
                        <div class="content">
                            <h2 class="text-lg font-bold mb-4"><b>СВЯЗАННЫЕ ДАННЫЕ:</b></h2>
                            <p><b>БК:</b> {{ item['data']['bk'] }}</p>
                            <p><b>Платежки:</b></p>
                            <ul>
                                <li v-for="payment in item['data']['payments']" :key="payment.id" class="mb-2">
                                    - {{ payment.label }}
                                </li>
                            </ul>
                            <el-button type="info" @click="showTransactionsClick">история транкзаций</el-button>
                            <el-dialog v-model="showTransactions" title="История транкзаций" width="50%" center>
                                <ul>
                                    <li v-for="payment in item['data']['payments']" :key="payment.id" class="mb-4">
                                        <h3 class="text-xl mb-2 text-black">{{ payment.label }}</h3>
                                        <ul>
                                            <li v-for="(value, key) in payment.children" :key="key" class="mb-2">
                                                - {{ value }}
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </el-dialog>
                        </div>
                    </div>
                    <div class="content mt-6 mb-6">
                        <h2 class="text-lg font-bold mb-4"><b>ИСТОРИЯ:</b></h2>
                        <ul>
                            <li v-for="(value, key) in historiesSort" :key="key">
                                {{ value }}
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 p-6">
                        <div class="flex justify-between">
                            <p><span class="font-bold text-lg">Сумма:</span> {{ item['data']['cash'] }}</p>
                            <p><span class="font-bold text-lg">Статус:</span> {{ item['data']['status']['value'] }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p><span class="font-bold text-lg">Валюта:</span> {{ item['data']['currencies'] }}</p>
                            <p><span class="font-bold text-lg">Ответственный:</span> {{ item['data']['responsible']['name'] }}</p>
                        </div>
                        <div class="text-center mt-5">
                            <Link :href="route('bk.edit', item['data']['id'])">
                                <el-button type="primary">Редактировать</el-button>
                            </Link>
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
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        AppLayout,
        Link,
    },
    data: function () {
        return {
            showTransactions: false,
            dialogEdit: false,
        }
    },
    methods: {
        showTransactionsClick: function () {
            this.showTransactions = this.showTransactions === false
        },
        dialogEditClick: function () {
            this.dialogEdit = this.dialogEdit === false
        }
    },
    computed: {
        historiesSort: function () {
            return this.item['data']['stories'].sort((a, b) => a.created_at > b.created_at ? 1 : -1)
        }
    },
    props: {
        user: Object,
        item: Object
    },
})
</script>

<style scoped>

</style>

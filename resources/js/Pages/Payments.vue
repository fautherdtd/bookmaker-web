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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <el-table
                    :data="data['data']"
                    :default-sort="{ prop: 'drop' }"
                    style="width: 100%"
                >
                    <el-table-column prop="country" sortable label="Страна" />
                    <el-table-column prop="drop" sortable label="ФИО" />
                    <el-table-column prop="type" sortable label="Тип платежа" />
                    <el-table-column prop="cash" sortable label="Сумма" />
                    <el-table-column prop="status" sortable label="Статус" />
                    <el-table-column prop="updated_at" sortable label="Дата изменения" />
                    <el-table-column fixed="right" label="Действия" width="120">
                        <template #default="scope">
                            <el-button-group class="ml-4">
                                <el-button type="primary" :icon="Edit"
                                           v-on:click="getShowItem(scope.row.id)"></el-button>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <PaymentShow
                v-if="this.showItem !== null"
                :item="this.showItem"
                :dialogPaymentVisible="this.dialogPaymentVisible"
            />
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import { Link } from '@inertiajs/inertia-vue3';
import PaymentShow from '@/Pages/Payment/Show.vue'
import {
    Edit,
} from '@element-plus/icons-vue'

export default defineComponent({
    components: {
        AppLayout,
        JetSecondaryButton,
        Link,
        PaymentShow
    },
    data: function () {
        return {
            showItem: null,
            dialogPaymentVisible: false
        }
    },
    methods: {
        getShowItem: function (id) {
            this.showItem = this.data.data.find(obj => {
                return obj.id === id
            })
            this.dialogPaymentVisible = true
        }
    },
    props: {
        data: Object
    }
})
</script>

<style scoped>

</style>

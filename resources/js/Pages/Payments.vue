<template>
    <app-layout title="Платежки">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Платежки
                </h2>
                <Link :href="route('payment.create')">
                    <el-button type="primary">Создать</el-button>
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <select name="country" id="country" class="mr-3 w-48" @change="filterTable($event, 'country_id')">
                        <option value="0" selected disabled>Страна</option>
                        <option v-for="country in filter['countries']"  :value="country.id">
                            {{ country.name }}
                        </option>
                    </select>
                    <select name="drop" id="drop" class="mr-3 w-48" @change="filterTable($event, 'drop')">
                        <option value="0" selected disabled>Дроп</option>
                        <option v-for="drop in filter['drops']"  :value="drop">
                            {{ drop }}
                        </option>
                    </select>
                    <select name="types" id="types" class="mr-3 w-48" @change="filterTable($event, 'type_id')">
                        <option value="0" selected disabled>Тип платежки</option>
                        <option v-for="type in filter['type']"  :value="type.id">
                            {{ type.title }}
                        </option>
                    </select>
                    <select name="status" id="status" class="mr-3 w-48" @change="filterTable($event, 'status')">
                        <option value="0" selected disabled>Статус</option>
                        <option v-for="(val, key) in filter['status']"  :value="key">
                            {{ val }}
                        </option>
                    </select>
                    <button class="underline" @click="resetFilterTable">Сбросить фильтры</button>
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
                    <el-table-column prop="type.title" sortable label="Тип платежа" />
                    <el-table-column prop="cash" sortable label="Сумма" />
                    <el-table-column prop="status.value" sortable label="Статус" />
                    <el-table-column prop="updated_at" sortable label="Дата изменения" />
                    <el-table-column fixed="right" label="Действия">
                        <template #default="scope">
                            <el-button-group class="ml-4">
                                <el-button type="primary" v-on:click="getShowItem(scope.row.id)">
                                    <i class="lni lni-eye"></i>
                                </el-button>
                                <Link :href="route('payment.edit', scope.row.id)">
                                    <el-button type="primary">
                                        <i class="lni lni-pencil-alt"></i>
                                    </el-button>
                                </Link>
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
        },
        filterTable: function (val, queryKey) {
            let value = queryKey === 'withdrawn_bk' ? val.target.checked : val.target.value;
            let queryParam = queryKey + '=' + value;
            window.history.pushState({
                path: window.location.href
            }, '', window.location.href + '?' + queryParam);
        },
        resetFilterTable: function () {
            console.log(window.location.href.split("?")[0]);
            window.history.pushState({
                path: window.location.href
            }, '', window.location.href.split("?")[0]);
        }
    },
    props: {
        data: Object,
        filter: Object
    }
})
</script>

<style scoped>

</style>

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
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Страна"
                        v-model="this.filter.country_id"
                        :reduce="(option) => option.id"
                        :options="countriesSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Дроп"
                        v-model="this.filter.drop"
                        :reduce="(option) => option.code"
                        :options="dropsSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Тип платежки"
                        v-model="this.filter.type_id"
                        :reduce="(option) => option.id"
                        :options="typePaymentsSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Статус"
                        v-model="this.filter.status"
                        :reduce="(option) => option.code"
                        :options="statusesSelect">
                    </v-select>
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
                v-if="this.showItem != null"
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
import vSelect from 'vue-select'
import {
    Bets,
    BkList,
    Common,
    Countries,
    Currencies,
    DropGuides,
    Responsible,
    Statuses,
    TypePayments
} from "../Mixins/Filters";

export default defineComponent({
    components: {
        AppLayout,
        JetSecondaryButton,
        Link,
        PaymentShow,
        vSelect
    },
    mixins: [
        Currencies,
        Statuses,
        BkList,
        TypePayments,
        DropGuides,
        Bets,
        Countries,
        Responsible,
        Common
    ],
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
    },
    props: {
        data: Object,
        filter: Object
    }
})
</script>

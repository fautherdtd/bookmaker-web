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
                <el-row>
                    <el-col :span="8">
                        <v-select
                            class="mr-3 mb-2 bg-white"
                            placeholder="Страна"
                            v-model="this.filter.country_id"
                            :reduce="(option) => option.id"
                            :options="countriesSelect">
                        </v-select>
                    </el-col>
                    <el-col :span="6">
                        <v-select
                            class="mr-3 bg-white"
                            placeholder="Дроп"
                            v-model="this.filter.drop"
                            :reduce="(option) => option.code"
                            :options="dropsSelect">
                        </v-select>
                    </el-col>
                    <el-col :span="8">
                        <v-select
                            class="bg-white"
                            placeholder="Тип платежки"
                            v-model="this.filter.type_id"
                            :reduce="(option) => option.id"
                            :options="typePaymentsSelect">
                        </v-select>
                    </el-col>
                    <el-col :span="6">
                        <v-select
                            class="mr-3 bg-white"
                            placeholder="Статус"
                            v-model="this.filter.status"
                            :reduce="(option) => option.code"
                            :options="statusesSelect">
                        </v-select>
                    </el-col>
                    <button class="underline" @click="resetFilterTable">Сбросить фильтры</button>
                </el-row>
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
                                <Link :href="route('payment.edit', scope.row.id)" v-if="!scope.row.external">
                                    <el-button type="primary">
                                        <i class="lni lni-pencil-alt"></i>
                                    </el-button>
                                </Link>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <el-dialog v-model="dialogPaymentVisible"
                       v-if="this.showItem != null"
                       title="Информация о платежке"
                       width="40%"
                       :visible.sync="dialogPaymentVisible"
                       :before-close="handleClose">
                <div class="flex justify-between">
                    <div class="w-full">
                        <h3 class="font-bold text-lg">Общая информация:</h3>
                        <p><b>Страна:</b> {{ this.showItem['country'] }}</p>
                        <p><b>Дата платежа:</b> {{ this.showItem['updated_at'] }}</p>
                    </div>
                    <div class="w-full">
                        <h3 class="font-bold text-lg">Связанные данные:</h3>
                        <p>
                            <b>Дроп:</b> {{ this.showItem['drop'] }} </p>
                        <p class="underline">
                            <b>БК: </b>
                            <Link :href="route('bk.show', this.showItem['bk_id'])">
                                {{ this.showItem['bet'] }}
                            </Link>
                        </p>
                    </div>
                </div>
                <template #footer>
                  <div class="bg-gray-50 p-6">
                      <div class="flex justify-between text-left">
                          <div class="content">
                              <p><b>Сумма:</b> {{ this.showItem['cash'] }}</p>
                              <p><b>Валюта:</b> {{ this.showItem['currencies'] }}</p>
                          </div>
                          <div class="content">
                              <p><b>Статус:</b> {{ this.showItem['status']['value'] }}</p>
                              <p><b>Тип платежки:</b> {{ this.showItem['type']['title'] }}</p>
                          </div>
                      </div>
                  </div>
                </template>
            </el-dialog>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import { Link } from '@inertiajs/inertia-vue3';
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

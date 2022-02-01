<template>
    <app-layout title="БК">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    БК
                </h2>
                <Link :href="route('bk.distribution')" v-if="$page.props.permission.isAdmin">
                    <el-button type="warning">
                        БК на распределение - {{ payload['distributions'] }}
                    </el-button>
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Страна"
                        @option:selected="filterTable($event, 'country_id')"
                        name="country_id"
                        :options="countriesSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Дроп"
                        @option:selected="filterTable($event, 'drop')"
                        :options="dropsSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="БК"
                        @option:selected="filterTable($event, 'bet_id')"
                        :options="betsSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Дроповод"
                        @option:selected="filterTable($event, 'drop_guide')"
                        :options="dropGuidesSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Статус"
                        @option:selected="filterTable($event, 'status')"
                        :options="statusesSelect">
                    </v-select>
                    <v-select
                        class="w-48 bg-white"
                        placeholder="Ответственный"
                        @option:selected="filterTable($event, 'responsible')"
                        :options="responsibleSelect">
                    </v-select>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 mb-6 flex justify-between">
                <label for="disable-bk">
                    <input type="checkbox" id="disable-bk" @change="filterTable($event, 'withdrawn_bk')">
                    Не отображать выведенный бк
                </label>
                <button class="underline ml-3" @click="resetFilterTable">Сбросить фильтры</button>
            </div>
            <hr>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <el-table
                    :data="data['data']"
                    :default-sort="{ prop: 'drop' }"
                    style="width: 100%"
                >
                    <el-table-column prop="country" sortable label="Страна" />
                    <el-table-column prop="drop" sortable label="ФИО" />
                    <el-table-column prop="cash" sortable label="Сумма" />
                    <el-table-column prop="bk" sortable label="БК" width="100"/>
                    <el-table-column prop="drop_guide" sortable label="Дроповод" />
                    <el-table-column prop="status" sortable label="Статус" width="100"/>
                    <el-table-column prop="responsible.name"
                                     v-if="$page.props.permission.isAdmin"
                                     sortable label="Ответственный" />
                    <el-table-column fixed="right" label="Действия" >
                        <template #default="scope">
                            <el-button-group class="ml-4">
                                <Link :href="route('bk.show', scope.row.id)">
                                    <el-button type="primary">
                                        <i class="lni lni-eye"></i>
                                    </el-button>
                                </Link>
                                <Link :href="route('bk.edit', scope.row.id)">
                                    <el-button type="primary">
                                        <i class="lni lni-pencil-alt"></i>
                                    </el-button>
                                </Link>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import vSelect from 'vue-select'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import {
    Bets,
    BkList,
    Countries,
    Currencies,
    DropGuides, Responsible,
    Statuses,
    TypePayments
} from '../Mixins/Filters'

export default defineComponent({
    components: {
        AppLayout,
        Link,
        JetSecondaryButton,
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
        Responsible
    ],
    data: function () {
        return {
            filter: {
                country_id: 0
            }
        }
    },
    methods: {
        filterTable: function (val, queryKey) {
            let value = queryKey === 'withdrawn_bk' ? val.target.checked : val.code;
            let queryParam = queryKey + '=' + value;
            window.history.pushState({
                path: window.location.href
            }, '', window.location.href + '?' + queryParam);
            this.updateFilterTable()
        },
        updateFilterTable: function() {
            let params = location.search
                .slice(1)
                .split('&')
                .map(p => p.split('='))
                .reduce((obj, [key, value]) => ({ ...obj, [key]: value }), {});
            this.$inertia.get(route('bk.index'), params, { replace: true, preserveState: true })
        },
        resetFilterTable: function () {
            window.history.pushState({
                path: window.location.href
            }, '', window.location.href.split("?")[0]);
            this.$inertia.get(route('bk.index'))
        }
    },
    props: {
        data: Object,
        pivot: Object,
        payload: Object,
    }
})
</script>

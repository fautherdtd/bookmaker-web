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
            <el-row class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <el-col :span="8">
                    <v-select
                        class="mr-3 mb-2 bg-white"
                        placeholder="Страна"
                        v-model="this.filter.country_id"
                        :reduce="(option) => option.id"
                        name="country_id"
                        :options="countriesSelect">
                    </v-select>
                </el-col>
                <el-col :span="8">
                    <v-select
                        class="mr-3 mb-2 bg-white"
                        placeholder="Дроп"
                        v-model="this.filter.drop"
                        :reduce="(option) => option.code"
                        :options="dropsSelect">
                    </v-select>
                </el-col>
                <el-col :span="8">
                    <v-select
                        class="mb-2 bg-white"
                        placeholder="БК"
                        v-model="this.filter.bet_id"
                        :reduce="(option) => option.id"
                        :options="betsSelect">
                    </v-select>
                </el-col>
                <el-col :span="8">
                    <v-select
                        class="mr-3 bg-white"
                        placeholder="Дроповод"
                        v-model="this.filter.drop_guide"
                        :reduce="(option) => option.code"
                        :options="dropGuidesSelect">
                    </v-select>
                </el-col>
                <el-col :span="8">
                    <v-select
                        class="mr-3  bg-white"
                        placeholder="Статус"
                        v-model="this.filter.status"
                        :reduce="(option) => option.code"
                        :options="statusesSelect">
                    </v-select>
                </el-col>
                <el-col :span="8">
                    <v-select
                        v-if="$page.props.permission.isAdmin"
                        class=" bg-white"
                        placeholder="Ответственный"
                        v-model="this.filter.responsible"
                        :reduce="(option) => option.id"
                        :options="responsibleSelect">
                    </v-select>
                </el-col>
            </el-row>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 mb-6 flex justify-between">
                <label for="disable-bk">
                    <input type="checkbox" id="disable-bk" v-model="this.filter.withdrawn">
                    Не показывать выведенные и на списании
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
    Drops,
    TypePayments,
    Common
} from '@/Mixins/Filters'

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
        Drops,
        Countries,
        Responsible,
        Common
    ],
    data: function () {
        return {
        }
    },
    props: {
        data: Object,
        pivot: Object,
        payload: Object,
    }
})
</script>

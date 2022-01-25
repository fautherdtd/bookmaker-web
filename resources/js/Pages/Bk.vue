<template>
    <app-layout title="БК">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                БК
            </h2>
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
                    <select name="bk" id="bk" class="mr-3" @change="filterTable($event, 'bk_id')">
                        <option value="none" selected disabled>БК</option>
                        <option v-for="bet in filter['bets']" :value="bet.id">
                            {{ bet.name }}
                        </option>
                    </select>
                    <select name="dropguide" id="dropguide" class="mr-3 w-48" @change="filterTable($event, 'drop_guide')">
                        <option value="0" selected disabled>Дроповод</option>
                        <option v-for="guide in filter['dropGuides']" :value="guide">
                            {{ guide }}
                        </option>
                    </select>
                    <select name="status" id="status" class="mr-3 w-48" @change="filterTable($event, 'status')">
                        <option value="none" selected disabled>Статус</option>
                        <option v-for="(item, key) in filter['statuses']" :value="key">
                            {{ item }}
                        </option>
                    </select>
                    <button class="underline" @click="resetFilterTable">Сбросить фильтры</button>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 mb-6">
                <label for="disable-bk">
                    <input type="checkbox" id="disable-bk" @change="filterTable($event, 'withdrawn_bk')">
                    Не отображать выведенный бк
                </label>
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
                    <el-table-column prop="bk" sortable label="БК" />
                    <el-table-column prop="drop_guide" sortable label="Дроповод" />
                    <el-table-column prop="status" sortable label="Статус" />
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
import {
    Edit,
} from '@element-plus/icons-vue'

export default defineComponent({
    components: {
        AppLayout,
        Link,
        Edit
    },
    data: function () {
        return {
        }
    },
    methods: {
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
    :root {
        --el-color-primary: #409eff;
    }
</style>

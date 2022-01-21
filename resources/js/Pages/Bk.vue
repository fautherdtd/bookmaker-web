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
                    <select name="country" id="country" class="mr-3 w-48">
                        <option value="0" selected disabled>Страна</option>
                        <option v-for="country in $page['props']['countries']"  :value="country.id">
                            {{ country.name }}
                        </option>
                    </select>
                    <select name="drop" id="drop" class="mr-3 w-48">
                        <option value="0" selected disabled>Дроп</option>
                    </select>
                    <select name="bk" id="bk" class="mr-3">
                        <option value="none" selected disabled>БК</option>
                        <option value="1" v-for="bet in $page['props']['bets']" :value="bet.id">
                            {{ bet.name }}
                        </option>
                    </select>
                    <select name="dropguide" id="dropguide" class="mr-3 w-48">
                        <option value="0" selected disabled>Дроповод</option>
                    </select>
                    <select name="status" id="status" class="mr-3 w-48">
                        <option value="none" selected disabled>Статус</option>
                        <option v-for="(item, key) in $page['props']['statuses']" :value="key">
                            {{ item }}
                        </option>
                    </select>
                    <button class="underline">Сбросить фильтры</button>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 mb-6">
                <label for="disable-bk">
                    <input type="checkbox" id="disable-bk">
                    Не отображать выведенный бк
                </label>
            </div>
            <hr>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <el-table
                    :data="$page['props']['data']['data']"
                    :default-sort="{ prop: 'drop' }"
                    style="width: 100%"
                >
                    <el-table-column prop="country" sortable label="Страна" />
                    <el-table-column prop="drop" sortable label="ФИО" />
                    <el-table-column prop="cash" sortable label="Сумма" />
                    <el-table-column prop="bk" sortable label="БК" />
                    <el-table-column prop="drop_guide" sortable label="Дроповод" />
                    <el-table-column prop="status" sortable label="Статус" />
                    <el-table-column fixed="right" label="Действия" width="120">
                        <template #default="scope">
                            <el-button-group class="ml-4">
                                <Link :href="route('bk.show', scope.row.id)">
                                    <el-button type="primary" :icon="Edit"></el-button>
                                </Link>
                                <Link :href="route('user.create')">
                                    <el-button type="primary" :icon="Edit"></el-button>
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
})
</script>

<style scoped>
    :root {
        --el-color-primary: #409eff;
    }
</style>

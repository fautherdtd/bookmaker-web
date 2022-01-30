<template>
    <app-layout title="БК">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Распределение дропов
                </h2>
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
                    <button class="underline" @click="resetFilterTable">Сбросить фильтры</button>
                </div>
            </div>
            <hr>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <el-table
                    :data="data['data']"
                    :default-sort="{ prop: 'drop' }"
                    style="width: 100%"
                >
                    <el-table-column prop="country" sortable label="Страна"/>
                    <el-table-column prop="drop" sortable label="ФИО"/>
                    <el-table-column prop="cash" sortable label="Сумма"/>
                    <el-table-column prop="bk" sortable label="БК"/>
                    <el-table-column prop="drop_guide" sortable label="Дроповод"/>
                    <el-table-column prop="status" sortable label="Статус"/>
                    <el-table-column label="Ответственный" fixed="right" width="230">
                        <template #default="scope">
                            <select name="responsibleID" id="responsibleID" class="mr-2"
                                v-on:change="changeSaveDistribution($event)">
                                <option value="null" disabled selected>Не выбран</option>
                                <hr>
                                <option :value="user.id" v-for="user in filter['responsible']">
                                    {{ user.name }}
                                </option>
                            </select>
                            <el-button circle type="success"
                                       v-on:click="saveDistribution(this.responsibleID, scope.row.id)">
                                <i class="lni lni-checkmark"></i>
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent, reactive} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import {
    Edit,
} from '@element-plus/icons-vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import {ElMessage} from "element-plus";

export default defineComponent({
    components: {
        AppLayout,
        Link,
        Edit,
        JetSecondaryButton
    },
    data: function () {
        return {
            responsibleID: null
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
        },
        changeSaveDistribution: function (event) {
            this.responsibleID = event.target.value
        },
        saveDistribution: function (responsible, rowID) {
            if (responsible == null) {
                ElMessage.error("Выберите ответственного.")
                return
            }
            axios.put(route('bk.distributionSave'),
                {
                    responsible: responsible,
                    id: rowID
                }
            ).then(r => ElMessage.success("Ответственный добавлен."))
            .catch(r => ElMessage.error("Произошла ошибка, попробуйте еще раз."))
        }
    },

    props: {
        data: Object,
        filter: Object,
        responsible: Object
    }
})
</script>

<style scoped>
:root {
    --el-color-primary: #409eff;
}
</style>

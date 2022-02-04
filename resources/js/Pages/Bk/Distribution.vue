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
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Страна"
                        v-model="this.filter.country_id"
                        :reduce="(option) => option.id"
                        name="country_id"
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
                        placeholder="БК"
                        v-model="this.filter.bet_id"
                        :reduce="(option) => option.id"
                        :options="betsSelect">
                    </v-select>
                    <v-select
                        class="mr-3 w-48 bg-white"
                        placeholder="Дроповод"
                        v-model="this.filter.drop_guide"
                        :reduce="(option) => option.code"
                        :options="dropGuidesSelect">
                    </v-select>
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
                            <select name="responsibleID"
                                    id="responsibleID"
                                    class="mr-2"
                                v-on:change="changeSaveDistribution($event, scope.row.id)">
                                <option value="" disabled selected>Сотрудник</option>
                                <option :value="user.id" v-for="user in responsibleSelect">
                                    {{ user.label }}
                                </option>
                            </select>
                            <el-button circle type="success"
                                       :disabled="this.responsible.btn !== scope.row.id"
                                       v-on:click="saveDistribution(this.responsible.id, scope.row.id)">
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
import vSelect from "vue-select";
import {
    Bets,
    Common,
    Countries,
    DropGuides,
    Responsible,
    TypePayments
} from "../../Mixins/Filters";

export default defineComponent({
    components: {
        AppLayout,
        Link,
        Edit,
        JetSecondaryButton,
        vSelect
    },
    mixins: [
        TypePayments,
        DropGuides,
        Bets,
        Countries,
        Responsible,
        Common
    ],
    data: function () {
        return {
            responsible: {
                id: null,
                btn: null
            }
        }
    },
    methods: {
        changeSaveDistribution: function (event, scopeID) {
            this.responsible.id = event.target.value
            this.responsible.btn = scopeID
        },
        saveDistribution: function (responsible, rowID) {
            if (responsible == null) {
                ElMessage.error("Выберите ответственного.")
                return
            }
            axios.put(route('bk.distributionSave'), {responsible: responsible, id: rowID})
                .then((result) => {
                    ElMessage.success(result.data);
                    this.$inertia.get(route('bk.distribution'))
                })
                .catch((r) => {
                    ElMessage.error(r.response.data)
                })
        }
    },

    props: {
        data: Object,
        pivot: Object,
    }
})
</script>

<style scoped>
:root {
    --el-color-primary: #409eff;
}
</style>

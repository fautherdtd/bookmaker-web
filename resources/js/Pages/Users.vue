<template>
    <app-layout title="Пользователи">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Пользователи
                </h2>
                <Link :href="route('user.create')">
                    <el-button type="primary">
                        Добавить
                    </el-button>
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <el-table
                    :data="data['data']"
                    :default-sort="{ prop: 'name' }"
                >
                    <el-table-column prop="name" sortable label="ФИО" />
                    <el-table-column prop="roles" sortable label="Роль" /><el-table-column fixed="right" label="Действия" >
                    <template #default="scope">
                            <Link :href="route('user.edit', scope.row.id)">
                                <el-button type="primary">
                                    <i class="lni lni-pencil-alt"></i>
                                </el-button>
                            </Link>
                            <el-button type="primary" class="ml-2" @click="deleteUser(scope.row.id)">
                                <i class="lni lni-close"></i>
                            </el-button>
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
import JetSecondaryButton from "../Jetstream/SecondaryButton"
import { Link } from '@inertiajs/inertia-vue3';
import {ElMessage} from "element-plus";

export default defineComponent({
    components: {
        AppLayout,
        JetSecondaryButton,
        Link
    },
    data: function () {
        return {
        }
    },
    props: {
        data: Object
    },
    methods: {
        deleteUser: function (id) {
            axios.delete(route('user.destroy', id))
                .then(result => {
                    this.$inertia.get(route('user.index'))
                    ElMessage.success('Пользователь удален.');
                })
                .catch((r) => {
                    ElMessage.error(r.response.data)
                })
        }
    }
})
</script>

<style scoped>

</style>

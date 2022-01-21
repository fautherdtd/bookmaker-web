<template>
    <app-layout title="Пользователи">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Пользователи
                </h2>
                <Link :href="route('user.create')">
                    <jet-secondary-button class="bg-green-100">
                        Добавить
                    </jet-secondary-button>
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <table-lite
                    :is-loading="table.isLoading"
                    :is-re-search="table.isReSearch"
                    :columns="table.columns"
                    :rows="$page['props']['data']"
                    :total="table.totalRecordCount"
                    :sortable="table.sortable"
                    :messages="table.messages"
                ></table-lite>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import TableLite from "vue3-table-lite";
import JetSecondaryButton from "../Jetstream/SecondaryButton"
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        AppLayout,
        TableLite,
        JetSecondaryButton,
        Link
    },
    data: function () {
        return {
            table: {
                isLoading: false,
                isReSearch: false,
                columns: [
                    {
                        label: "ID",
                        field: "id",
                        width: "3%",
                        sortable: true,
                        isKey: true,
                    },
                    {
                        label: "Имя",
                        field: "name",
                        width: "10%",
                        sortable: true
                    },
                    {
                        label: "Email",
                        field: "email",
                        width: "15%",
                        sortable: true,
                    },
                    {
                        label: "Действия",
                        field: "action",
                        width: "5%",
                        display: function (row) {
                            return (
                                '<div class="flex justify-center">' +
                                '<button type="button" data-id="1" class="quick-btn text-lg"><i class="lni lni-pencil-alt"></i></button> ' +
                                '<button type="button" data-id="1" class="quick-btn text-lg"><i class="lni lni-eye"></i></button>' +
                                '</div>'
                            );
                        },
                    },
                ],
                totalRecordCount: 2,
                sortable: {
                    order: "id",
                    sort: "asc",
                },
                messages: {
                    pagingInfo: "Показывает {0}-{1} из {2}",
                    pageSizeChangeLabel: "Кол-во:",
                    gotoPageLabel: "Перейти на стр:",
                    noDataAvailable: "Нет данных",
                },
            },
        }
    },
})
</script>

<style scoped>

</style>

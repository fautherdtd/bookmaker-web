<template>
    <app-layout title="Платежки">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Платежки
                </h2>
                <jet-secondary-button class="bg-green-100">
                    Добавить
                </jet-secondary-button>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <select name="country" id="country" class="mr-3 w-48">
                        <option value="0" selected disabled>Страна</option>
                        <option value="1">Россия</option>
                    </select>
                    <select name="drop" id="drop" class="mr-3 w-48">
                        <option value="0" selected disabled>Дроп</option>
                        <option value="1">Тест</option>
                    </select>
                    <select name="types" id="types" class="mr-3 w-48">
                        <option value="0" selected disabled>Тип платежки</option>
                        <option value="1">Тест</option>
                    </select>
                    <select name="status" id="status" class="mr-3 w-48">
                        <option value="0" selected disabled>Статус</option>
                        <option value="1">Тест</option>
                    </select>
                    <button class="underline">Сбросить фильтры</button>
                </div>
            </div>
            <hr class="mb-6 mt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <table-lite
                    :is-loading="table.isLoading"
                    :is-re-search="table.isReSearch"
                    :columns="table.columns"
                    :rows="table.rows"
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
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import TableLite from "vue3-table-lite";

export default defineComponent({
    components: {
        AppLayout,
        JetSecondaryButton,
        TableLite
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
                        label: "Страна",
                        field: "country",
                        width: "10%",
                        sortable: true
                    },
                    {
                        label: "ФИО",
                        field: "name",
                        width: "15%",
                        sortable: true
                    },
                    {
                        label: "Тип платежа",
                        field: "types",
                        width: "10%",
                        sortable: true,
                    },
                    {
                        label: "Сумма",
                        field: "sum",
                        width: "5%",
                        sortable: true,
                    },
                    {
                        label: "Статус",
                        field: "status",
                        width: "5%",
                        sortable: true,
                    },
                    {
                        label: "Дата изменения",
                        field: "updated_at",
                        width: "13%",
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
                rows: [
                    {
                        id: 1,
                        country: "Россия",
                        name: "Смирнов Иван Иванович",
                        types: "btc",
                        sum: "24000$",
                        bk: "Фонбет",
                        status: "Статус",
                        updated_at: "18.12.2021",
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
            }
        }
    },
})
</script>

<style scoped>

</style>

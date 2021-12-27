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
import TableLite from "vue3-table-lite";

export default defineComponent({
    components: {
        AppLayout,
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
                        sortable: true,
                    },
                    {
                        label: "Сумма",
                        field: "sum",
                        width: "10%",
                        sortable: true,
                    },
                    {
                        label: "БК",
                        field: "bk",
                        width: "10%",
                        sortable: true,
                    },
                    {
                        label: "Дроповод",
                        field: "drop_guide",
                        width: "10%",
                        sortable: true,
                    },
                    {
                        label: "Статус",
                        field: "status",
                        width: "10%",
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

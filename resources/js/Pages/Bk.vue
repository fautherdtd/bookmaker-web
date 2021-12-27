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
                        <option value="1">Россия</option>
                    </select>
                    <select name="drop" id="drop" class="mr-3 w-48">
                        <option value="0" selected disabled>Дроп</option>
                        <option value="1">Россия</option>
                    </select>
                    <select name="bk" id="bk" class="mr-3">
                        <option value="0" selected disabled>БК</option>
                        <option value="1">Россия</option>
                    </select>
                    <select name="dropguide" id="dropguide" class="mr-3 w-48">
                        <option value="0" selected disabled>Дроповод</option>
                        <option value="1">Россия</option>
                    </select>
                    <select name="status" id="status" class="mr-3 w-48">
                        <option value="0" selected disabled>Статус</option>
                        <option value="1">Статус</option>
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Title
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="person in people" :key="person.email">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" :src="person.image" alt="" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ person.name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ person.email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ person.title }}</div>
                                                <div class="text-sm text-gray-500">{{ person.department }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Active
                  </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ person.role }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    components: {
        AppLayout,
    },
    data: function () {
        return {
            items: [
                'Россия',
                'США'
            ]
        }
    },
})
</script>

<style scoped>

</style>

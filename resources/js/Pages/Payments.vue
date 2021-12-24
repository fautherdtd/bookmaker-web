<template>
    <app-layout title="Платежки">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Платежки
            </h2>
        </template>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'

export default defineComponent({
    components: {
        AppLayout,
        Welcome,
    },
})
</script>

<style scoped>

</style>

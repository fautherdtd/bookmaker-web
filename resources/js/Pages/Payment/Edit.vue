<template>
    <app-layout title="Платежка">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <Link :href="route('payment.index')">
                    <i class="lni lni-arrow-left-circle"></i>
                </Link>
                <span class="ml-2">Патежка - {{ item['data']['country'] }}, {{ item['data']['drop'] }}</span>
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <jet-form-section @submitted="editPayment">
                    <template #title>Редактирование платежки</template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="type_id" value="Тип платежки" />
                            <v-select
                                v-model="form.type_id"
                                :reduce="(option) => option.id"
                                :options="typePaymentsSelect"></v-select>
                            <jet-input-error :message="form.errors.type_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="sum" value="Сумма" />
                            <jet-input id="sum" type="text" class="mt-1 block w-full" v-model="form.sum"/>
                            <jet-input-error :message="form.errors.sum" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="currency" value="Валюта" />
                            <v-select
                                v-model="form.currency"
                                :reduce="(option) => option.code"
                                :options="currenciesSelect"></v-select>
                            <jet-input-error :message="form.errors.currency" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="status" value="Статус" />
                            <v-select
                                v-model="form.status"
                                :reduce="(option) => option.code"
                                :options="statusesSelect"></v-select>
                            <jet-input-error :message="form.errors.status" class="mt-2" />
                        </div>
                    </template>
                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Платежка обновлена.
                        </jet-action-message>
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Сохранить
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import {ElMessage} from "element-plus";
import { Link } from '@inertiajs/inertia-vue3';
import vSelect from "vue-select";
import {Currencies, Statuses, TypePayments} from "@/Mixins/Filters";

export default defineComponent({
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        Link,
        vSelect
    },
    mixins: [
        Currencies,
        Statuses,
        TypePayments
    ],
    data() {
        return {
            form: this.$inertia.form({
                type_id: this.item.data.type.id,
                sum: this.item.data.sum.value,
                currency: this.item.data.sum.currency,
                status: this.item.data.status.key,
            }),
        }
    },
    methods: {
        editPayment() {
            this.form.put(route('payment.update', this.item.data.id), {
                errorBag: 'editPayment',
                onSuccess: () => {
                    this.form.reset()
                    ElMessage.success('Платежка обновлена.');
                },
                onError: (r) => {
                    ElMessage.error(r.response.data);
                }
            })
        },
    },
    props: {
        item: Object,
        pivot: Object
    }
})
</script>

<style scoped>

</style>

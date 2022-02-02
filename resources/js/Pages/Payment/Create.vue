<template>
    <app-layout title="Новая платежка">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Новая платежка</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <jet-form-section @submitted="storePayment">
                    <template #title>Создание платежки</template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="type_id" value="БК" />
                            <v-select
                                v-model="form.bk"
                                :options="bkSelect"></v-select>
                            <jet-input-error :message="form.errors.type_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="type_id" value="Тип платежки" />
                            <v-select
                                v-model="form.type_id"
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
                                :options="currenciesSelect"></v-select>
                            <jet-input-error :message="form.errors.currency" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="status" value="Статус" />
                            <v-select
                                v-model="form.status"
                                :options="statusesSelect"></v-select>
                            <jet-input-error :message="form.errors.status" class="mt-2" />
                            <jet-input-error :message="form.errors.status" class="mt-2" />
                        </div>
                    </template>
                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Новая платежка создана
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
import vSelect from 'vue-select'
import {BkList, Currencies, Statuses, Countries, TypePayments} from '../../Mixins/Filters'

export default defineComponent({
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        vSelect,
    },
    mixins: [
        Currencies,
        Statuses,
        BkList,
        Countries,
        TypePayments
    ],
    data: function () {
        return {
            form: this.$inertia.form({
                bk: null,
                type_id: null,
                sum: null,
                currency: null,
                status: null,
            }),
        }
    },
    methods: {
        storePayment() {
            this.form.post(route('payment.store'), {
                errorBag: 'storePayment',
                onSuccess: () => {
                    this.form.reset()
                    ElMessage.success('Сохранено.');
                },
                onError: () => {
                    if (this.form.errors.type_id) {
                        this.form.reset('type_id')
                        this.$refs.type_id.focus()
                    }
                    if (this.form.errors.sum) {
                        this.form.reset('sum')
                        this.$refs.sum.focus()
                    }
                    if (this.form.errors.currency) {
                        this.form.reset('currency')
                        this.$refs.currency.focus()
                    }
                    if (this.form.errors.status) {
                        this.form.reset('status')
                        this.$refs.status.focus()
                    }
                    ElMessage.error('Ошибка');
                }
            })
        },
    },
})
</script>

<style scoped>

</style>

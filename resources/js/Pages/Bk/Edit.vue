<template>
    <app-layout title="БК">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="#" @click="back"><i class="lni lni-arrow-left-circle"></i></a>
                <span class="ml-2">
                    БК - {{ item['data']['drop'] }}
                </span>
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <jet-form-section @submitted="editBk">
                    <template #title>Редактирование БК</template>
                    <template #description>
                        <h2 class="text-lg font-bold mb-4"><b>ОБЩАЯ ИНФОРМАЦИЯ:</b></h2>
                        <p><b>Страна:</b> {{ item['data']['country'] }}</p>
                        <p><b>ФИО:</b> {{ item['data']['drop'] }}</p>
                        <p><b>Дроповод:</b> {{ item['data']['drop_guide'] }}</p>
                        <p><b>БК:</b>  {{ item['data']['bk'] }}</p>
                    </template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="email" value="Почта" />
                            <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="password" value="Пароль" />
                            <jet-input id="password" type="text" class="mt-1 block w-full" v-model="form.password" />
                            <jet-input-error :message="form.errors.password" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="info" value="Доп. информация" />
                            <jet-input id="info" type="text" class="mt-1 block w-full" v-model="form.info" />
                            <jet-input-error :message="form.errors.info" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="sum" value="Сумма" />
                            <jet-input id="sum" type="text" class="mt-1 block w-full" v-model="form.sum" />
                            <jet-input-error :message="form.errors.sum" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="currency" value="Валюта" />
                            <jet-input id="currency" type="text" class="mt-1 block w-full"
                                       :value="item['data']['currencies']" disabled/>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="status" value="Статус" />
                            <select name="status" id="status" v-model="form.status">
                                <option :value="key" v-for="(value, key) in $page['props']['statuses']">
                                    {{ value }}
                                </option>
                            </select>
                            <jet-input-error :message="form.errors.status" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="comment" value="Комментарий" />
                            <textarea name="comment" id="comment" v-model="form.comment"
                                      class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                            <jet-input-error :message="form.errors.comment" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4" v-if="$page.props.permission.isAdmin">
                            <jet-label for="responsible" value="Ответственный" />
                            <select name="responsible" id="responsible" class="w-48"
                                    v-model="form.responsible">
                                <option :value="user.id" v-for="user in this.responsible">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-4 bg-gray-50 p-3" v-if="form.status === 'withdrawn'">
                            <template v-for="payment in this.form.transactions">
                                <div class="col-span-6 sm:col-span-4 flex">
                                    <div class="mr-3">
                                        <jet-label for="transaction-sum" value="Сумма" required />
                                        <jet-input id="transaction-sum" type="number"
                                                   class="mt-1 block w-full"
                                                   v-model="payment.sum" :max="form.sum"/>
                                    </div>
                                    <div>
                                        <jet-label for="transaction-payment" value="Платежка" />
                                        <select name="transaction-payment" id="transaction-payment" required class="w-60"
                                                v-model="payment.payment_id">
                                            <option value="null" disabled>Платежки</option>
                                            <option :value="payment.id" v-for="payment in this.payments.data">
                                                {{ payment.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </template>
                            <div class="col-span-6 sm:col-span-4 mt-4">
                                <el-button type="primary" @click="addPayments">
                                    Добавить <i class="lni lni-circle-plus"></i>
                                </el-button>
                            </div>
                        </div>
                    </template>
                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            БК отредактирован.
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
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import { ElMessage } from 'element-plus'

export default defineComponent({
    components: {
        AppLayout,
        JetSecondaryButton,
        JetFormSection,
        JetActionMessage,
        JetButton,
        JetInput,
        JetInputError,
        JetLabel,
        ElMessage
    },
    data: function () {
        return {
            form: this.$inertia.form({
                id: this.item.data.id,
                email: this.item.data.email,
                password: this.item.data.password,
                info: this.item.data.info,
                sum: this.item.data.sum,
                status: this.item.data.status.key,
                comment: null,
                responsible: this.item.data.responsible.id,
                transactions: [
                    {
                        sum: null,
                        payment_id: null
                    }
                ]
            }),
        }
    },
    methods: {
        addPayments: function () {
            this.form.transactions.push({
                sum: null,
                payment_id: null
            });
        },
        editBk() {
            let sumTrans = 0;
            let paymentNULL = true;
            this.form.transactions.map(function (item) {
                sumTrans += parseInt(item.sum)
                if (item.payment_id === null) paymentNULL = false
                return item
            });
            if (! paymentNULL) {
                ElMessage.error('Платежка не выбрана для вывода.');
                return
            }
            if (sumTrans > this.form.sum) {
                ElMessage.error('Общая сумма вывода больше суммы БК.');
                return
            }
            this.form.put(route('bk.update', this.item.data.id), {
                errorBag: 'editBk',
                preserveScroll: true,
                onSuccess: () => {
                    ElMessage.success('БК отредактирован.');
                },
                onError: (r) => {
                    ElMessage.error(r);
                }
            })
        },
        back() {
            window.history.back();
        },
    },
    props: {
        item: Object,
        responsible: Object,
        payments: Object
    }
})
</script>

<style scoped>

</style>

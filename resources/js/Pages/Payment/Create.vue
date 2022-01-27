<template>
    <el-dialog v-model="dialogPaymentCreateе"
               title="Информация о платежке"
               width="40%"
               center>
        <jet-form-section @submitted="editPayment">
            <template #title>Редактирование платежки</template>
            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="type_id" :value="'Тип платежки: ' + item['data']['type']['title']" />
                    <select name="type_id" id="type_id" v-model="form.type_id">
                        <option value="{{ form.type_id }}" disabled selected>{{ item['data']['type']['title'] }}</option>
                        <hr>
                        <option :value="type.id" v-for="type in pivot['type']">
                            {{ type.title }}
                        </option>
                    </select>
                    <jet-input-error :message="form.errors.type" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="sum" value="Сумма" />
                    <jet-input id="sum" type="text" class="mt-1 block w-full" v-model="form.sum"/>
                    <jet-input-error :message="form.errors.sum" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="currency" :value="'Тип платежки: ' + item['data']['sum']['currency']" />
                    <select name="currency" id="currency" v-model="form.type_id">
                        <option value="{{ form.currency }}" disabled selected>{{ item['data']['sum']['currency'] }}</option>
                        <hr>
                        <option :value="currency.id" v-for="currency in pivot['currencies']">
                            {{ currency.name }}
                        </option>
                    </select>
                    <jet-input-error :message="form.errors.type" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="status" :value="'Статус: ' + item['data']['status']['value']" />
                    <select name="status" id="status" v-model="form.status">
                        <option value="{{ form.status }}" disabled selected>{{ item['data']['status']['value'] }}</option>
                        <hr>
                        <option :value="key" v-for="(val, key) in pivot['status']">
                            {{ val }}
                        </option>
                    </select>
                    <jet-input-error :message="form.errors.type" class="mt-2" />
                </div>
            </template>
            <template #actions>
                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Платежка отредактирована.
                </jet-action-message>
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Сохранить
                </jet-button>
            </template>
        </jet-form-section>
        <template #footer>
          <span class="dialog-footer">
              <div class="flex justify-between text-left">
                  <div class="content">
                      <p><b>Сумма:</b> {{ item['cash'] }}</p>
                      <p><b>Валюта:</b> {{ item['currencies'] }}</p>
                  </div>
                  <div class="content">
                      <p><b>Статус:</b> {{ item['status']['value'] }}</p>
                      <p><b>Тип платежки:</b> {{ item['type']['title'] }}</p>
                  </div>
              </div>
          </span>
        </template>
    </el-dialog>
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

export default defineComponent({
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: {
        item: Object,
        dialogPaymentCreateе: Boolean
    }
})
</script>

<style scoped>

</style>

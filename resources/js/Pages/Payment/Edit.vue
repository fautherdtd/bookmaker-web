<template>
    <el-dialog v-model="dialogPaymentVisible"
               title="Редактировать платежку"
               width="40%"
               center>
        <jet-form-section>
            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="type" value="Тип" />
                    <jet-input id="type" type="text" class="mt-1 block w-full" v-model="form.type"/>
                    <jet-input-error :message="form.errors.type" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="sum" value="Сумма" />
                    <jet-input id="sum" type="text" class="mt-1 block w-full" v-model="form.sum"/>
                    <jet-input-error :message="form.errors.sum" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="currency" value="Валюта" />
                    <jet-input id="currency" type="text" class="mt-1 block w-full" v-model="form.currency"/>
                    <jet-input-error :message="form.errors.currency" class="mt-2" />
                </div>
            </template>
        </jet-form-section>
        <template #footer>
          <span class="dialog-footer">
          </span>
        </template>
    </el-dialog>
</template>

<script>
import { defineComponent } from 'vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'

export default defineComponent({
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    data() {
        return {
            form: this.$inertia.form({
                type: item.type,
                sum: item.sum.sum,
                currency: item.sum.currency,
                status: item.statuses,
            }),
        }
    },
    props: {
        item: Object,
        dialogPaymentVisible: Boolean
    }
})
</script>

<style scoped>

</style>

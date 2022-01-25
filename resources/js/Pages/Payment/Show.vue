<template>
    <el-dialog v-model="dialogPaymentVisible"
               title="Информация о платежке"
               width="40%"
               center>
        <div class="flex justify-between">
            <div class="w-full">
                <h3 class="font-bold text-lg">Общая информация:</h3>
                <p><b>Страна:</b> {{ item['country'] }}</p>
                <p><b>Дата платежа:</b> {{ item['updated_at'] }}</p>
            </div>
            <div class="w-full">
                <h3 class="font-bold text-lg">Связанные данные:</h3>
                <p><b>Дроп:</b> {{ item['drop'] }}</p>
                <p><b>БК:</b> {{ item['bet'] }}</p>
            </div>
        </div>
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

export default defineComponent({
    props: {
        item: Object,
        dialogPaymentVisible: Boolean
    }
})
</script>

<style scoped>

</style>

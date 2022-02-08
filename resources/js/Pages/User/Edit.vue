<template>
    <app-layout title="Пользователи">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Новый пользователь
                </h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <jet-form-section @submitted="createUser">
                    <template #title>
                        Редактирование пользователя
                    </template>

                    <template #description>
                        Заполните данные нового пользователя.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="name" value="Имя" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="email" value="Почта" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="password" value="Новый пароль" />
                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" ref="password" />
                            <jet-input-error :message="form.errors.password" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="role" value="Роль" />
                            <select name="role" id="role" v-model="form.role">
                                <option value="user">Сотрудник</option>
                                <option value="administrator">Администратор</option>
                            </select>
                            <jet-input-error :message="form.errors.role" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Пользователь отредактирован.
                        </jet-action-message>
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Создать
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

    data() {
        return {
            form: this.$inertia.form({
                name: this.data.name,
                email: this.data.email,
                password: null,
                role: 'user',
            }),
        }
    },

    methods: {
        createUser() {
            this.form.put(route('user.update', this.data.id), {
                errorBag: 'updateUser',
                onSuccess: () => this.form.reset(),
                onError: () => {
                    if (this.form.errors.name) {
                        this.form.reset('name')
                        this.$refs.name.focus()
                    }
                    if (this.form.errors.email) {
                        this.form.reset('email')
                        this.$refs.email.focus()
                    }
                    if (this.form.errors.password) {
                        this.form.reset('password')
                        this.$refs.password.focus()
                    }
                    if (this.form.errors.role) {
                        this.form.reset('role')
                        this.$refs.role.focus()
                    }
                }
            })
        },
    },

    props: {
        data: Object
    }
})
</script>

<style scoped>

</style>

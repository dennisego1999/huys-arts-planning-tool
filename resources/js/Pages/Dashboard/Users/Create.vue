<script setup>
import {useI18n} from "vue-i18n";
import {useForm} from "@inertiajs/vue3";
import {useClearToast, useShowToast} from "@/Composables/Toastification";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Set translation
const {t} = useI18n();

//Define variables
const form = useForm({
    first_name: null,
    last_name: null,
    email: null,
    password: null,
    password_confirmation: null,
    address: null,
    city: null,
    province: null,
    zip: null,
});

//Define functions
function submitForm() {
    form.post(route('users.store'), {
        onSuccess: () => {
            const successId = 'user-created-toast';

            useClearToast(successId);
            useShowToast(
                null,
                'User has been created...',
                'success',
                {
                    id: successId,
                }
            );
        },
        onError: error => {
            console.error(error);
            const errorId = 'user-created-error-toast';

            useClearToast(errorId);
            useShowToast(
                null,
                'Something went wrong...',
                'error',
                {
                    id: errorId,
                }
            );
        }
    });
}
</script>

<template>
    <form @submit.prevent>
        <div class="flex flex-col gap-8">
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                <div class="sm:col-span-3">
                    <InputLabel for="first-name" :value="t('spa.pages.users.form.first_name')"/>

                    <TextInput
                        v-model="form.first_name"
                        type="text"
                        name="first-name"
                        id="first-name"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="form.errors.first_name" class="mt-2" />
                </div>

                <div class="sm:col-span-3">
                    <InputLabel for="last-name" :value="t('spa.pages.users.form.last_name')"/>

                    <TextInput
                        v-model="form.last_name"
                        type="text"
                        name="last-name"
                        id="last-name"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="form.errors.last_name" class="mt-2" />
                </div>

                <div class="sm:col-span-4">
                    <InputLabel for="email" :value="t('spa.pages.users.form.email')"/>

                    <TextInput
                        v-model="form.email"
                        type="text"
                        name="email"
                        id="email"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div class="col-span-full">
                    <InputLabel for="street-address" :value="t('spa.pages.users.form.address')"/>

                    <TextInput
                        v-model="form.address"
                        type="text"
                        name="street-address"
                        id="street-address"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="form.errors.address" class="mt-2" />
                </div>

                <div class="sm:col-span-2 sm:col-start-1">
                    <InputLabel for="city" :value="t('spa.pages.users.form.city')"/>

                    <TextInput
                        v-model="form.city"
                        type="text"
                        name="city"
                        id="city"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="form.errors.city" class="mt-2" />
                </div>

                <div class="sm:col-span-2">
                    <InputLabel for="province" :value="t('spa.pages.users.form.province')"/>

                    <TextInput
                        v-model="form.province"
                        type="text"
                        name="province"
                        id="province"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="form.errors.province" class="mt-2" />
                </div>

                <div class="sm:col-span-2">
                    <InputLabel for="zip" :value="t('spa.pages.users.form.zip')"/>

                    <TextInput
                        v-model="form.zip"
                        type="text"
                        name="zip"
                        id="zip"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="form.errors.zip" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-start gap-x-6">
            <SecondaryButton :href="route('users.index')">
                Cancel
            </SecondaryButton>

            <PrimaryButton @click="submitForm">
                Save
            </PrimaryButton>
        </div>
    </form>
</template>

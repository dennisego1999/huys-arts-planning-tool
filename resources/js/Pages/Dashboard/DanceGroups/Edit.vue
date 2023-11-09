<script setup>
import {ref} from "vue";
import {useI18n} from "vue-i18n";
import {useForm} from "@inertiajs/vue3";
import {PhotoIcon} from "@heroicons/vue/24/outline";
import {useClearToast, useShowToast} from "@/Composables/Toastification";
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    group: Object,
});

//Set translation
const {t} = useI18n();

//Define variables
const photoInput = ref(null);
const photoPreview = ref(null);
const form = useForm({
    _method: 'put',
    name: props.group.name ?? {},
    description: props.group.description ?? {},
    image: props.group.image ?? null,
    new_image: null,
});

//Define functions
const updatePhotoPreview = () => {
    const photoFile = photoInput.value.files[0];

    if (!photoFile) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
        form.new_image = photoFile;
    };

    reader.readAsDataURL(photoFile);
};

const selectNewPhoto = () => {
    form.image = null;
    photoInput.value.click();
};

const deletePhoto = () => {
    photoPreview.value = null
    form.image = null;
    form.new_image = null;
    clearPhotoFileInput();
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

function submitForm() {
    form.post(route('dance-groups.update', {dance_group: props.group}), {
        onSuccess: () => {
            const successId = 'dance-group-updated-toast';

            useClearToast(successId);
            useShowToast(
                null,
                'Dance group has been updated...',
                'success',
                {
                    id: successId,
                }
            );
        },
        onError: error => {
            console.error(error);
            const errorId = 'dance-group-updated-error-toast';

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
    <div class="flex justify-between items-start gap-6">
        <form class="flex-1 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6" @submit.prevent>
            <div class="sm:col-span-4">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <div class="mt-2">
                    <input
                        v-model="form.name"
                        type="text"
                        name="name"
                        id="name"
                        autocomplete="given-name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
            </div>

            <div class="sm:col-span-4">
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                <div class="mt-2">
                            <textarea
                                v-model="form.description"
                                rows="5"
                                type="text"
                                name="description"
                                id="description"
                                autocomplete="given-name"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />

                    <InputError :message="form.errors.description" class="mt-2" />
                </div>
            </div>

            <div class="sm:col-span-4">
                <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover photo</label>

                <div class="mt-2 flex flex-col gap-6 justify-center rounded-lg border border-dashed border-gray-900/25 p-6">
                    <!-- Profile Photo File Input -->
                    <input
                        ref="photoInput"
                        type="file"
                        class="hidden"
                        accept=".png, .jpg, .jpeg"
                        @change="updatePhotoPreview"
                    >

                    <!-- Current Profile Photo -->
                    <div v-if="form.image && form.image.original_url" class="mt-2">
                        <img :src="form.image.original_url" alt="dance group image" class="w-full aspect-video object-cover">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div v-else class="relative">
                                <span
                                    class="block aspect-video w-full bg-cover bg-no-repeat bg-center rounded-md"
                                    :class="{'bg-gray-300': !photoPreview}"
                                    :style="'background-image: url(\'' + photoPreview + '\');'"
                                />

                        <PhotoIcon v-if="!photoPreview" class="absolute z-10 top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-14 h-14 text-white"/>
                    </div>

                    <InputError :message="form.errors.new_image" class="mt-2" />

                    <div class="flex justify-start items-center gap-6">
                        <SecondaryButton
                            v-if="form.image || photoPreview"
                            type="button"
                            class="w-fit"
                            @click="deletePhoto"
                        >
                            Remove Photo
                        </SecondaryButton>

                        <PrimaryButton
                            class="w-fit"
                            type="button"
                            @click="selectNewPhoto"
                        >
                            Select A New Photo
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </form>

        <div class="flex items-center justify-end gap-x-6">
            <SecondaryButton :href="route('dance-groups.show', {dance_group: group})">
                {{ t('spa.buttons.cancel') }}
            </SecondaryButton>

            <PrimaryButton @click="submitForm">
                {{ t('spa.buttons.save') }}
            </PrimaryButton>
        </div>
    </div>
</template>

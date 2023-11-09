<script setup>
import {ref} from "vue";
import {useI18n} from "vue-i18n";
import {useForm} from "@inertiajs/vue3";
import {PhotoIcon, PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/outline";
import {useClearToast, useShowToast} from "@/Composables/Toastification";
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import MultiselectDropdown from "../../../Components/MultiselectDropdown.vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    group: Object,
    users: Array,
});

//Set translation
const {t} = useI18n();

//Define variables
const isAddMemberModalOpen = ref(false);
const photoInput = ref(null);
const photoPreview = ref(null);
const form = useForm({
    _method: 'put',
    name: props.group.name ?? {},
    description: props.group.description ?? {},
    image: props.group.image ?? null,
    new_image: null,
    members: props.group.members ?? [],
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

function openAddMemberModal() {
    isAddMemberModalOpen.value = true;
}

function closeAddMemberModal() {
    isAddMemberModalOpen.value = false;
}

function addMember(member) {
    form.members.push(member);
}

function removeMember(memberToBeRemoved) {
    form.members = form.members.filter(member => member !== memberToBeRemoved);
}

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
    <div class="flex flex-col justify-between items-start gap-10">
        <div class="flex items-center justify-between gap-6 w-full">
            <div class="flex justify-start items-center gap-2">
                <h1 class="text-5xl font-bold">{{ group.name }}</h1>

                <PencilSquareIcon class="h-8 w-8 text-gray-600"/>
            </div>

            <div class="flex items-center justify-end gap-6">
                <SecondaryButton :href="route('dance-groups.show', {dance_group: group})">
                    {{ t('spa.buttons.cancel') }}
                </SecondaryButton>

                <PrimaryButton @click="submitForm">
                    {{ t('spa.buttons.save') }}
                </PrimaryButton>
            </div>
        </div>

        <form class="flex-1 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 w-full" @submit.prevent>
            <div class="sm:col-span-full">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>

                <div class="mt-2">
                    <input
                        v-model="form.name"
                        type="text"
                        name="name"
                        id="name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />

                    <InputError :message="form.errors.name" class="mt-2"/>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>

                <div class="mt-2">
                    <textarea
                        v-model="form.description"
                        rows="5"
                        type="text"
                        name="description"
                        id="description"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />

                    <InputError :message="form.errors.description" class="mt-2"/>
                </div>
            </div>

            <div class="sm:col-span-full">
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

                    <InputError :message="form.errors.new_image" class="mt-2"/>

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

            <div class="sm:col-span-full flex flex-col gap-6">
                <label for="members" class="block text-sm font-medium leading-6 text-gray-900">Members</label>

                <PrimaryButton @click="openAddMemberModal">Add members</PrimaryButton>

                <ul role="list" class="mx-auto grid max-w-2xl grid-cols-1 gap-8 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    <li v-for="member in form.members" :key="member.name" class="relative p-8 bg-gray-100 rounded-md">
                        <img class="mx-auto h-56 w-56 rounded-full" :src="member.profile_photo_url" alt="" />
                        <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">{{ member.full_name }}</h3>

                        <ul role="list" class="gap-x-6">
                            <li>
                                <a :href="'mailto:' + member.email" class="text-gray-400 font-bold">
                                    {{ member.email }}
                                </a>
                            </li>
                        </ul>

                        <TrashIcon
                            @click="removeMember(member)"
                            class="absolute top-4 right-4 h-9 w-9 p-1 bg-red-400 rounded-md text-white cursor-pointer"
                        />
                    </li>
                </ul>

                <InputError :message="form.errors.members" class="mt-2"/>
            </div>

            <Modal :show="isAddMemberModalOpen" @close="closeAddMemberModal">
                <div class="flex flex-col gap-4">
                    <h1 class="text-2xl font-bold">Add members to <span class="lowercase">{{ group.name }}</span></h1>

                    <MultiselectDropdown
                        v-model="form.members"
                        id="roles"
                        class="mt-1"
                        :options="users"
                        :deletable="false"
                        attribute="full_name"
                    />

                    <PrimaryButton @click="closeAddMemberModal">
                        {{ t('spa.buttons.close') }}
                    </PrimaryButton>
                </div>
            </Modal>
        </form>
    </div>
</template>

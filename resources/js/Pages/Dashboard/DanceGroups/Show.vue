<script setup>
import {usePage} from "@inertiajs/vue3";
import {useI18n} from "vue-i18n";
import {PhotoIcon} from "@heroicons/vue/24/outline";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

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
</script>

<template>
    <div class="flex flex-col">
        <div class="flex justify-between items-start">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-full">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-5xl">{{ group.name }}</h1>
                        <p class="text-lg">{{ group.description }}</p>
                    </div>
                </div>

                <div class="sm:col-span-full">
                    <div
                        class="mt-2 aspect-video w-full flex justify-center items-center rounded-lg overflow-hidden"
                        :class="{'bg-gray-300': !group.image}"
                    >
                        <PhotoIcon
                            v-if="!group.image"
                            class="mx-auto h-12 w-12 text-white"
                            aria-hidden="true"
                        />

                        <img
                            v-else
                            :src="group.image.original_url"
                            class="h-full w-full object-cover"
                            alt="dance group image"
                        >
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-start gap-4 mt-4">
                <SecondaryButton :href="route('dance-groups.index')">
                    {{ t('spa.buttons.go_back') }}
                </SecondaryButton>

                <PrimaryButton
                    v-if="usePage().props.policies.can.manageDanceGroups"
                    :href="route('dance-groups.edit', {dance_group: group})"
                >
                    {{ t('spa.buttons.edit') }}
                </PrimaryButton>
            </div>
        </div>

        <div class="sm:col-span-full">
            <div class="bg-white py-32">
                <div class="mx-auto text-center">
                    <div class="mx-auto max-w-2xl">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            {{ t('spa.pages.dance_groups.members.label') }}
                        </h2>

                        <p class="mt-4 text-lg leading-8 text-gray-600">
                            {{ t('spa.pages.dance_groups.members.description', {name: group.name}) }}
                        </p>
                    </div>
                    <ul role="list" class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-8 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                        <li v-for="member in group.members" :key="member.name" class="p-8 bg-gray-100 rounded-md">
                            <img class="mx-auto h-56 w-56 rounded-full" :src="member.profile_photo_url" alt="" />
                            <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">{{ member.full_name }}</h3>

                            <ul role="list" class="gap-x-6">
                                <li>
                                    <a :href="'mailto:' + member.email" class="text-gray-400 font-bold">
                                        {{ member.email }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

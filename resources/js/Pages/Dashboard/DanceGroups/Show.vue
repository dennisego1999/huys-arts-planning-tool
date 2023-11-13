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
        <div class="flex flex-col justify-between items-start gap-10">
            <div class="flex items-center justify-end gap-4 w-full">
                <SecondaryButton :href="route('dance-groups.index')">
                    {{ t('spa.buttons.go_back') }}
                </SecondaryButton>

                <PrimaryButton
                    v-if="usePage().props.policies.can.manageDanceGroups"
                    :href="route('dance-groups.edit', {dance_group: group})"
                    class="whitespace-nowrap"
                >
                    {{ t('spa.buttons.edit') }}
                </PrimaryButton>
            </div>

            <div class="flex justify-between items-center gap-6 w-full">
                <div class="flex-1">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-5xl font-bold">{{ group.name }}</h1>
                        <p class="text-lg">{{ group.description }}</p>
                    </div>
                </div>

                <div class="flex-1">
                    <div
                        class="aspect-video w-full flex justify-center items-center rounded-lg overflow-hidden drop-shadow-2xl"
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
        </div>

        <div class="sm:col-span-full">
            <div class="bg-white py-32">
                <div class="flex flex-col gap-6 mx-auto text-center">
                    <div class="mx-auto max-w-2xl">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            {{ t('spa.pages.dance_groups.members.label') }}
                        </h2>

                        <p v-if="group.members.length !== 0" class="mt-4 text-lg leading-8 text-gray-600">
                            {{ t('spa.pages.dance_groups.members.description', {name: group.name}) }}
                        </p>
                    </div>

                    <ul v-if="group.members.length !== 0" role="list" class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-8 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                        <li v-for="member in group.members" :key="member.name" class="p-8 bg-gray-100 rounded-md">
                            <img class="mx-auto h-56 w-56 rounded-full" :src="member.profile_photo_url" alt="" />

                            <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">{{ member.full_name }}</h3>

                            <a :href="'mailto:' + member.email" class="block whitespace-nowrap overflow-ellipsis max-w-full overflow-hidden text-gray-400 font-bold">
                                {{ member.email }}
                            </a>
                        </li>
                    </ul>

                    <p v-else class="text-base">
                        {{ t('spa.pages.dance_groups.no_members') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

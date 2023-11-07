<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {PhotoIcon} from "@heroicons/vue/24/outline";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {usePage} from "@inertiajs/vue3";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    group: Object,
});
</script>

<template>
    <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-4">
            <h1 class="text-5xl">{{ group.name }}</h1>
            <p class="text-lg">{{ group.description }}</p>
        </div>

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

        <PrimaryButton
            v-if="usePage().props.policies.can.manageDanceGroups"
            :href="route('dance-groups.edit', {dance_group: group})"
        >
            Edit
        </PrimaryButton>
    </div>
</template>

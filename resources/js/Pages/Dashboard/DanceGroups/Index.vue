<script setup>
import {nextTick} from "vue";
import {gsap} from "gsap";
import {Link, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchBar from "@/Components/SearchBar.vue";
import Pagination from "@/Components/Pagination.vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    groups: Object,
});

// Get url params
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

// Set forms variable
const form = useForm({
    search: urlParams.get('search') ? urlParams.get('search') : null,
});

nextTick(() => {
    //Animated in
    gsap.from('.dance-group', {
        opacity: 0,
        yPercent: 10,
        duration: 0.4,
        stagger: 0.1,
        ease: "power1.out"
    });
});
</script>

<template>
    <div class="flex flex-col gap-6">
        <SearchBar :form="form" :href="route('dance-groups.index')"/>

        <div v-if="groups.data.length !==0" class="mx-auto grid max-w-2xl grid-cols-1 gap-8 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 xl:grid-cols-4">
            <Link
                v-for="(group, index) in groups.data"
                :key="'dance-group-' + index"
                :href="route('dance-groups.show', {dance_group: group})"
                class="dance-group drop-shadow-xl rounded-md bg-gray-50"
            >
                <img v-if="group.image" class="aspect-[14/13] w-full rounded-t-2xl object-cover" :src="group.image.original_url" alt="dance group image"/>
                <div v-else class="aspect-[14/13] w-full rounded-t-2xl object-cover bg-gray-300"></div>

                <h3 class="text-lg font-semibold leading-8 tracking-tight text-gray-600 p-3">{{ group.name }}</h3>
            </Link>
        </div>

        <p v-else>No dance groups found...</p>

        <Pagination v-if="groups.data.length !== 0" :links="groups.meta.links"/>
    </div>
</template>

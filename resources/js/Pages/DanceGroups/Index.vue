<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Link} from "@inertiajs/vue3";
import {gsap} from "gsap";
import {nextTick} from "vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    groups: Array,
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
    <div>
        <div class="flex flex-col gap-1 mx-auto max-w-2xl lg:mx-0">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Onze dans groepen</h2>
        </div>

        <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-14 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 xl:grid-cols-4">
            <Link
                v-for="(group, index) in groups"
                :key="'dance-group-' + index"
                :href="route('dance-groups.show', {dance_group: group})"
                class="dance-group drop-shadow-xl rounded-md bg-gray-50"
            >
                <img v-if="group.image" class="aspect-[14/13] w-full rounded-t-2xl object-cover" :src="group.image.original_url" alt="dance group image"/>
                <div v-else class="aspect-[14/13] w-full rounded-t-2xl object-cover bg-gray-300"></div>

                <h3 class="text-lg font-semibold leading-8 tracking-tight text-gray-600 p-3">{{ group.name }}</h3>
            </Link>
        </div>
    </div>
</template>

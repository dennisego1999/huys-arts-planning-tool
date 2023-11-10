<script setup>
import {useI18n} from "vue-i18n";
import {debounce} from "lodash";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";

// Define props
const props = defineProps({
    form: Object,
    href: String
});

// Set translation
const {t} = useI18n();

//Define functions
const submitForm = debounce(() => {
    props.form.transform(data => {
        Object.keys(data).forEach(attr => {
            if (!data[attr]) delete data[attr];
        });
        return data;
    }).get(props.href, {
        preserveScroll: true,
        preserveState: true,
    });
}, 500);
</script>

<template>
    <form class="relative w-full" @submit.prevent>
        <MagnifyingGlassIcon class="absolute z-10 right-4 top-1/2 -translate-y-1/2 w-6 text-gray-300"/>

        <input
            v-model="form.search"
            @input="submitForm"
            type="text"
            name="search"
            :placeholder="t('spa.pages.dashboard.search')"
            class="drop-shadow-lg text-black w-full rounded-md border-none pl-4 pr-14 py-5 bg-gray-50 focus:ring-0 focus:ring-offset-0 focus:border-none"
        >
    </form>
</template>

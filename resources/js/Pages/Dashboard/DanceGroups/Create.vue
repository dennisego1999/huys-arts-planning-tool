<script setup>
import {useI18n} from "vue-i18n";
import {useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import DanceGroupForm from "@/Components/DanceGroupForm.vue";

// Define options
defineOptions({
    layout: AppLayout
});

// Define props
const props = defineProps({
    users: Array,
});

// Set translation
const {t} = useI18n();

// Define variables
const form = useForm({
    name: null,
    description: null,
    image: null,
    new_image: null,
    members: [],
});

// Define functions
function submit() {
    form.post(route('dance-groups.store', {dance_group: props.group}));
}
</script>

<template>
    <DanceGroupForm
        v-model:form="form"
        :users="users"
        @submit="submit"
    />
</template>

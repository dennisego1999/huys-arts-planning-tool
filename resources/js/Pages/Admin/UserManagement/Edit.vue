<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

//Define options
defineOptions({
    layout: DashboardLayout
});

//Define props
const props = defineProps({
    user: Object
});
</script>

<template>
    <pre>{{ user }}</pre>
</template>

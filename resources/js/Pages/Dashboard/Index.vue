<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {useI18n} from "vue-i18n";
import {Head} from "@inertiajs/vue3";

// Define options
defineOptions({
    layout: AppLayout
});

// Set translation
const {t} = useI18n();
</script>

<template>
    <div>
        <Head :title="t('spa.pages.dashboard.label')"/>

        <h1>{{ t('spa.pages.dashboard.label') }}</h1>
    </div>
</template>

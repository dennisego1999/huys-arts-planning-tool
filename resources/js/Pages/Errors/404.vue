<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

// Define options
defineOptions({
    layout: AppLayout
});
</script>

<template>
	<div class="flex flex-col justify-center items-center h-full pt-16 pb-12">
        <p class="text-base font-semibold text-skin-base">404</p>

        <h1
            class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl"
        >
            Page not found.
        </h1>

        <p class="mt-2 text-base text-gray-500">
            Sorry, we couldn’t find the page you’re looking for.
        </p>

        <div class="mt-6">
            <PrimaryButton
                :href="route('dashboard')"
                class="text-base font-medium text-skin-base hover:text-skin-base-200"
            >
                Go back home
            </PrimaryButton>
        </div>
	</div>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    user: Object
});
</script>

<template>
    <form @submit.prevent>
        <div class="flex flex-col gap-8">
            <div>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</p>
            </div>

            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                <div class="sm:col-span-3">
                    <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
                    <div class="mt-2">
                        <input
                            v-model="user.first_name"
                            type="text"
                            name="first-name"
                            id="first-name"
                            class="block w-full rounded-md cursor-text border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            disabled
                        />
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
                    <div class="mt-2">
                        <input
                            v-model="user.last_name"
                            type="text"
                            name="last-name"
                            id="last-name"
                            class="block w-full rounded-md cursor-text border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            disabled
                        />
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input
                            v-model="user.email"
                            id="email"
                            name="email"
                            type="email"
                            class="block w-full rounded-md cursor-text border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            disabled
                        />
                    </div>
                </div>

                <div class="col-span-full">
                    <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
                    <div class="mt-2">
                        <input
                            v-model="user.address"
                            type="text"
                            name="street-address"
                            id="street-address"
                            class="block w-full rounded-md cursor-text border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            disabled
                        />
                    </div>
                </div>

                <div class="sm:col-span-2 sm:col-start-1">
                    <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                    <div class="mt-2">
                        <input
                            v-model="user.city"
                            type="text"
                            name="city"
                            id="city"
                            class="block w-full rounded-md cursor-text border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            disabled
                        />
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="region" class="block text-sm font-medium leading-6 text-gray-900">State / Province</label>
                    <div class="mt-2">
                        <input
                            v-model="user.province"
                            type="text"
                            name="region"
                            id="region"
                            class="block w-full rounded-md cursor-text border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            disabled
                        />
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">ZIP / Postal code</label>
                    <div class="mt-2">
                        <input
                            v-model="user.zip"
                            type="text"
                            name="postal-code"
                            id="postal-code"
                            class="block w-full rounded-md cursor-text border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            disabled
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-start gap-x-6">
            <PrimaryButton :href="route('users.index')">
                Go back
            </PrimaryButton>
        </div>
    </form>
</template>

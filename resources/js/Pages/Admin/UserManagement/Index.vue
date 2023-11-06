<script setup>
import { ChevronRightIcon, MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import { Link, useForm } from "@inertiajs/vue3";
import { debounce } from "lodash";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import Pagination from "@/Components/Pagination.vue";

//Define options
defineOptions({
    layout: DashboardLayout
});

//Define props
const props = defineProps({
    users: Object,
});

//Get url params
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

//Set forms variable
const form = useForm({
    search: urlParams.get('search') ? urlParams.get('search') : null,
});

//Define functions
const submitForm = debounce(() => {
    form.transform(data => {
        Object.keys(data).forEach(attr => {
            if (!data[attr]) delete data[attr];
        });
        return data;
    }).get(route('users.index'), {
        preserveScroll: true,
        preserveState: true,
    });
}, 500);
</script>

<template>
    <div>
        <div class="flex justify-between items-center flex-1 gap-2 mb-4">
            <form class="w-full" @submit.prevent>
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute right-4 top-1/2 -translate-y-1/2 w-6"/>

                    <input
                        v-model="form.search"
                        @input="submitForm"
                        type="text"
                        name="search"
                        placeholder="Search"
                        class="w-full rounded-md border-none pl-4 pr-14 py-5 bg-gray-50 focus:ring-0 focus:ring-offset-0 focus:border-none"
                    >
                </div>
            </form>
        </div>

        <TransitionGroup
            tag="ul"
            name="list"
            class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-md"
            appear
        >
            <li
                v-for="(user, index) in users.data"
                :key="'user-' + index"
                class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6"
            >
                <div class="flex min-w-0 gap-x-4">
                    <img v-if="user.profile_photo_url" class="h-12 w-12 flex-none rounded-full bg-gray-50"
                         :src="user.profile_photo_url" alt="profile photo"/>
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            {{ user.full_name }}
                        </p>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            <a :href="`mailto:${user.email}`" class="relative truncate hover:underline">
                                {{ user.email }}
                            </a>
                        </p>
                    </div>
                </div>

                <Link :href="route('users.edit', {user: user})" class="flex shrink-0 items-center gap-1 cursor-pointer">
                    <p>Edit</p>
                    <ChevronRightIcon class="h-5 w-5 flex-none text-gray-400" aria-hidden="true"/>
                </Link>
            </li>
        </TransitionGroup>

        <Pagination v-if="users.data.length !== 0" :links="users.links"/>
    </div>
</template>

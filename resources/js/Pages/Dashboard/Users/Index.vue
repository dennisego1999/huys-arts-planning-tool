<script setup>
import {useI18n} from "vue-i18n";
import {debounce} from "lodash";
import {MagnifyingGlassIcon, TrashIcon, EyeIcon, PencilSquareIcon, SparklesIcon, PlusCircleIcon} from "@heroicons/vue/20/solid";
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Pagination.vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    users: Object,
});

//Set translation
const {t} = useI18n();

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
        <div class="flex justify-between items-center flex-1 gap-6 mb-4">
            <form class="w-full" @submit.prevent>
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute z-10 right-4 top-1/2 -translate-y-1/2 w-6 text-gray-300"/>

                    <input
                        v-model="form.search"
                        @input="submitForm"
                        type="text"
                        name="search"
                        :placeholder="t('spa.pages.dashboard.search')"
                        class="drop-shadow-lg text-black w-full rounded-md border-none pl-4 pr-14 py-5 bg-gray-50 focus:ring-0 focus:ring-offset-0 focus:border-none"
                    >
                </div>
            </form>

            <PlusCircleIcon
                v-if="usePage().props.policies.can.manageUsers"
                @click="router.visit(route('users.create'))"
                class="text-gray-600 h-12 w-12 rounded-full overflow-hidden cursor-pointer"
            />
        </div>

        <TransitionGroup
            v-if="users.data && users.data.length > 0"
            tag="ul"
            name="list"
            class="relative z-0 divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-md"
            appear
        >
            <li
                v-for="(user, index) in users.data"
                :key="'user-' + index"
                class="relative flex justify-between items-center gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6"
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

                <div class="flex justify-between items-center gap-12">
                    <div class="flex flex-col gap-2 justify-start items-center">
                        <p class="text-bases">{{ t('spa.pages.dashboard.status') }}</p>

                        <div
                            v-if="!!user.email_verified_at"
                            class="p-1 rounded-md bg-green-400 pointer-events-none"
                        >
                            <small class="font-bold text-white">Verified</small>
                        </div>

                        <div
                            v-else
                            class="p-1 rounded-md bg-blue-400 pointer-events-none"
                        >
                            <small class="font-bold text-white">Registered</small>
                        </div>
                    </div>

                    <div class="flex justify-between items-center gap-2">
                        <Link
                            v-if="usePage().props.policies.can.impersonate"
                            :href="route('impersonate', {user: user})"
                            method="post"
                            as="button"
                            class="flex shrink-0 items-center gap-1"
                        >
                            <div class="p-2 rounded-md bg-gray-300 cursor-pointer">
                                <SparklesIcon class="h-5 w-5 flex-none text-white"/>
                            </div>
                        </Link>

                        <Link
                            :href="route('users.show', {user: user})"
                            class="flex shrink-0 items-center gap-1"
                        >
                            <div class="p-2 rounded-md bg-gray-300 cursor-pointer">
                                <EyeIcon class="h-5 w-5 flex-none text-white"/>
                            </div>
                        </Link>

                        <Link
                            v-if="usePage().props.policies.can.manageUsers"
                            :href="route('users.edit', {user: user})"
                            class="flex shrink-0 items-center gap-1"
                        >
                            <div class="p-2 rounded-md bg-gray-300 cursor-pointer">
                                <PencilSquareIcon class="h-5 w-5 flex-none text-white"/>
                            </div>
                        </Link>

                        <Link
                            v-if="usePage().props.policies.can.manageUsers"
                            :href="route('users.destroy', {user: user})"
                            method="delete"
                            as="button"
                            class="flex shrink-0 items-center gap-1"
                        >
                            <div class="p-2 rounded-md bg-red-400 cursor-pointer">
                                <TrashIcon class="h-5 w-5 flex-none text-white"/>
                            </div>
                        </Link>
                    </div>
                </div>
            </li>
        </TransitionGroup>

        <p v-else>No users found...</p>

        <Pagination v-if="users.data.length !== 0" :links="users.links"/>
    </div>
</template>

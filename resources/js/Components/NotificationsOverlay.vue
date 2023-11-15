<script setup>
import {useI18n} from "vue-i18n";
import {XMarkIcon, CheckCircleIcon} from "@heroicons/vue/24/outline";
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";

// Define emits
const emit = defineEmits(['close']);

// Define props
const props = defineProps({
    show: Boolean,
});

//Set translation
const {t} = useI18n();

// Set variables
const tabs = ref([{id: 'unread', current: true}, {id: 'all', current: false}]);
const activeTab = ref(tabs.value[0].id);
const form = useForm({
    url: '',
});

// Set computed variables
const unreadNotifications = computed(() => {
    return usePage().props.notifications.filter(notification => !notification.read_at);
});

const filteredNotifications = computed(() => {
    if(activeTab.value === 'unread') {
        return unreadNotifications.value;
    }

    return usePage().props.notifications;
});

// Define functions
function close() {
    emit('close');
}

function markAsRead(notification) {
    if(notification.read_at) {
        return;
    }

    // Set url
    form.url = notification.url;

    // Mark the notification as read
    form.post(route('notification.read', {notification: notification}), {
        onSuccess: () => {
            if(notification.url) {
                // Close overlay
                close();
            }
        }
    });
}

function selectTab(tab) {
    // Make sure all tabs are disabled
    tabs.value.forEach(tabToReset => tabToReset.current = false);

    // Active given tab
    tab.current = true;

    //Set active tab reactive
    activeTab.value = tab.id;
}
</script>

<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="fixed z-40" @close="close">
            <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed lg:hidden inset-0 bg-gray-900/80" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full">
                        <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
                            <DialogPanel class="pointer-events-auto w-screen max-w-md">
                                <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                                    <div class="bg-indigo-700 px-4 py-6 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <DialogTitle class="text-base font-semibold leading-6 text-white">
                                                {{ t('spa.notifications.label') }}
                                            </DialogTitle>

                                            <div class="ml-3 flex h-7 items-center">
                                                <button
                                                    type="button"
                                                    class="relative rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none"
                                                    @click="close"
                                                >
                                                    <span class="absolute -inset-2.5" />
                                                    <span class="sr-only">Close panel</span>
                                                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="relative flex flex-col flex-1 gap-4 px-4 py-6 sm:px-6">
                                        <div class="flex space-x-4" aria-label="Tabs">
                                            <div
                                                v-for="tab in tabs"
                                                :key="tab.id"
                                                :class="[tab.current ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700', 'rounded-md px-3 py-2 text-sm font-medium']"
                                                class="capitalize cursor-pointer transition-colors duration-500"
                                                @click="selectTab(tab)"
                                            >
                                                {{ tab.id }}
                                            </div>
                                        </div>

                                        <Transition name="fade" mode="out-in">
                                            <div v-if="filteredNotifications.length !== 0" class="overflow-hidden rounded-md bg-white shadow-lg">
                                                <ul role="list" class="divide-y divide-gray-200">
                                                    <li
                                                        v-for="(notification, index) in filteredNotifications"
                                                        :key="'notification-' + index"
                                                        class="px-6 py-4"
                                                    >
                                                        <div
                                                            class="flex justify-between items-center w-full"
                                                            :class="{'cursor-pointer': !notification.read_at}"
                                                            @click="markAsRead(notification)"
                                                        >
                                                            <div class="flex flex-col justify-center items-start gap-1">
                                                                <p
                                                                    v-if="notification.label"
                                                                    class="text-sm font-semibold leading-6 text-gray-900"
                                                                >
                                                                    {{ notification.label }}
                                                                </p>

                                                                <p
                                                                    v-if="notification.message"
                                                                    class="text-xs leading-5 text-gray-500"
                                                                >
                                                                    {{ notification.message }}
                                                                </p>
                                                            </div>

                                                            <CheckCircleIcon
                                                                v-if="!notification.read_at"
                                                                class="h-7 w-7 text-indigo-600"
                                                            />
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <p v-else-if="filteredNotifications.length === 0 && activeTab === 'unread'">
                                                {{ t('spa.notifications.no_unread_notifications') }}
                                            </p>

                                            <p v-else>
                                                {{ t('spa.notifications.no_notifications') }}
                                            </p>
                                        </Transition>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

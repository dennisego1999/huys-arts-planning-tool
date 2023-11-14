<script setup>
import {useI18n} from "vue-i18n";
import {computed, nextTick, onUnmounted, ref, watch} from "vue";
import {usePage, Link, router} from "@inertiajs/vue3";
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {Bars3Icon, HomeIcon, XMarkIcon, UserIcon, UserGroupIcon, LanguageIcon} from "@heroicons/vue/24/outline";
import {useClearToast, useShowToast} from "@/Composables/Toastification";
import NavigationDropdown from "@/Components/NavigationDropdown.vue";

// Set translation
const {t} = useI18n();

// Get the UUID
const flashUuid = computed(() => usePage().props.flash.uuid);

// Define variables
const isNavigationDropdownOpen = ref(false);
const sidebarOpen = ref(false);
const navigationItems = ref([
    {
        name: t('spa.pages.dashboard.label'),
        href: route('dashboard'),
        icon: HomeIcon,
        check: !!usePage().props.auth.user.email_verified_at,
        current: usePage().props.currentRouteName === 'dashboard'
    },
    {
        name: t('spa.pages.users.label'),
        href: route('users.index'),
        icon: UserIcon,
        check: !!usePage().props.auth.user.email_verified_at && usePage().props.policies.can.manageUsers,
        current: usePage().props.currentRouteName === 'users.index'
    },
    {
        name: t('spa.pages.dance_groups.label'),
        href: route('dance-groups.index'),
        icon: UserGroupIcon,
        check: !!usePage().props.auth.user.email_verified_at,
        current: usePage().props.currentRouteName === 'dance-groups.index'
    },
    {
        name: t('spa.pages.translations.label'),
        href: route('translations.index'),
        icon: LanguageIcon,
        check: !!usePage().props.auth.user.email_verified_at && usePage().props.policies.can.manageTranslations,
        current: usePage().props.currentRouteName === 'translations.index'
    },
]);

// Define function
function setActiveNavItem(item) {
    // Disable previous
    const previousActiveNavItem = navigationItems.value.find(itemToReset => itemToReset.current);
    if(previousActiveNavItem) {
        previousActiveNavItem.current = false;
    }

    if(item) {
        // Enable new nav item
        item.current = true;
    }
}

function toggleNavigationDropdown() {
    isNavigationDropdownOpen.value = !isNavigationDropdownOpen.value;
}

function closeNavigationDropdown() {
    isNavigationDropdownOpen.value = false;
}

function openProfile() {
    // Set active item
    setActiveNavItem(null);

    // Close dropdown
    closeNavigationDropdown();

    // Got to profile
    router.visit(route('profile.show'));
}

function fetchUnreadNotifications() {
    axios.get(route('notification.index'))
        .then(response => {
            response.data.forEach((notification) => {
                if(notification.data.title && notification.data.text) {
                    // Show toast notification
                    useClearToast(notification.id);
                    useShowToast(
                        notification.data.title ? notification.data.title : null,
                        notification.data.text ? notification.data.text : null,
                        notification.data.type ? notification.data.type : 'info',
                        {
                            id: notification.id,
                        }
                    );
                }

                // Mark the notification as read
                axios.post(route('notification.read', {notification: notification.id}));
            })
        });
}

function listenForPusherNotifications() {
    Echo.private(`users.${usePage().props.auth.user.id}`)
        .notification((notification) => {
            if(notification.title || notification.text) {
                // Show toast notification
                useClearToast(notification.id);
                useShowToast(
                    notification.title ? notification.title : null,
                    notification.text ? notification.text : null,
                    notification.type ? notification.type  : 'info',
                    {
                        id: notification.id,
                    }
                );
            }

            // Mark the notification as read
            axios.post(route('notification.read', {notification: notification.id}));
        });
}

function removePrivateServerEventListeners() {
    for (const channelId in Echo.connector.channels) {
        Echo.leave(channelId);
    }
}

nextTick(() => {
    // Remove data props
    document.getElementById('app').removeAttribute('data-page');
});

// Handle success messages
watch(
    () => usePage().props.flash.success,
    (message) => {
        if (!message || !flashUuid.value) {
            return;
        }

        // Abort if we already had this flashed message
        if (sessionStorage.getItem('flashSuccess') === flashUuid.value) {
            return;
        }

        // Toast the flashed success message
        const successId = 'flash-success-toast';

        useClearToast(successId);
        useShowToast(
            null,
            message.toString(),
            'success',
            {
                id: successId,
            }
        );

        usePage().props.flash.success = null;
        sessionStorage.setItem('flashSuccess', flashUuid.value);
    },
    {
        immediate: true
    }
);

// Handle error messages
watch(
    () => usePage().props.flash.error,
    (message) => {
        if (!message || !flashUuid.value) {
            return;
        }

        // Abort if we already had this flashed message
        if (sessionStorage.getItem('flashError') === flashUuid.value) {
            return;
        }

        // Toast the flashed error
        const error = 'flash-error-toast';

        useClearToast(error);
        useShowToast(
            null,
            message.toString(),
            'error',
            {
                id: error,
            }
        );

        usePage().props.flash.error = null;
        sessionStorage.setItem('flashError', flashUuid.value);
    },
    {
        immediate: true
    }
);

// Listen for pusher notifications
watch(() => usePage().props.auth.user, (newValue, oldValue) => {
    if (!newValue) {
        removePrivateServerEventListeners();
        return;
    }

    if (typeof oldValue === 'undefined') {
        listenForPusherNotifications();
        fetchUnreadNotifications();
    }
}, {immediate: true});

// Listen for validation errors
onUnmounted(() => {
    router.on('error', (e) => {
        // Retrieve the errors out of the event
        let errors = Object.values(e?.detail?.errors) || [];
        errors = new Set(errors);

        // Print each error
        errors.forEach((error) => {
            // Set toast id
            const errorId = 'error-toast';

            // Toast
            useClearToast(errorId);
            useShowToast(
                null,
                error,
                "error",
                {
                    id: errorId
                }
            );
        });
    });
});
</script>

<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>

                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-2">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=white" alt="Your Company" />
                                </div>

                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigationItems" :key="item.name">
                                                    <Link
                                                        v-if="item.check"
                                                        class="transition-colors cursor-pointer"
                                                        :href="item.href"
                                                        :class="[item.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']"
                                                        @click="setActiveNavItem(item)"
                                                    >
                                                        <component :is="item.icon" :class="[item.current ? 'text-white' : 'text-indigo-200 group-hover:text-white', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                                        {{ item.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6">
                <div class="flex h-16 shrink-0 items-center">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=white" alt="Your Company" />
                </div>

                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigationItems" :key="item.name">
                                    <Link
                                        v-if="item.check"
                                        class="transition-colors cursor-pointer"
                                        :href="item.href"
                                        :class="[item.current ? 'bg-indigo-700 text-white' : 'text-indigo-200 hover:text-white hover:bg-indigo-700', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']"
                                        @click="setActiveNavItem(item)"
                                    >
                                        <component :is="item.icon" :class="[item.current ? 'text-white' : 'text-indigo-200 group-hover:text-white', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li v-if="usePage().props.auth.user" class="-mx-6 mt-auto">
                            <Transition name="fade">
                                <NavigationDropdown
                                    v-if="isNavigationDropdownOpen"
                                    @openProfile="openProfile"
                                />
                            </Transition>

                            <div
                                @click="toggleNavigationDropdown"
                                class="flex items-center cursor-pointer gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-indigo-700"
                            >
                                <img class="h-8 w-8 rounded-full bg-indigo-700" :src="usePage().props.auth.user.profile_photo_url" alt="profile photo" />
                                <span class="sr-only">Your profile</span>
                                <span aria-hidden="true">{{ usePage().props.auth.user.full_name }}</span>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-indigo-600 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-indigo-200 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>

            <div class="flex-1 text-sm font-semibold leading-6 text-white">Dashboard</div>

            <Link v-if="usePage().props.auth.user" :href="route('profile.show')">
                <span class="sr-only">Your profile</span>
                <img class="h-8 w-8 rounded-full bg-indigo-700" :src="usePage().props.auth.user.profile_photo_url" alt="profile photo" />
            </Link>
        </div>

        <main class="py-4 sm:py-6 lg:py-8 lg:pl-72">
            <div class="px-4 sm:px-6 lg:px-8">
                <Transition name="fade" mode="out-in">
                    <slot/>
                </Transition>
            </div>
        </main>
    </div>
</template>

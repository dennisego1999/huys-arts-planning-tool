<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ChevronLeftIcon, ChevronRightIcon, EllipsisHorizontalIcon } from '@heroicons/vue/20/solid';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputField from '@/Components/InputField.vue';
import InputError from '@/Components/InputError.vue';
import MultiselectDropdown from '@/Components/MultiselectDropdown.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Define props
const props = defineProps({
	weekInfo: Object,
	users: Array
});

console.log(props.weekInfo);

// Set translation
const { t } = useI18n();

// Set variables
const isEventModalOpen = ref(false);
const eventTypes = ref([
	{
		id: 'lesson'
	}
]);
const form = useForm({
	name: {},
	starts_at: null,
	ends_at: null,
	type: null,
	users: []
});

// Set functions
function openEventModal() {
	isEventModalOpen.value = true;
}

function closeEventModal() {
	isEventModalOpen.value = false;
}

function addEvent() {
	// Store the router
	form.post(route('calendar.store'), {
		onSuccess: () => {
			// Close modal
			closeEventModal();
		},
		onError: (error) => {
			console.error(error);
		}
	});
}
</script>

<template>
	<div>
		<Head :title="t('spa.pages.calendar.label')" />

		<div class="flex h-full flex-col">
			<header class="flex flex-none items-center justify-between border-b border-gray-200 px-6 py-4">
				<h1 class="text-base font-semibold leading-6 text-gray-900">
					<time datetime="2022-01">{{ weekInfo.current_week_label }}</time>
				</h1>
				<div class="flex items-center">
					<div
						class="relative flex items-center rounded-md border border-gray-300 bg-white shadow-sm md:items-stretch overflow-hidden"
					>
						<Link
							v-if="weekInfo.urls['previous_week_url']"
							:href="weekInfo.urls['previous_week_url']"
							class="flex h-9 w-12 items-center justify-center pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50"
						>
							<ChevronLeftIcon class="h-5 w-5" />
						</Link>

						<div
							v-else
							class="flex cursor-not-allowed h-9 w-12 items-center justify-center pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50"
						>
							<ChevronLeftIcon class="h-5 w-5" />
						</div>

						<Link
							:href="weekInfo.urls['this_week_url']"
							class="hidden md:grid md:place-content-center px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative"
						>
							{{ t('spa.pages.calendar.today') }}
						</Link>

						<span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden" />

						<Link
							:href="weekInfo.urls['next_week_url']"
							class="flex h-9 w-12 items-center justify-center pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50"
						>
							<ChevronRightIcon class="h-5 w-5" />
						</Link>
					</div>

					<div v-if="usePage().props.policies.can.manageCalendar" class="hidden md:flex md:items-center">
						<div class="ml-6 h-6 w-px bg-gray-300" />

						<button
							@click="openEventModal"
							class="ml-6 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
						>
							{{ t('spa.pages.calendar.add_event') }}
						</button>
					</div>

					<Menu as="div" class="relative ml-6 md:hidden">
						<MenuButton
							class="-mx-2 flex items-center rounded-full border border-transparent p-2 text-gray-400 hover:text-gray-500"
						>
							<EllipsisHorizontalIcon class="h-4 w-4" />
						</MenuButton>

						<transition
							enter-active-class="transition ease-out duration-100"
							enter-from-class="transform opacity-0 scale-95"
							enter-to-class="transform opacity-100 scale-100"
							leave-active-class="transition ease-in duration-75"
							leave-from-class="transform opacity-100 scale-100"
							leave-to-class="transform opacity-0 scale-95"
						>
							<MenuItems
								class="absolute right-0 z-10 mt-3 w-fit origin-top-right overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
								:class="{ 'divide-y divide-gray-100': usePage().props.policies.can.manageCalendar }"
							>
								<div v-if="usePage().props.policies.can.manageCalendar" class="py-1">
									<MenuItem v-slot="{ active }">
										<button
											@click="openEventModal"
											class="whitespace-nowrap"
											:class="[
												active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
												'block px-4 py-2 text-sm'
											]"
										>
											{{ t('spa.pages.calendar.add_event') }}
										</button>
									</MenuItem>
								</div>

								<div class="py-1">
									<MenuItem v-slot="{ active }">
										<Link
											class="whitespace-nowrap"
											:href="weekInfo.urls['this_week_url']"
											:class="[
												active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
												'block px-4 py-2 text-sm'
											]"
										>
											Go to today
										</Link>
									</MenuItem>
								</div>
							</MenuItems>
						</transition>
					</Menu>
				</div>
			</header>

			<div ref="container" class="isolate flex flex-auto flex-col overflow-auto bg-white">
				<div style="width: 165%" class="flex max-w-full flex-none flex-col sm:max-w-none md:max-w-full">
					<div
						ref="containerNav"
						class="sticky top-0 z-30 flex-none bg-white shadow ring-1 ring-black ring-opacity-5 sm:pr-8"
					>
						<div class="grid grid-cols-7 text-sm leading-6 text-gray-500 sm:hidden">
							<button
								v-for="(date, index) in weekInfo.dates"
								:key="'extra-short-date-' + index"
								type="button"
								class="flex flex-col items-center pb-3 pt-2"
							>
								{{ date.day_extra_short }}

								<span class="mt-1 flex h-8 w-8 items-center justify-center font-semibold text-gray-900">
									{{ date.day_number }}
								</span>
							</button>
						</div>

						<div
							class="-mr-px hidden grid-cols-7 divide-x divide-gray-100 border-r border-gray-100 text-sm leading-6 text-gray-500 sm:grid"
						>
							<div class="col-end-1 w-14" />

							<div
								v-for="(date, index) in weekInfo.dates"
								:key="'date-' + index"
								class="flex items-center justify-center py-3"
							>
								<div class="flex items-center justify-center gap-1 font-semibold">
									<p class="font-light">
										{{ date.day_short }}
									</p>

									<p
										:class="{
											'grid place-content-center h-8 w-8 rounded-full bg-indigo-600 text-white':
												date.is_current
										}"
									>
										{{ date.day_number }}
									</p>
								</div>
							</div>
						</div>
					</div>

					<div class="flex flex-auto">
						<div class="sticky left-0 z-10 w-14 flex-none bg-white ring-1 ring-gray-100" />
						<div class="grid flex-auto grid-cols-1 grid-rows-1">
							<!-- Horizontal lines -->
							<div
								class="col-start-1 col-end-2 row-start-1 grid divide-y divide-gray-100"
								style="grid-template-rows: repeat(48, minmax(3.5rem, 1fr))"
							>
								<div ref="containerOffset" class="row-end-1 h-7" />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										12AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										1AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										2AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										3AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										4AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										5AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										6AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										7AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										8AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										9AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										10AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										11AM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										12PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										1PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										2PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										3PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										4PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										5PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										6PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										7PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										8PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										9PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										10PM
									</div>
								</div>
								<div />
								<div>
									<div
										class="sticky left-0 z-20 -ml-14 -mt-2.5 w-14 pr-2 text-right text-xs leading-5 text-gray-400"
									>
										11PM
									</div>
								</div>
								<div />
							</div>

							<!-- Vertical lines -->
							<div
								class="col-start-1 col-end-2 row-start-1 hidden grid-cols-7 grid-rows-1 divide-x divide-gray-100 sm:grid sm:grid-cols-7"
							>
								<div class="col-start-1 row-span-full" />
								<div class="col-start-2 row-span-full" />
								<div class="col-start-3 row-span-full" />
								<div class="col-start-4 row-span-full" />
								<div class="col-start-5 row-span-full" />
								<div class="col-start-6 row-span-full" />
								<div class="col-start-7 row-span-full" />
								<div class="col-start-8 row-span-full w-8" />
							</div>

							<!-- Events -->
							<ol
								class="col-start-1 col-end-2 row-start-1 grid grid-cols-1 sm:grid-cols-7 sm:pr-8"
								style="grid-template-rows: 1.75rem repeat(288, minmax(0, 1fr)) auto"
							>
								<li class="relative mt-px flex sm:col-start-3" style="grid-row: 74 / span 12">
									<a
										href="#"
										class="group absolute inset-1 flex flex-col overflow-y-auto rounded-lg bg-blue-50 p-2 text-xs leading-5 hover:bg-blue-100"
									>
										<p class="order-1 font-semibold text-blue-700">Breakfast</p>
										<p class="text-blue-500 group-hover:text-blue-700">
											<time datetime="2022-01-12T06:00">6:00 AM</time>
										</p>
									</a>
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>

		<Modal :show="isEventModalOpen" @close="closeEventModal">
			<form @submit.prevent>
				<div class="flex flex-col gap-8">
					<div>
						<InputLabel for="name" :value="t('spa.labels.name')" />

						<InputField
							v-model="form.name[usePage().props.locales.currentLocale]"
							type="text"
							name="name"
							id="name"
							class="mt-1 block w-full"
						/>

						<InputError :message="form.errors.name" class="mt-2" />
					</div>

					<div>
						<InputLabel for="start-at" :value="t('spa.labels.starts_at')" />

						<InputField
							v-model="form.starts_at"
							type="datetime-local"
							name="start-at"
							id="start-at"
							class="mt-1 block w-full"
						/>

						<InputError :message="form.errors.starts_at" class="mt-2" />
					</div>

					<div>
						<InputLabel for="ends-at" :value="t('spa.labels.ends_at')" />

						<InputField
							v-model="form.ends_at"
							type="datetime-local"
							name="ends-at"
							id="ends-at"
							class="mt-1 block w-full"
						/>

						<InputError :message="form.errors.ends_at" class="mt-2" />
					</div>

					<div>
						<InputLabel for="type" :value="t('spa.labels.event_type')" />

						<MultiselectDropdown
							v-model="form.type"
							id="type"
							class="mt-1"
							:options="eventTypes"
							:single-item="true"
							attribute="id"
						/>

						<InputError :message="form.errors.type" class="mt-2" />
					</div>

					<div>
						<InputLabel for="users" :value="t('spa.pages.users.label')" />

						<MultiselectDropdown
							v-model="form.users"
							id="users"
							class="mt-1"
							:options="users"
							:add-all="true"
							attribute="full_name"
						/>

						<InputError :message="form.errors.users" class="mt-2" />
					</div>

					<PrimaryButton @click="addEvent">
						{{ t('spa.buttons.add') }}
					</PrimaryButton>
				</div>
			</form>
		</Modal>
	</div>
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import { nextTick } from 'vue';
import { gsap } from 'gsap';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchBar from '@/Components/SearchBar.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Define props
const props = defineProps({
	groups: Object
});

// Set translation
const { t } = useI18n();

// Get url params
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

// Set forms variable
const form = useForm({
	search: urlParams.get('search') ? urlParams.get('search') : null
});

nextTick(() => {
	// Animated in
	gsap.from('.dance-group', {
		opacity: 0,
		yPercent: 10,
		duration: 0.4,
		stagger: 0.1,
		ease: 'power1.out'
	});
});

// Define functions
function removeGroup(group) {
	router.delete(route('dance-groups.destroy', { dance_group: group }));
}
</script>

<template>
	<div class="flex flex-col gap-6">
		<Head :title="t('spa.pages.dance_groups.label')" />

		<div class="sm:flex sm:items-center">
			<div class="sm:flex-auto">
				<h1 class="text-base font-semibold leading-6 text-gray-900">
					{{ t('spa.pages.dance_groups.label') }}
				</h1>

				<p class="mt-2 text-sm text-gray-700">
					{{ t('spa.pages.dance_groups.description') }}
				</p>
			</div>

			<div v-if="usePage().props.policies.can.manageDanceGroups" class="flex justify-end items-center gap-4">
				<PrimaryButton :href="route('dance-groups.create')">
					{{ t('spa.buttons.create_dance_group') }}
				</PrimaryButton>
			</div>
		</div>

		<SearchBar :form="form" :href="route('dance-groups.index')" />

		<div
			v-if="groups.data.length !== 0"
			class="mx-auto grid max-w-2xl grid-cols-1 gap-8 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 xl:grid-cols-4"
		>
			<div
				class="relative dance-group drop-shadow-xl rounded-md bg-gray-50"
				v-for="(group, index) in groups.data"
				:key="'dance-group-' + index"
			>
				<Link :href="route('dance-groups.show', { dance_group: group })" class="relative z-0">
					<img
						v-if="group.image"
						class="aspect-[14/13] w-full rounded-t-2xl object-cover"
						:src="group.image.original_url"
						alt="dance group image"
					/>
					<div v-else class="aspect-[14/13] w-full rounded-t-2xl object-cover bg-gray-300"></div>

					<h3 class="text-lg font-semibold leading-8 tracking-tight text-gray-600 p-3">{{ group.name }}</h3>
				</Link>

				<TrashIcon
					v-if="usePage().props.policies.can.manageDanceGroups"
					@click="removeGroup(group)"
					class="absolute z-10 top-4 right-4 h-9 w-9 p-1 bg-red-400 rounded-md text-white cursor-pointer"
				/>
			</div>
		</div>

		<p v-else class="text-base">
			{{ t('spa.pages.dance_groups.no_groups') }}
		</p>

		<Pagination v-if="groups.data.length !== 0" :links="groups.meta.links" />
	</div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	downloadFile: {
		type: Boolean,
		default: false
	},
	method: {
		type: String,
		default: 'get'
	},
	href: {
		type: String,
		default: null
	}
});
</script>

<template>
	<a
		v-if="href && downloadFile"
		class="inline-flex items-center w-fit px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
		:href="href"
	>
		<slot />
	</a>

	<Link
		v-else-if="href"
		class="inline-flex items-center w-fit px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
		:href="href"
		:method="method"
		:as="method === 'post' ? 'button' : 'a'"
	>
		<slot />
	</Link>

	<button
		v-else
		class="inline-flex items-center w-fit px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
	>
		<slot />
	</button>
</template>

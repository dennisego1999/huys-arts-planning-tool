<script setup>
import { router } from '@inertiajs/vue3';

//Define emits
const emit = defineEmits(['open-profile']);

//Define functions
function openProfile() {
	emit('open-profile');
}

function logout() {
	router.post(route('logout'));
}
</script>

<template>
	<div class="flex flex-col rounded-md overflow-hidden bg-white shadow-lg mx-4 mb-4">
		<div class="text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors py-2 px-3" @click="openProfile">
			Profile
		</div>

		<div class="text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors py-2 px-3" @click="logout">
			Logout
		</div>
	</div>
</template>

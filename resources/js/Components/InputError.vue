<script setup>
defineProps({
	message: String
});
</script>

<template>
	<div v-show="message">
		<p class="first-letter:capitalize text-sm text-red-500">
			{{ message }}
		</p>
	</div>
</template>

<script setup>
defineProps({
	title: String,
	text: String
});
</script>

<template>
	<div>
		<strong v-if="title">{{ title }}</strong>
		<p v-if="text">{{ text }}</p>
	</div>
</template>

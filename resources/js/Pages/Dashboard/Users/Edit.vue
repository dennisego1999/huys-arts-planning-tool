<script setup>
import { useI18n } from 'vue-i18n';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputField from '@/Components/InputField.vue';
import InputLabel from '@/Components/InputLabel.vue';
import MultiselectDropdown from '@/Components/MultiselectDropdown.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Define props
const props = defineProps({
	user: Object,
	roles: Array
});

// Set translation
const { t } = useI18n();

// Define variables
const form = useForm({
	first_name: props.user.first_name,
	last_name: props.user.last_name,
	email: props.user.email,
	address: props.user.address,
	city: props.user.city,
	province: props.user.province,
	zip: props.user.zip,
	roles: props.user.roles ?? [],
	photo: null
});

// Define functions
function submitForm() {
	form.put(route('users.update', { user: props.user }));
}
</script>

<template>
	<form @submit.prevent>
		<div class="flex flex-col gap-8">
			<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
				<div class="sm:col-span-3">
					<InputLabel for="first-name" :value="t('spa.labels.first_name')" />

					<InputField
						v-model="form.first_name"
						type="text"
						name="first-name"
						id="first-name"
						class="mt-1 block w-full"
					/>

					<InputError :message="form.errors.first_name" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="last-name" :value="t('spa.labels.last_name')" />

					<InputField
						v-model="form.last_name"
						type="text"
						name="last-name"
						id="last-name"
						class="mt-1 block w-full"
					/>

					<InputError :message="form.errors.last_name" class="mt-2" />
				</div>

				<div class="sm:col-span-4">
					<InputLabel for="email" :value="t('spa.labels.email')" />

					<InputField v-model="form.email" type="text" name="email" id="email" class="mt-1 block w-full" />

					<InputError :message="form.errors.email" class="mt-2" />
				</div>

				<div class="col-span-full">
					<InputLabel for="street-address" :value="t('spa.labels.address')" />

					<InputField
						v-model="form.address"
						type="text"
						name="street-address"
						id="street-address"
						class="mt-1 block w-full"
					/>

					<InputError :message="form.errors.address" class="mt-2" />
				</div>

				<div class="sm:col-span-2 sm:col-start-1">
					<InputLabel for="city" :value="t('spa.labels.city')" />

					<InputField v-model="form.city" type="text" name="city" id="city" class="mt-1 block w-full" />

					<InputError :message="form.errors.city" class="mt-2" />
				</div>

				<div class="sm:col-span-2">
					<InputLabel for="province" :value="t('spa.labels.province')" />

					<InputField
						v-model="form.province"
						type="text"
						name="province"
						id="province"
						class="mt-1 block w-full"
					/>

					<InputError :message="form.errors.province" class="mt-2" />
				</div>

				<div class="sm:col-span-2">
					<InputLabel for="zip" :value="t('spa.labels.zip')" />

					<InputField v-model="form.zip" type="text" name="zip" id="zip" class="mt-1 block w-full" />

					<InputError :message="form.errors.zip" class="mt-2" />
				</div>

				<div class="sm:col-span-4">
					<InputLabel for="roles" :value="t('spa.labels.roles')" />

					<MultiselectDropdown
						v-model="form.roles"
						id="roles"
						class="mt-1"
						:options="roles"
						attribute="name"
					/>

					<InputError :message="form.errors.roles" class="mt-2" />
				</div>
			</div>
		</div>

		<div class="mt-6 flex items-center justify-start gap-x-6">
			<SecondaryButton :href="route('users.index')">
				{{ t('spa.buttons.cancel') }}
			</SecondaryButton>

			<PrimaryButton @click="submitForm">
				{{ t('spa.buttons.save') }}
			</PrimaryButton>
		</div>
	</form>
</template>

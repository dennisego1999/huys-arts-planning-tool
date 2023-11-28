<script setup>
import { ref, toRef } from 'vue';
import { useI18n } from 'vue-i18n';
import { PhotoIcon, PlusCircleIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import MultiselectDropdown from '@/Components/MultiselectDropdown.vue';

// Define emits
const emit = defineEmits(['update:form', 'submit']);

// Define props
const props = defineProps({
	form: Object,
	users: Array,
	edit: {
		type: Boolean,
		default: false
	}
});

// Set translation
const { t } = useI18n();

// Define variables
const dgForm = toRef(props.form);
const isAddMemberModalOpen = ref(false);
const photoInput = ref(null);
const photoPreview = ref(null);

// Define functions
function updatePhotoPreview() {
	const photoFile = photoInput.value.files[0];

	if (!photoFile) return;

	const reader = new FileReader();

	reader.onload = (e) => {
		photoPreview.value = e.target.result;
		dgForm.value.new_image = photoFile;
		emit('update:form', dgForm.value);
	};

	reader.readAsDataURL(photoFile);
}

function selectNewPhoto() {
	dgForm.value.image = null;
	photoInput.value.click();
}

function deletePhoto() {
	// Reset
	photoPreview.value = null;
	dgForm.value.image = null;
	dgForm.value.new_image = null;

	// Clear file input
	clearPhotoFileInput();

	// Update form in parent
	emit('update:form', dgForm.value);
}

function clearPhotoFileInput() {
	if (photoInput.value?.value) {
		photoInput.value.value = null;
	}
}

function openAddMemberModal() {
	isAddMemberModalOpen.value = true;
}

function closeAddMemberModal() {
	isAddMemberModalOpen.value = false;
}

function removeMember(memberToBeRemoved) {
	dgForm.value.members = dgForm.value.members.filter((member) => member !== memberToBeRemoved);
}

function submit() {
	// Submit
	emit('submit');
}
</script>

<template>
	<div class="flex flex-col justify-between items-start gap-10">
		<div class="flex items-center justify-between gap-6 w-full">
			<div class="flex justify-start items-center gap-2">
				<template v-if="!edit">
					<h1 class="text-5xl font-bold">
						{{ t('spa.pages.dance_groups.new_dance_group') }}
					</h1>

					<PlusCircleIcon class="h-8 w-8 text-gray-600" />
				</template>

				<template v-else>
					<h1 class="text-5xl font-bold">
						{{ form.name }}
					</h1>

					<PencilSquareIcon class="h-8 w-8 text-gray-600" />
				</template>
			</div>

			<div class="flex items-center justify-end gap-4">
				<SecondaryButton :href="route('dance-groups.index')">
					{{ t('spa.buttons.cancel') }}
				</SecondaryButton>

				<PrimaryButton @click="submit">
					{{ t('spa.buttons.save') }}
				</PrimaryButton>
			</div>
		</div>

		<form class="flex-1 flex flex-col gap-6 w-full" @submit.prevent>
			<div class="flex justify-between items-stretch w-ful gap-12">
				<div class="flex flex-1 flex-col justify-start items-center gap-6">
					<div class="w-full">
						<label for="name" class="block text-sm font-medium leading-6 text-gray-900">
							{{ t('spa.labels.name') }}
						</label>

						<div class="mt-2">
							<input
								v-model="dgForm.name"
								type="text"
								name="name"
								id="name"
								class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
							/>

							<InputError :message="dgForm.errors.name" class="mt-2" />
						</div>
					</div>

					<div class="w-full">
						<label for="description" class="block text-sm font-medium leading-6 text-gray-900">
							{{ t('spa.labels.description') }}
						</label>

						<div class="mt-2">
							<textarea
								v-model="dgForm.description"
								rows="5"
								type="text"
								name="description"
								id="description"
								class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
							/>

							<InputError :message="dgForm.errors.description" class="mt-2" />
						</div>
					</div>
				</div>

				<div class="flex-1">
					<label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">
						{{ t('spa.labels.photo') }}
					</label>

					<div
						class="mt-2 flex flex-col gap-6 justify-center rounded-lg border border-dashed border-gray-900/25 p-6"
					>
						<!-- Profile Photo File Input -->
						<input
							ref="photoInput"
							type="file"
							class="hidden"
							accept=".png, .jpg, .jpeg"
							@change="updatePhotoPreview"
						/>

						<!-- Current Profile Photo -->
						<div v-if="dgForm.image && dgForm.image.original_url" class="mt-2">
							<img
								:src="dgForm.image.original_url"
								alt="dance group image"
								class="w-full aspect-video object-cover"
							/>
						</div>

						<!-- New Profile Photo Preview -->
						<div v-else class="relative">
							<span
								class="block aspect-video w-full bg-cover bg-no-repeat bg-center rounded-md"
								:class="{ 'bg-gray-300': !photoPreview }"
								:style="'background-image: url(\'' + photoPreview + '\');'"
							/>

							<PhotoIcon
								v-if="!photoPreview"
								class="absolute z-10 top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-14 h-14 text-white"
							/>
						</div>

						<InputError :message="dgForm.errors.new_image" class="mt-2" />

						<div class="flex justify-start items-center gap-6">
							<SecondaryButton
								v-if="dgForm.image || photoPreview"
								type="button"
								class="w-fit"
								@click="deletePhoto"
							>
								{{ t('spa.buttons.remove') }}
							</SecondaryButton>

							<PrimaryButton class="w-fit" type="button" @click="selectNewPhoto">
								{{ t('spa.buttons.select_new_photo') }}
							</PrimaryButton>
						</div>
					</div>
				</div>
			</div>

			<div class="sm:col-span-full flex flex-col gap-6">
				<div class="flex justify-between items-center gap-4 w-full">
					<h1 class="text-2xl text-gray-900">
						{{ t('spa.pages.dance_groups.members.label') }}
					</h1>

					<PrimaryButton @click="openAddMemberModal">
						{{ t('spa.buttons.add') }}
					</PrimaryButton>
				</div>

				<ul
					v-if="dgForm.members.length !== 0"
					role="list"
					class="mx-auto grid max-w-2xl grid-cols-1 gap-8 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3"
				>
					<li
						v-for="member in dgForm.members"
						:key="member.name"
						class="relative flex flex-col justify-center items-center p-8 bg-gray-100 rounded-md"
					>
						<img class="mx-auto h-56 w-56 rounded-full" :src="member.profile_photo_url" alt="" />

						<h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">
							{{ member.full_name }}
						</h3>

						<a
							:href="'mailto:' + member.email"
							class="block whitespace-nowrap overflow-ellipsis max-w-full overflow-hidden text-gray-400 font-bold"
						>
							{{ member.email }}
						</a>

						<TrashIcon
							@click="removeMember(member)"
							class="absolute top-4 right-4 h-9 w-9 p-1 bg-red-400 rounded-md text-white cursor-pointer"
						/>
					</li>
				</ul>

				<p v-else class="text-base">
					{{ t('spa.pages.dance_groups.no_members') }}
				</p>

				<InputError :message="dgForm.errors.members" class="mt-2" />
			</div>

			<Modal :show="isAddMemberModalOpen" @close="closeAddMemberModal">
				<div class="flex flex-col gap-4">
					<h1 class="text-2xl font-bold">
						{{ t('spa.pages.dance_groups.update_members') }}
					</h1>

					<MultiselectDropdown
						v-model="dgForm.members"
						id="roles"
						class="mt-1"
						:options="users"
						:deletable="false"
						attribute="full_name"
					/>

					<PrimaryButton @click="closeAddMemberModal">
						{{ t('spa.buttons.close') }}
					</PrimaryButton>
				</div>
			</Modal>
		</form>
	</div>
</template>

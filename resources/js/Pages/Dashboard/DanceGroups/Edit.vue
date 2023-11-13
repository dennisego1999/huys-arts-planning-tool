<script setup>
import {useI18n} from "vue-i18n";
import {useForm} from "@inertiajs/vue3";
import {useClearToast, useShowToast} from "@/Composables/Toastification";
import AppLayout from "@/Layouts/AppLayout.vue";
import DanceGroupForm from "@/Components/DanceGroupForm.vue";

//Define options
defineOptions({
    layout: AppLayout
});

//Define props
const props = defineProps({
    group: Object,
    users: Array,
});

//Set translation
const {t} = useI18n();

//Define variables
const form = useForm({
    _method: 'put',
    id: props.group.id ?? null, // Post this id to backend to ignore the id of the dance group that's being edited during the unique "name" validation rule
    name: props.group.name ?? null,
    description: props.group.description ?? null,
    image: props.group.image ?? null,
    new_image: null,
    members: props.group.members ?? [],
});

//Define functions
function submit() {
    form.post(route('dance-groups.update', {dance_group: props.group}), {
        onSuccess: () => {
            const successId = 'dance-group-updated-toast';

            useClearToast(successId);
            useShowToast(
                null,
                t('spa.toasts.description.dance_group_updated'),
                'success',
                {
                    id: successId,
                }
            );
        },
        onError: error => {
            console.error(error);
            const errorId = 'dance-group-updated-error-toast';

            useClearToast(errorId);
            useShowToast(
                null,
                t('spa.toasts.description.error'),
                'error',
                {
                    id: errorId,
                }
            );
        }
    });
}
</script>

<template>
    <DanceGroupForm
        v-model:form="form"
        :users="users"
        :edit="true"
        @submit="submit"
    />
</template>

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
    name: null,
    description: null,
    image: null,
    new_image: null,
    members: [],
});

//Define functions
function submit() {
    form.post(route('dance-groups.store', {dance_group: props.group}), {
        onSuccess: () => {
            const successId = 'dance-group-created-toast';

            useClearToast(successId);
            useShowToast(
                null,
                'Dance group has been created...',
                'success',
                {
                    id: successId,
                }
            );
        },
        onError: error => {
            console.error(error);
            const errorId = 'dance-group-created-error-toast';

            useClearToast(errorId);
            useShowToast(
                null,
                'Something went wrong...',
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
        :group="group"
        :users="users"
        @submit="submit"
    />
</template>

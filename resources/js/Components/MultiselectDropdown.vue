<script setup>
import {ref} from "vue";
import {useI18n} from "vue-i18n";
import AngleDownIcon from "@/Components/AngleDownIcon.vue";
import CloseIcon from "@/Components/CloseIcon.vue";

//Define emits
const emit = defineEmits(['update:modelValue']);

//Define props
const props = defineProps({
    options: Array,
    attribute: String,
    modelValue: Array,
    deletable: {
        type: Boolean,
        default: true,
    }
});

//Set translation
const {t} = useI18n();

//Define variables
const selectedOptions = ref(props.modelValue ?? []);
const isDropDownOpen = ref(false);

//Define functions
function toggleDropdown() {
    isDropDownOpen.value = !isDropDownOpen.value;
}

function selectOption(option) {
    if(selectedOptions.value.some(o => o[props.attribute] === option[props.attribute])) {
        return;
    }

    selectedOptions.value.push(option);
    emit('update:modelValue', selectedOptions.value);
}

function deleteOption(optionToBeDeleted) {
    selectedOptions.value = selectedOptions.value.filter(option => option !== optionToBeDeleted)
    emit('update:modelValue', selectedOptions.value);
}
</script>

<template>
    <div class="relative 10 flex flex-wrap justify-start items-center w-full border-none">
        <div class="relative z-0 flex justify-between items-center gap-3 border-[1px] border-gray-300 rounded-md px-3 py-2 w-full">
            <div class="relative z-10 pointer-events-none">
                <p v-if="selectedOptions.length === 0">
                    {{ t('spa.labels.select') }}
                </p>

                <div
                    v-else
                    class="flex flex-wrap justify-start items-center gap-2"
                    :class="{'pointer-events-auto': deletable}"
                >
                    <div
                        v-for="(option, index) in selectedOptions"
                        :key="'selected-option-'+ index"
                        class="flex justify-between items-center gap-1 bg-gray-200 rounded-md px-2 py-1 select-none"
                    >
                        <p class="text-xs">{{ option[attribute] }}</p>

                        <CloseIcon
                            v-if="deletable"
                            @click="deleteOption(option)"
                            class="h-3 w-3 cursor-pointer"
                        />
                    </div>
                </div>
            </div>

            <AngleDownIcon
                class="h-4 w-4 transition-transform"
                :class="{'rotate-180': isDropDownOpen, 'rotate-0': !isDropDownOpen}"
            />

            <div
                class="absolute z-0 inset-0 h-full w-full cursor-pointer"
                @click="toggleDropdown"
            ></div>
        </div>

        <Transition name="fade" mode="out-in">
            <div
                v-if="isDropDownOpen"
                class="absolute z-10 -bottom-2 left-0 overflow-hidden translate-y-full mt-1 w-full h-fit max-h-48 overflow-y-auto flex flex-col justify-start items-start border-[1px] border-gray-300 rounded-md cursor-pointer"
            >
                <div
                    v-for="(option, index) in options"
                    :key="'option-' + index"
                    @click="selectOption(option)"
                    class="bg-white w-full px-3 py-2 select-none transition-all"
                    :class="[selectedOptions.some(o => o[attribute] === option[attribute]) ? 'cursor-not-allowed text-gray-300 ' : 'cursor-pointer hover:bg-gray-500 hover:text-white']"
                >
                    {{ option[attribute] }}
                </div>
            </div>
        </Transition>
    </div>
</template>

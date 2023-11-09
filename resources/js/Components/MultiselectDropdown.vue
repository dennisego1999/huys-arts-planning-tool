<script setup>
import {ref} from "vue";
import AngleDownIcon from "@/Components/AngleDownIcon.vue";
import CloseIcon from "@/Components/CloseIcon.vue";

//Define emits
const emit = defineEmits(['update:modelValue']);

//Define props
const props = defineProps({
    options: Array,
    attribute: String,
    modelValue: Array,
});

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
    <div class="relative flex flex-wrap justify-start items-center w-full border-none">
        <div class="relative flex justify-between items-center border-[1px] border-gray-300 rounded-md cursor-pointer px-3 py-2 w-full">
            <div class="relative z-10 cursor-pointer pr-3">
                <p v-if="selectedOptions.length === 0">Select</p>

                <div v-else class="flex flex-wrap justify-start items-center gap-2">
                    <div
                        v-for="(option, index) in selectedOptions"
                        :key="'selected-option-'+ index"
                        class="flex justify-between items-center gap-1 bg-gray-200 rounded-md px-2 py-1"
                    >
                        <p class="text-xs">{{ option[attribute] }}</p>

                        <CloseIcon @click="deleteOption(option)" class="h-3 w-3"/>
                    </div>
                </div>
            </div>

            <AngleDownIcon
                class="h-4 w-4 transition-transform"
                :class="{'rotate-0': isDropDownOpen, 'rotate-180': !isDropDownOpen}"
            />

            <div
                class="absolute z-0 inset-0 h-full w-full cursor-pointer"
                @click="toggleDropdown"
            ></div>
        </div>

        <div
            v-if="isDropDownOpen"
            class=" mt-1 w-full flex flex-col justify-start items-start border-[1px] border-gray-300 rounded-md cursor-pointer"
        >
            <div
                v-for="(option, index) in options"
                :key="'option-' + index"
                @click="selectOption(option)"
                class="cursor-pointer w-full px-3 py-2 select-none transition-all hover:bg-gray-500 hover:text-white"
                :class="{'cursor-not-allowed opacity-20': selectedOptions.some(o => o[attribute] === option[attribute])}"
            >
                {{ option[attribute] }}
            </div>
        </div>
    </div>
</template>

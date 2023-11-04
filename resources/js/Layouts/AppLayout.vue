<script setup>
import { nextTick } from "vue";

nextTick(() => {
    //Remove data props
    document.getElementById('app').removeAttribute('data-page');
});
</script>

<template>
    <main>
        <slot/>
    </main>
</template>

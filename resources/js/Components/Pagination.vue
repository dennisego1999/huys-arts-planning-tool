<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

// Define props
const props = defineProps({
    links: Array,
});

// Define computed variables
const hasMultiplePages = computed(() => {
    return props.links.filter(link => link.url).length > 1;
});

// Define functions
function getUrl(href) {
    if(!href) {
        return '';
    }

    const url = new URL(href);
    const urlParams = new URLSearchParams(url.search);

    let routeParams = route().params;
    routeParams['page'] = urlParams.get('page');

    return route(route().current(), routeParams);
}
</script>

<template>
    <nav v-if="hasMultiplePages" class="pagination flex justify-center items-center gap-4 w-full mt-4 lg:mt-8">
        <Link
            v-for="(link, index) in links"
            :key="index"
            :href="getUrl(link.url)"
            :class="{
                'inline-flex items-center border-t-2 border-fpb-primary-200 px-4 pt-4 text-sm font-bold text-fpb-primary-200': link.active,
                'inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-dark hover:border-fpb-primary-100 hover:text-fpb-primary-100': !link.active
            }"
        >
            <div v-html="link.label"></div>
        </Link>
    </nav>
</template>

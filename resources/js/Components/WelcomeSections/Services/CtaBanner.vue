<template>
    <div class="max-w-5xl mx-auto animate-fade-in" style="animation-delay: 500ms">
        <div class="bg-secondary rounded-2xl px-8 py-7 flex flex-col sm:flex-row items-center justify-between gap-5">
            <p class="text-primary font-bold text-xl text-center sm:text-left">{{ text }}</p>
            <a
                :href="buttonHref"
                class="flex-shrink-0 bg-primary text-secondary font-bold text-sm px-7 py-3.5
                 rounded-xl hover:bg-primary/90 hover:scale-105 active:scale-100
                 transition-all duration-200 shadow-md whitespace-nowrap"
            >
                {{ buttonLabel }}
            </a>
        </div>
    </div>
</template>

<script setup>

const props  = defineProps({
    text: String,
    buttonLabel: String,
    buttonHref: String
})

</script>

<style scoped>

</style>

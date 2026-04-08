<template>
    <div class="max-w-5xl mx-auto text-center mb-14 animate-fade-in" style="animation-delay: 400ms">
        <h3 class="text-secondary font-bold text-lg mb-5">{{ label }}</h3>
        <div class="flex flex-wrap justify-center gap-3">
        <span
            v-for="skill in skills"
            :key="skill"
            class="px-5 py-2 rounded-full border border-secondary/20 text-secondary/70
                 text-sm font-medium tracking-wide
                 hover:border-secondary hover:text-secondary hover:bg-secondary/5
                 transition-all duration-200 cursor-default"
        >
          {{ skill }}
        </span>
        </div>
    </div>
</template>

<script setup>

// const props = {
//     skills: 'skills',
//     label: 'label'
// }


let skills =  'skills'
let label =  'label'

</script>

<style scoped>

</style>

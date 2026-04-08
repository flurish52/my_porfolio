<template>
    <div class="bg-primary rounded-2xl p-7 border shadow-sm
               border-tertiary/70 border-2 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
        <h3 class="text-xl font-bold text-secondary mb-2">{{ service.title }}</h3>
        <p class="text-secondary/50 text-sm mb-6 leading-relaxed">{{ service.description }}</p>

        <div class="grid grid-cols-2 gap-3">
            <div
                v-for="item in service.items"
                :key="item.label"
                class="flex items-center gap-2.5 text-secondary/70 text-sm"
            >
          <span
              class="flex-shrink-0 w-7 h-7 rounded-lg bg-secondary/5 flex items-center justify-center
                   text-secondary group-hover:bg-secondary group-hover:text-primary transition-all duration-300"
              v-html="item.icon"
          ></span>
                <span class="font-medium">{{ item.label }}</span>
            </div>
        </div>
    </div>

</template>

<script setup>
import { defineProps } from 'vue'
const props = defineProps({
    service: Object,
})

// let service =  'service'

</script>

<style scoped>

</style>

<template>
    <footer class="bg-secondary text-surface">
        <div
            class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-6 px-5 py-10 md:flex-row md:px-8"
        >
            <!-- Name + tagline -->
            <div class="text-center md:text-left">
                <p class="text-base font-extrabold tracking-tight">
                    {{ name }}<span class="text-primary-soft">.</span>
                </p>
                <p v-if="tagline" class="mt-1 max-w-sm text-sm text-surface/70">{{ tagline }}</p>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2" aria-label="Footer navigation">
                <button
                    v-for="link in links"
                    :key="link.id"
                    type="button"
                    class="text-sm font-medium text-surface/80 transition-colors duration-200 hover:text-surface focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-surface"
                    @click="emit('navigate', link.id)"
                >
                    {{ link.label }}
                </button>
            </nav>

            <!-- Copyright -->
            <p class="text-sm text-surface/60">&copy; {{ year }} {{ name }}</p>
        </div>
    </footer>
</template>

<script setup>
import { computed } from 'vue'

defineProps({
    name: { type: String, default: 'Ashobel' },
    tagline: { type: String, default: 'Websites and web apps you can rely on.' },
    // Same order as the page
    links: {
        type: Array,
        default: () => [
            { id: 'home', label: 'Home' },
            { id: 'projects', label: 'Work' },
            { id: 'services', label: 'Services' },
            { id: 'about', label: 'About' },
            { id: 'skills', label: 'Skills' },
            { id: 'contact', label: 'Contact' },
        ],
    },
})

const emit = defineEmits(['navigate'])

const year = computed(() => new Date().getFullYear())
</script>

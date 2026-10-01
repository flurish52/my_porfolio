<script setup>
import Footer from '@/Components/Footer.vue'

defineProps({
    name: {type: String, default: undefined},
    tagline: {type: String, default: undefined},
})

const emit = defineEmits(['navigate'])
</script>

<template>
    <div className="flex min-h-screen flex-col bg-canvas font-sans text-secondary antialiased">
        <!-- Lets keyboard and screen-reader users jump past the navigation -->
        <a
            href="#main"
            className="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-primary focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-surface"
        >
            Skip to content
        </a>

        <!-- Page content (TopNav + sections) -->
        <div className="flex-1">
            <slot/>
        </div>

        <Footer :name="name" :tagline="tagline" @navigate="emit('navigate', $event)"/>
    </div>
</template>

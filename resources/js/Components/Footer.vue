<template>
    <footer class="w-full bg-primary px-6 py-8 text-tertiary ">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">

            <!-- Left: name + tagline -->
            <div class="flex flex-col items-center sm:items-start gap-0.5">
        <span class="font-display font-black text-surface text-base tracking-tight">
          {{ name }}<span class="text-surface/30">.</span>
        </span>
                <span class="font-serif italic text-surface/40 text-xs">
          {{ tagline }}
        </span>
            </div>

            <!-- Center: nav links -->
            <nav class="flex items-center gap-5" aria-label="Footer navigation">
                <button
                    v-for="link in links"
                    :key="link.id"
                    class="text-surface/50 hover:text-surface text-xs font-medium tracking-wide
                 transition-colors duration-200"
                    @click="emit('navigate', link.id)"
                >
                    {{ link.label }}
                </button>
            </nav>

            <!-- Right: copyright -->
            <p class="font-mono text-[0.6rem] tracking-widest uppercase text-surface/30">
                © {{ year }} {{ name }}
            </p>

        </div>
    </footer>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    name: {
        type: String,
        default: 'Atuo Israel',
    },
    tagline: {
        type: String,
        default: 'Crafting the web, one component at a time.',
    },
    links: {
        type: Array,
        default: () => [
            { id: 'home',     label: 'Home'     },
            { id: 'projects', label: 'Projects' },
            { id: 'about',    label: 'About'    },
            { id: 'contact',  label: 'Contact'  },
        ],
    },
})

const emit = defineEmits(['navigate'])

const year = computed(() => new Date().getFullYear())
</script>

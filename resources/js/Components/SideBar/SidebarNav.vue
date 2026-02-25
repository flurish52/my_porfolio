<template>
    <nav class="w-full mt-1" aria-label="Main navigation">

        <!-- Label -->
        <p class="px-3 mb-1.5 text-[0.58rem] font-bold tracking-[0.2em] uppercase text-primary/30">
            Navigate
        </p>

        <ul class="flex flex-col gap-0.5 w-full">
            <li
                v-for="(link, i) in links"
                :key="link.id"
                :style="{ animationDelay: `${0.25 + i * 0.07}s` }"
                class="animate-slide-in"
            >
                <button
                    :class="[
            'relative flex items-center gap-2.5 w-full px-3 py-2.5 rounded-lg text-sm font-medium',
            'transition-all duration-200 overflow-hidden group text-left',
            activeId === link.id
              ? 'text-primary'
              : 'text-primary/45 hover:text-primary/80'
          ]"
                    :aria-current="activeId === link.id ? 'page' : undefined"
                    @click="emit('navigate', link.id)"
                >
                    <!-- Hover / active background fill -->
                    <span
                        :class="[
              'absolute inset-0 rounded-lg transition-all duration-200',
              activeId === link.id
                ? 'bg-primary/10'
                : 'bg-transparent group-hover:bg-primary/5'
            ]"
                    />

                    <!-- Active left border pill -->
                    <span
                        :class="[
              'absolute left-0 top-1/2 -translate-y-1/2 w-0.5 rounded-r-full bg-primary',
              'transition-all duration-300',
              activeId === link.id ? 'h-5 opacity-100' : 'h-0 opacity-0'
            ]"
                    />

                    <!-- Icon -->
                    <span
                        class="relative z-10 flex-shrink-0 w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5"
                        aria-hidden="true"
                        v-html="link.icon || defaultIcon(link.id)"
                    />

                    <!-- Label -->
                    <span class="relative z-10 tracking-wide">{{ link.label }}</span>

                    <!-- Active dot -->
                    <span
                        v-if="activeId === link.id"
                        class="relative z-10 ml-auto w-1.5 h-1.5 rounded-full bg-primary animate-pop"
                    />
                </button>
            </li>
        </ul>
    </nav>
</template>

<script setup>
const props = defineProps({
    links: {
        type: Array,
        default: () => [
            { id: 'home',     label: 'Home',     icon: null },
            { id: 'projects', label: 'Projects', icon: null },
            { id: 'about',    label: 'About Me', icon: null },
            { id: 'skills',   label: 'Skills',   icon: null },
            { id: 'contact',  label: 'Contact',  icon: null },
        ],
    },
    activeId: {
        type: String,
        default: 'home',
    },
})

const emit = defineEmits(['navigate'])

// Inline SVG icons keyed by section id
const icons = {
    home: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
      d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
  </svg>`,

    projects: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
      d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
  </svg>`,

    about: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
  </svg>`,

    skills: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
      d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>
  </svg>`,

    contact: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round"
      d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
  </svg>`,
}

function defaultIcon(id) {
    return icons[id] ?? icons.home
}
</script>

<style scoped>
@keyframes slide-in {
    from { opacity: 0; transform: translateX(-12px); }
    to   { opacity: 1; transform: translateX(0); }
}

@keyframes pop {
    from { transform: scale(0); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

.animate-slide-in { animation: slide-in 0.35s ease both; }
.animate-pop      { animation: pop 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) both; }
</style>

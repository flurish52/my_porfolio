<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'

const props = defineProps({
    name: { type: String, default: '' },
    links: { type: Array, default: () => [] },
    activeSection: { type: String, default: 'home' },
    ctaLabel: { type: String, default: "Let's talk" },
})

const emit = defineEmits(['navigate'])

const open = ref(false)
const closeButton = ref(null)

// Home is reached through the logo, so it isn't repeated in the menu
const menuLinks = computed(() => props.links.filter((l) => l.id !== 'home'))

const initials = computed(() =>
    props.name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((w) => w[0].toUpperCase())
        .join('')
)

function go(id) {
    open.value = false
    emit('navigate', id)
}

// Lock page scroll while the drawer is open, and move focus into it
watch(open, async (isOpen) => {
    document.body.style.overflow = isOpen ? 'hidden' : ''
    if (isOpen) {
        await nextTick()
        closeButton.value?.focus()
    }
})

function onKeydown(e) {
    if (e.key === 'Escape') open.value = false
}

// If the window grows past the mobile breakpoint, close the drawer
const desktopQuery = typeof window !== 'undefined' ? window.matchMedia('(min-width: 768px)') : null
function onBreakpoint(e) {
    if (e.matches) open.value = false
}

onMounted(() => {
    window.addEventListener('keydown', onKeydown)
    desktopQuery?.addEventListener('change', onBreakpoint)
})

onBeforeUnmount(() => {
    window.removeEventListener('keydown', onKeydown)
    desktopQuery?.removeEventListener('change', onBreakpoint)
    document.body.style.overflow = ''
})
</script>

<template>
    <header class="sticky top-0 z-40 border-b border-line bg-surface/90 backdrop-blur-md">
        <nav
            class="mx-auto flex h-16 max-w-6xl items-center justify-between px-5 md:px-8"
            aria-label="Main"
        >
            <!-- Logo / name -->
            <button
                type="button"
                class="flex items-center gap-3 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary"
                @click="go('home')"
            >
                <span
                    class="grid h-9 w-9 place-items-center rounded-full bg-primary text-sm font-bold text-surface"
                    aria-hidden="true"
                >{{ initials }}</span>
                <span class="text-[0.95rem] font-bold tracking-tight text-secondary">{{ name }}</span>
            </button>

            <!-- Desktop links -->
            <div class="hidden items-center gap-8 md:flex">
                <button
                    v-for="link in menuLinks"
                    :key="link.id"
                    type="button"
                    class="text-sm font-medium transition-colors duration-200 hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary"
                    :class="activeSection === link.id ? 'text-primary' : 'text-secondary-muted'"
                    :aria-current="activeSection === link.id ? 'true' : undefined"
                    @click="go(link.id)"
                >
                    {{ link.label }}
                </button>
                <button
                    type="button"
                    class="rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-surface transition-colors duration-200 hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                    @click="go('contact')"
                >
                    {{ ctaLabel }}
                </button>
            </div>

            <!-- Mobile toggle -->
            <button
                type="button"
                class="grid h-10 w-10 place-items-center rounded-lg text-secondary hover:bg-canvas focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary md:hidden"
                :aria-expanded="open"
                aria-controls="mobile-drawer"
                aria-label="Open menu"
                @click="open = true"
            >
                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>
        </nav>
    </header>

    <!--
        Teleported to <body>: the header uses backdrop-blur, which would otherwise
        trap a fixed-position drawer inside the 64px header instead of the screen.
    -->
    <Teleport to="body">
        <div class="md:hidden">
            <!-- Backdrop -->
            <Transition
                enter-active-class="transition-opacity duration-300 ease-out motion-reduce:transition-none"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-200 ease-in motion-reduce:transition-none"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="open"
                    class="fixed inset-0 z-50 bg-secondary/40"
                    aria-hidden="true"
                    @click="open = false"
                ></div>
            </Transition>

            <!-- Drawer -->
            <Transition
                enter-active-class="transition-transform duration-300 ease-out motion-reduce:transition-none"
                enter-from-class="translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition-transform duration-200 ease-in motion-reduce:transition-none"
                leave-from-class="translate-x-0"
                leave-to-class="translate-x-full"
            >
                <aside
                    v-if="open"
                    id="mobile-drawer"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Menu"
                    class="fixed inset-y-0 right-0 z-50 flex w-72 max-w-[85vw] flex-col bg-surface font-sans text-secondary shadow-card"
                >
                    <div class="flex h-16 items-center justify-between border-b border-line px-5">
                        <span class="text-sm font-bold text-secondary">Menu</span>
                        <button
                            ref="closeButton"
                            type="button"
                            class="grid h-10 w-10 place-items-center rounded-lg text-secondary hover:bg-canvas focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary"
                            aria-label="Close menu"
                            @click="open = false"
                        >
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                                <path d="M6 6l12 12M18 6L6 18" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto px-3 py-4">
                        <button
                            v-for="link in menuLinks"
                            :key="link.id"
                            type="button"
                            class="block w-full rounded-lg px-3 py-3 text-left text-base font-medium transition-colors duration-200"
                            :class="activeSection === link.id ? 'bg-primary-soft text-primary' : 'text-secondary hover:bg-canvas'"
                            :aria-current="activeSection === link.id ? 'true' : undefined"
                            @click="go(link.id)"
                        >
                            {{ link.label }}
                        </button>
                    </div>

                    <div class="border-t border-line p-5">
                        <button
                            type="button"
                            class="w-full rounded-lg bg-primary px-5 py-3 text-base font-semibold text-surface transition-colors duration-200 hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                            @click="go('contact')"
                        >
                            {{ ctaLabel }}
                        </button>
                    </div>
                </aside>
            </Transition>
        </div>
    </Teleport>
</template>

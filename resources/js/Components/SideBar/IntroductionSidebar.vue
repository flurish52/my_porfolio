<template>
    <!-- ═══════════════════════════════════════════════
         DESKTOP  — fixed sidebar, 1/5 width
    ════════════════════════════════════════════════ -->
    <aside
        class="hidden md:flex flex-col fixed inset-y-0 left-0
           w-1/5 min-w-[210px] max-w-[270px]
           bg-surface border-r border-primary/10
           shadow-[4px_0_30px_theme(colors.primary/4%)]
           z-50 overflow-y-auto scrollbar-hide"
        aria-label="Portfolio sidebar"
    >
        <SidebarInner
            :photo="photo"
            :name="name"
            :description="description"
            :links="links"
            :active-id="activeSection"
            @navigate="emit('navigate', $event)"
        />
    </aside>

    <!-- ═══════════════════════════════════════════════
         MOBILE  — sticky top bar + slide-in drawer
    ════════════════════════════════════════════════ -->
    <div class="md:hidden">
        <!-- Sticky top bar -->
        <header
            class="fixed   top-0 left-0 right-0 w-full z-50
           flex items-center justify-between
           px-4 py-3
           bg-tertiary border-b border-primary/10
           shadow-[0_2px_12px_theme(colors.primary/6%)]"
        >
            <!-- Mini avatar + name -->
            <div class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-full border-2 border-primary overflow-hidden flex-shrink-0
               flex items-center justify-center bg-primary/5"
                >
                    <img v-if="photo" :src="photo" :alt="name" class="w-full h-full object-cover" />
                    <span v-else class="font-display font-black text-xs text-primary">{{ initials }}</span>
                </div>

                <span class="font-display font-black text-base text-primary tracking-tight">
        {{ firstName }}<span class="text-primary/40">.</span>
      </span>
            </div>

            <!-- Hamburger -->
            <button
                class="relative flex flex-col justify-center items-center gap-[5px]
             w-9 h-9 rounded-lg flex-shrink-0
             hover:bg-primary/5 transition-colors duration-200"
                :aria-expanded="drawerOpen"
                aria-controls="mobile-drawer"
                aria-label="Toggle navigation"
                @click="drawerOpen = !drawerOpen"
            >
      <span
          :class="[
          'block w-[18px] h-0.5 rounded-full bg-primary transition-all duration-300 origin-center',
          drawerOpen ? 'translate-y-[7px] rotate-45' : ''
        ]"
      />
                <span
                    :class="[
          'block w-[14px] h-0.5 rounded-full bg-primary transition-all duration-300',
          drawerOpen ? 'opacity-0 scale-x-0' : ''
        ]"
                />
                <span
                    :class="[
          'block w-[18px] h-0.5 rounded-full bg-primary transition-all duration-300 origin-center',
          drawerOpen ? '-translate-y-[7px] -rotate-45' : ''
        ]"
                />
                ≡
            </button>
        </header>
        <!-- Backdrop -->
        <Transition
            enter-active-class="transition-opacity duration-250 ease-out"
            enter-from-class="opacity-0"
            leave-active-class="transition-opacity duration-200 ease-in"
            leave-to-class="opacity-0"
        >
            <div
                v-if="drawerOpen"
                class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm"
                aria-hidden="true"
                @click="drawerOpen = false"
            />
        </Transition>

        <!-- Slide-in drawer panel -->
        <Transition
            enter-active-class="transition-transform duration-300 ease-out"
            enter-from-class="-translate-x-full"
            leave-active-class="transition-transform duration-250 ease-in"
            leave-to-class="-translate-x-full"
        >
            <div
                v-if="drawerOpen"
                id="mobile-drawer"
                class="fixed inset-y-0 left-0 z-50 w-[78%] max-w-[300px]
                bg-tertiary text-primary border-r border-primary/10 flex flex-col
               shadow-[8px_0_40px_theme(colors.primary/12%)] overflow-y-auto scrollbar-hide"
                role="dialog"
                aria-modal="true"
                aria-label="Navigation menu"
            >
                <!-- Close button -->
                <button
                    class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center
                 rounded-md bg-primary/5 text-primary/60 hover:bg-primary/10
                 hover:text-primary transition-colors duration-200"
                    aria-label="Close menu"
                    @click="drawerOpen = false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <SidebarInner
                    :photo="photo"
                    :name="name"
                    :description="description"
                    :links="links"
                    :active-id="activeSection"
                    @navigate="onMobileNavigate"
                />
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import SidebarPhoto   from './SidebarPhoto.vue'
import SidebarProfile from './SidebarProfile.vue'
import SidebarNav from './SidebarNav.vue'

// ── Re-usable inner layout used in both desktop aside + mobile drawer ──────
// Defined as an inline component so we don't need an extra file
import { defineComponent, h } from 'vue'
const SidebarInner = defineComponent({
    name: 'SidebarInner',
    components: { SidebarPhoto, SidebarProfile, SidebarNav },
    props: ['photo', 'name', 'description', 'links', 'activeId'],
    emits: ['navigate'],
    setup(props, { emit }) {
        const year = new Date().getFullYear()
        return () => h('div', {
            class: 'flex flex-col h-full py-5 px-2'
        }, [
            // Top accent bar
            h('div', { class: 'h-0.5 mx-3 mb-4 bg-primary rounded-full animate-expand-x origin-left' }),

            h(SidebarPhoto, { photo: props.photo, name: props.name }),

            h('div', { class: 'my-3 mx-3 h-px bg-gradient-to-r from-transparent via-primary/15 to-transparent' }),

            h(SidebarProfile, { name: props.name, description: props.description }),

            h('div', { class: 'my-3 mx-3 h-px bg-gradient-to-r from-transparent via-primary/15 to-transparent' }),

            h(SidebarNav, {
                links: props.links,
                activeId: props.activeId,
                onNavigate: (id) => emit('navigate', id),
            }),

            // Footer
            h('div', {
                class: 'mt-auto pt-4 px-3 text-[0.6rem] font-mono tracking-wider text-primary/25'
            }, `© ${year} ${props.name}`),
        ])
    },
})

// ── Props ──────────────────────────────────────────────────────────────────
const props = defineProps({
    photo: { type: String, default: null },
    name:  { type: String, default: 'Atuo Israel' },
    description: {
        type: String,
        default: 'Crafting elegant web experiences — pixel-perfect UIs, scalable APIs, and everything in between.',
    },
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
    activeSection: { type: String, default: 'home' },
})

const emit = defineEmits(['navigate'])

// ── State ──────────────────────────────────────────────────────────────────
const drawerOpen = ref(false)

// ── Computed ───────────────────────────────────────────────────────────────
const initials = computed(() =>
    props.name.split(' ').map((w) => w[0].toUpperCase()).slice(0, 2).join('')
)

const firstName = computed(() => props.name.split(' ')[0])

// ── Methods ────────────────────────────────────────────────────────────────
function onMobileNavigate(id) {
    drawerOpen.value = false
    setTimeout(() => emit('navigate', id), 160)
}

// Close drawer on Escape
function onKeydown(e) {
    if (e.key === 'Escape' && drawerOpen.value) drawerOpen.value = false
}

onMounted(() => window.addEventListener('keydown', onKeydown))
onBeforeUnmount(() => window.removeEventListener('keydown', onKeydown))
</script>

<style scoped>
@keyframes expand-x {
    from { transform: scaleX(0); opacity: 0; }
    to   { transform: scaleX(1); opacity: 1; }
}
.animate-expand-x { animation: expand-x 0.6s ease 0.1s both; }

/* Hide scrollbars but keep scroll */
.scrollbar-hide { scrollbar-width: none; }
.scrollbar-hide::-webkit-scrollbar { display: none; }
</style>

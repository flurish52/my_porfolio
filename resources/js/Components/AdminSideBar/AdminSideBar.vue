<template>
    <!-- DESKTOP -->
    <aside
        class="hidden md:flex flex-col fixed inset-y-0 left-0
           w-1/5 min-w-[210px] max-w-[270px]
           bg-surface border-r border-primary/10
           shadow-[4px_0_30px_theme(colors.primary/4%)]
           z-50 overflow-y-auto scrollbar-hide"
        aria-label="Portfolio sidebar"
    >
        <AdminNavTopBar :user="user" />
        <SidebarNav
            :links="links"
            :active-id="activeSection"
            @navigate="emit('navigate', $event)"
        />
    </aside>
    <!-- MOBILE -->
    <div class="md:hidden">
        <!-- Sticky top bar -->
        <header
            class="fixed top-0 left-0 right-0 w-full z-50
           flex items-center justify-between
           px-4 py-3
           bg-tertiary border-b border-primary/10
           shadow-[0_2px_12px_theme(colors.primary/6%)]"
        >
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
             w-12 h-12 rounded-lg flex-shrink-0
             hover:bg-primary/5 transition-colors duration-200"
                :aria-expanded="drawerOpen"
                aria-controls="mobile-drawer"
                aria-label="Toggle navigation"
                @click="drawerOpen = !drawerOpen"
            >
                <span :class="['block w-[18px] h-0.5 rounded-full bg-primary transition-all duration-300 origin-center', drawerOpen ? 'translate-y-[7px] rotate-45' : '']" />
                <span :class="['block w-[14px] h-0.5 rounded-full bg-primary transition-all duration-300', drawerOpen ? 'opacity-0 scale-x-0' : '']" />
                <span :class="['block w-[18px] h-0.5 rounded-full bg-primary transition-all duration-300 origin-center', drawerOpen ? '-translate-y-[7px] -rotate-45' : '']" />
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

        <!-- Slide-in drawer -->
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

                <AdminNavTopBar :user="user" class="drawer-item" />
                <SidebarNav
                    :links="links"
                    :active-id="activeSection"
                    @navigate="onMobileNavigate"
                    class="drawer-nav"
                />
            </div>
        </Transition>
    </div>
</template>

<script setup>
import {ref, computed, onMounted, onBeforeUnmount, watch} from 'vue'
import SidebarNav from '../SideBar/SidebarNav.vue'
import { defineComponent } from 'vue'
import AdminNavTopBar from "@/Components/AdminSideBar/AdminNavTopBar.vue";

const SidebarInner = defineComponent({
    name: 'SidebarInner',
    props: ['photo', 'name', 'description', 'links', 'activeId'],
    emits: ['navigate'],
})

const props = defineProps({
    name:  { type: String, default: 'Atuo Israel' },
    photo: { type: String, default: null },
    links: { type: Array },
    activeSection: { type: String, default: 'home' },
})

const user = ref({
    name: props.name,
    avatar: props.photo || '/profile.png',
})

watch(
    () => [props.name, props.photo],
    ([newName, newPhoto]) => {
        user.value = {
            name: newName,
            avatar: newPhoto || '/profile.png'
        }
    },
    { immediate: true }
)

const emit = defineEmits(['navigate'])
const drawerOpen = ref(false)

const initials = computed(() =>
    props.name.split(' ').map((w) => w[0].toUpperCase()).slice(0, 2).join('')
)
const firstName = computed(() => props.name.split(' ')[0])

function onMobileNavigate(id) {
    drawerOpen.value = false
    setTimeout(() => emit('navigate', id), 160)
}

function onKeydown(e) {
    if (e.key === 'Escape' && drawerOpen.value) drawerOpen.value = false
}

onMounted(() => window.addEventListener('keydown', onKeydown))
onBeforeUnmount(() => window.removeEventListener('keydown', onKeydown))
</script>

<style scoped>
/* ── Scrollbar ── */
.scrollbar-hide { scrollbar-width: none; }
.scrollbar-hide::-webkit-scrollbar { display: none; }

/* ── Desktop sidebar: nav links stagger in on load ── */
aside :deep(a),
aside :deep(button) {
    animation: slideInLeft 0.3s ease both;
}
aside :deep(a:nth-child(1)), aside :deep(button:nth-child(1)) { animation-delay: 40ms; }
aside :deep(a:nth-child(2)), aside :deep(button:nth-child(2)) { animation-delay: 90ms; }
aside :deep(a:nth-child(3)), aside :deep(button:nth-child(3)) { animation-delay: 140ms; }
aside :deep(a:nth-child(4)), aside :deep(button:nth-child(4)) { animation-delay: 190ms; }
aside :deep(a:nth-child(5)), aside :deep(button:nth-child(5)) { animation-delay: 240ms; }

/* ── Mobile drawer: contents fold in after drawer slides open ── */
.drawer-item {
    animation: foldDown 0.3s ease 0.2s both;
}
.drawer-nav {
    animation: foldDown 0.35s ease 0.27s both;
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-8px); }
    to   { opacity: 1; transform: translateX(0); }
}

@keyframes foldDown {
    from { opacity: 0; transform: translateY(-10px) scaleY(0.95); transform-origin: top; }
    to   { opacity: 1; transform: translateY(0)     scaleY(1); }
}
</style>

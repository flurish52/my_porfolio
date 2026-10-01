<template>
    <section id="home" class="border-b border-line bg-surface">
        <div
            class="mx-auto grid max-w-6xl items-center gap-12 px-5 py-14 md:px-8 md:py-24 lg:grid-cols-5 lg:gap-16"
        >
            <!-- Copy -->
            <div class="hero-in lg:col-span-3">
                <p
                    v-if="profileProp?.availability"
                    class="mb-6 inline-flex items-center gap-2 rounded-full bg-primary-soft px-3.5 py-1.5 text-sm font-medium text-primary-dark"
                >
                    <span class="h-2 w-2 rounded-full bg-primary" aria-hidden="true"></span>
                    {{ profileProp.availability }}
                </p>

                <h1
                    class="max-w-2xl text-4xl font-extrabold leading-[1.1] tracking-tight text-secondary md:text-5xl lg:text-6xl"
                >
                    {{ headline }}
                </h1>

                <p class="mt-6 max-w-xl text-lg leading-relaxed text-secondary-muted">
                    {{ subheadline }}
                </p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <button
                        type="button"
                        class="rounded-lg bg-primary px-7 py-3.5 text-center text-sm font-semibold text-surface transition-colors duration-200 hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                        @click="go('projects')"
                    >
                        See my work
                    </button>
                    <button
                        type="button"
                        class="rounded-lg border border-line bg-surface px-7 py-3.5 text-center text-sm font-semibold text-secondary transition-colors duration-200 hover:border-primary hover:text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                        @click="go('contact')"
                    >
                        Start a conversation
                    </button>
                </div>

                <p v-if="skillNames" class="mt-10 max-w-xl text-sm text-secondary-muted">
                    Built with {{ skillNames }}.
                </p>
            </div>

            <!-- Photo -->
            <div class="hero-in mx-auto w-full max-w-sm lg:col-span-2 lg:max-w-none" style="animation-delay: 120ms">
                <div class="relative">
                    <div class="absolute -bottom-4 -right-4 h-full w-full rounded-2xl bg-primary-soft" aria-hidden="true"></div>
                    <img
                        v-if="profileProp?.picture"
                        :src="`/storage/${profileProp.picture}`"
                        :alt="profileProp.username"
                        class="relative aspect-[4/5] w-full rounded-2xl border border-line bg-canvas object-cover shadow-card"
                    />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    profileProp: { type: Object, default: () => ({}) },
    skillsProp: { type: Array, default: () => [] },
})

// Copy lives in the DB later; these are the fallbacks until then.
const headline = computed(
    () => props.profileProp?.headline || 'I build websites and web apps you can rely on.'
)
const subheadline = computed(
    () =>
        props.profileProp?.home_description ||
        'Full-stack developer helping businesses launch clean, fast, dependable software, from the first conversation to launch day and after.'
)

// A short, plain sentence instead of a wall of chips
const skillNames = computed(() => {
    const names = (props.skillsProp || []).slice(0, 5).map((s) => s.name)
    if (names.length < 2) return names[0] || ''
    return `${names.slice(0, -1).join(', ')} and ${names[names.length - 1]}`
})

const NAV_OFFSET = 72
function go(id) {
    const el = document.getElementById(id)
    if (!el) return
    window.scrollTo({
        top: el.getBoundingClientRect().top + window.scrollY - NAV_OFFSET,
        behavior: 'smooth',
    })
}
</script>

<style scoped>
/* One orchestrated moment: the hero settles in on load. */
@media (prefers-reduced-motion: no-preference) {
    .hero-in {
        animation: hero-in 0.7s ease-out both;
    }
}
@keyframes hero-in {
    from {
        opacity: 0;
        transform: translateY(14px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<template>
    <section id="about" class="bg-secondary py-20 text-surface md:py-28">
        <div class="mx-auto max-w-6xl px-5 md:px-8">
            <h2 class="flex items-center gap-3 text-sm font-semibold text-surface/60">
                <span class="h-px w-8 bg-primary-soft/50" aria-hidden="true"></span>
                About me
            </h2>

            <!-- Lead: big, with the key phrases highlighted like a marker pen -->
            <p
                class="mt-8 max-w-4xl text-xl font-extrabold leading-[1.2] tracking-tight md:text-3xl md:leading-[1.2]"
            >
                <template v-for="(part, i) in leadParts" :key="i">
                    <mark
                        v-if="part.mark"
                        class="box-decoration-clone rounded-md bg-primary px-2 py-0.5 text-surface"
                    >{{ part.text }}</mark>
                    <template v-else>{{ part.text }}</template>
                </template>
            </p>

            <div
                v-if="restParts.length"
                class="mt-10 grid max-w-4xl gap-x-12 gap-y-5 text-lg leading-relaxed text-surface/70 md:grid-cols-2"
            >
                <p v-for="(parts, i) in restParts" :key="i">
                    <template v-for="(part, j) in parts" :key="j">
                        <strong v-if="part.mark" class="font-semibold text-surface">{{ part.text }}</strong>
                        <template v-else>{{ part.text }}</template>
                    </template>
                </p>
            </div>

            <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                <button
                    type="button"
                    class="rounded-lg bg-surface px-7 py-3.5 text-sm font-semibold text-secondary transition-colors duration-200 hover:bg-primary-soft focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface"
                    @click="go('contact')"
                >
                    Work with me
                </button>
                <button
                    type="button"
                    class="rounded-lg border border-surface/25 px-7 py-3.5 text-sm font-semibold text-surface transition-colors duration-200 hover:bg-surface/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface"
                    @click="go('projects')"
                >
                    See my work
                </button>
            </div>

            <!-- Stats: big figures separated by thin vertical rules -->
            <dl
                v-if="stats.length"
                class="mt-16 grid grid-cols-2 gap-x-6 gap-y-8 border-t border-surface/15 pt-10 sm:grid-cols-3 sm:gap-x-0"
            >
                <div
                    v-for="stat in stats"
                    :key="stat.id || stat.label"
                    class="flex flex-col-reverse gap-1 border-surface/15 sm:border-l sm:pl-8 sm:first:border-l-0 sm:first:pl-0"
                >
                    <dt class="text-sm font-medium text-surface/60">{{ stat.label }}</dt>
                    <dd class="text-5xl font-extrabold tracking-tight md:text-6xl">
                        {{ stat.value }}<span class="text-primary-soft/60">{{ stat.suffix }}</span>
                    </dd>
                </div>
            </dl>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    profileProp: { type: Object, default: () => ({}) },
    // No invented defaults: a made-up number would undo the trust this section builds.
    statsProp: { type: [Array, Object], default: () => [] },
})

// Copy lives in the DB later. Wrap a phrase in **double asterisks** to highlight it.
const fallbackAbout =
    'I build **software businesses can rely on**, from the first conversation to launch day and after.\nI work as a full-stack developer, and I care about **clean code**, **clear communication** and products that keep working long after they go live.'

// Turns "plain **marked** plain" into [{ text, mark }] so no v-html is needed.
function toParts(text) {
    return text
        .split(/\*\*(.+?)\*\*/g)
        .map((t, i) => ({ text: t, mark: i % 2 === 1 }))
        .filter((p) => p.text)
}

const paragraphs = computed(() =>
    (props.profileProp?.about || fallbackAbout)
        .replace(/<[^>]+>/g, '')
        .split(/\n+/)
        .map((p) => p.trim())
        .filter(Boolean)
)

const leadParts = computed(() => toParts(paragraphs.value[0] || ''))
const restParts = computed(() => paragraphs.value.slice(1).map(toParts))

// Only real figures show: a value must start with a digit and have a label.
const stats = computed(() =>
    Object.values(props.statsProp || {})
        .filter((s) => /^\d/.test(String(s.value ?? '').trim()) && s.label)
        .slice(0, 3)
)

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

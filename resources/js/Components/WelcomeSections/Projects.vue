<template>
    <section
        id="projects"
        ref="sectionRef"
        class="min-h-screen px-8 md:px-16 py-20 border-b border-primary/6 bg-primary/[0.015]"
    >
        <!-- Label -->
        <p
            class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-2 label-item"
            :class="{ 'is-visible': visible }"
        >
            // my work
        </p>

        <!-- Heading chars drop in -->
        <h2
            class="font-display font-black tracking-tight text-primary mb-2"
            style="font-size: clamp(1.9rem, 4vw, 2.8rem)"
        >
            <span
                v-for="(char, i) in 'Projects.'"
                :key="i"
                class="heading-char"
                :class="{ 'is-visible': visible }"
                :style="{ '--delay': `${60 + i * 40}ms` }"
            >{{ char }}</span>
        </h2>

        <!-- Subtitle -->
        <p
            class="text-sm leading-relaxed text-primary/50 max-w-md mb-10 subtitle-item"
            :class="{ 'is-visible': visible }"
        >
            A curated selection of things I've built — developer tools, SaaS platforms,
            and full-featured web applications.
        </p>

        <!-- Project cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 max-w-3xl">

        <a    v-for="(project, index) in projectsProp"
            :key="project.id"
            :href="project?.link"
            target="_blank"
            class="project-card flex flex-col gap-4 p-6 rounded-xl bg-tertiary
            border border-primary/8 border-t-2 border-t-primary
            transition-all duration-300 group relative overflow-hidden"
            :class="{ 'is-visible': visible }"
            :style="{ '--delay': `${200 + index * 110}ms` }"
            >
            <!-- Shimmer sweep on hover -->
            <span class="card-shimmer absolute inset-0 pointer-events-none" aria-hidden="true" />

            <div class="flex-1 relative z-10">
                    <span class="font-mono text-[0.6rem] tracking-wider text-primary/30 mb-2 block index-num"
                          :class="{ 'is-visible': visible }"
                          :style="{ '--delay': `${300 + index * 110}ms` }">
                        {{ String(index + 1).padStart(2, '0') }}
                    </span>

                <h3 class="font-display font-bold text-base text-primary mb-2 leading-snug
                               group-hover:translate-x-0.5 transition-transform duration-200">
                    {{ project?.title }}
                </h3>
                <p class="text-sm leading-relaxed text-primary/50">{{ project?.description }}</p>
            </div>

            <div class="flex flex-wrap gap-1.5 relative z-10">
                    <span
                        v-for="(s, si) in project.skills"
                        :key="si"
                        class="skill-chip font-mono text-[0.58rem] tracking-wide px-2 py-0.5 rounded
                               bg-primary/6 text-primary/55"
                        :class="{ 'is-visible': visible }"
                        :style="{ '--delay': `${400 + index * 110 + si * 40}ms` }"
                    >{{ s.name }}</span>
            </div>
            </a>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

defineProps({ projectsProp: Array })

const sectionRef = ref(null)
const visible    = ref(false)
let observer     = null

onMounted(() => {
    observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting && !visible.value) {
                visible.value = true
                observer.disconnect()
            }
        },
        { threshold: 0.12 }
    )
    if (sectionRef.value) observer.observe(sectionRef.value)
})

onBeforeUnmount(() => observer?.disconnect())
</script>

<style scoped>
/* ── Label slides in from left ── */
.label-item {
    opacity: 0;
    transform: translateX(-16px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}
.label-item.is-visible { opacity: 1; transform: translateX(0); }

/* ── Heading chars drop from above ── */
.heading-char {
    display: inline-block;
    opacity: 0;
    transform: translateY(-18px) rotate(-4deg);
    transition: opacity 0.38s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    transform 0.38s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms);
}
.heading-char.is-visible { opacity: 1; transform: translateY(0) rotate(0deg); }

/* ── Subtitle fades up ── */
.subtitle-item {
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.4s ease 350ms, transform 0.4s ease 350ms;
}
.subtitle-item.is-visible { opacity: 1; transform: translateY(0); }

/* ── Project card flies up with spring ── */
.project-card {
    opacity: 0;
    transform: translateY(28px) scale(0.97);
    transition: opacity 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    box-shadow 0.3s ease,
    translate 0.25s ease;
}
.project-card.is-visible { opacity: 1; transform: translateY(0) scale(1); }

/* Hover lift — separate from entry transition */
.project-card.is-visible:hover {
    transform: translateY(-4px) scale(1.005);
    box-shadow: 0 14px 36px -4px color-mix(in srgb, currentColor 9%, transparent);
}

/* ── Shimmer sweep on hover ── */
.card-shimmer {
    background: linear-gradient(
        105deg,
        transparent 35%,
        color-mix(in srgb, white 8%, transparent) 50%,
        transparent 65%
    );
    transform: translateX(-100%) skewX(-12deg);
    transition: transform 0s;
}
.project-card:hover .card-shimmer {
    transform: translateX(200%) skewX(-12deg);
    transition: transform 0.6s ease;
}

/* ── Index number ticks in ── */
.index-num {
    opacity: 0;
    transform: translateX(-8px);
    transition: opacity 0.3s ease var(--delay, 0ms),
    transform 0.3s ease var(--delay, 0ms);
}
.index-num.is-visible { opacity: 1; transform: translateX(0); }

/* ── Skill chips pop in ── */
.skill-chip {
    opacity: 0;
    transform: scale(0.8);
    transition: opacity 0.25s ease var(--delay, 0ms),
    transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms);
}
.skill-chip.is-visible { opacity: 1; transform: scale(1); }
</style>

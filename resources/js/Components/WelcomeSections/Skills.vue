<template>
    <section
        id="skills"
        ref="sectionRef"
        class="min-h-ft px-8 md:px-16 py-20 border-b border-primary/6"
    >
        <!-- Label -->
        <p
            class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-2 label-item"
            :class="{ 'is-visible': visible }"
        >
            // what I know
        </p>

        <!-- Heading -->
        <h2
            class="font-display font-black tracking-tight text-primary mb-10 heading-item"
            :class="{ 'is-visible': visible }"
            style="font-size: clamp(1.9rem, 4vw, 2.8rem)"
        >
            Skills.
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-3xl">
            <div
                v-for="(category, catIndex) in categories"
                :key="category.id"
                class="category-block"
                :class="{ 'is-visible': visible }"
                :style="{ '--cat-delay': `${catIndex * 120}ms` }"
            >
                <!-- Typewriter heading — chars reveal on visible -->
                <h3 class="font-mono text-[0.6rem] tracking-[0.18em] uppercase text-primary/35 font-bold mb-3">
                    <span
                        v-for="(char, i) in category.name"
                        :key="i"
                        class="typewriter-char"
                        :class="{ 'is-visible': visible }"
                        :style="{ '--delay': `${catIndex * 120 + i * 50}ms` }"
                    >{{ char === ' ' ? '\u00A0' : char }}</span>
                    <span
                        class="typewriter-cursor"
                        :class="{ 'is-visible': visible }"
                        :style="{ '--delay': `${catIndex * 120 + category.name.length * 50}ms` }"
                    >|</span>
                </h3>

                <!-- Flying skill tags -->
                <div class="flex flex-wrap gap-1.5">
                    <span
                        v-for="(skill, skillIndex) in category.skills"
                        :key="skill.id"
                        class="skill-tag text-[0.75rem] px-2.5 py-1 rounded-md
                               border border-primary/14 text-primary/60
                               hover:bg-primary hover:text-surface hover:border-primary
                               cursor-default"
                        :class="{ 'is-visible': visible }"
                        :style="getTagStyle(catIndex, skillIndex)"
                    >
                        {{ skill.name }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

defineProps({ categories: Array })

const sectionRef = ref(null)
const visible    = ref(false)
let observer     = null

function getTagStyle(catIndex, skillIndex) {
    const seed     = catIndex * 13 + skillIndex * 7
    const angle    = (seed * 137.5) % 360
    const distance = 55 + (seed % 35)
    const rad      = (angle * Math.PI) / 180
    const tx       = Math.cos(rad) * distance
    const ty       = Math.sin(rad) * distance
    const flyDelay = catIndex * 120 + skillIndex * 55 + 300

    return {
        '--fly-x':       `${tx}px`,
        '--fly-y':       `${ty}px`,
        '--float-delay': `${(seed % 6) * 0.4}s`,
        '--delay':       `${flyDelay}ms`,
    }
}

onMounted(() => {
    observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting && !visible.value) {
                visible.value = true
                observer.disconnect()
            }
        },
        { threshold: 0.15 }
    )
    if (sectionRef.value) observer.observe(sectionRef.value)
})

onBeforeUnmount(() => observer?.disconnect())
</script>

<style scoped>
/* ══ Label ══ */
.label-item {
    opacity: 0;
    transform: translateX(-16px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}
.label-item.is-visible {
    opacity: 1;
    transform: translateX(0);
}

/* ══ Heading ══ */
.heading-item {
    opacity: 0;
    transform: translateY(12px);
    transition: opacity 0.45s ease 80ms, transform 0.45s ease 80ms;
}
.heading-item.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* ══ Category block fades in ══ */
.category-block {
    opacity: 0;
    transition: opacity 0.35s ease var(--cat-delay, 0ms);
}
.category-block.is-visible {
    opacity: 1;
}

/* ══ Typewriter chars ══ */
.typewriter-char {
    display: inline-block;
    opacity: 0;
    transition: opacity 0.01s steps(1) var(--delay, 0ms);
}
.typewriter-char.is-visible {
    opacity: 1;
}

/* ══ Blinking cursor — blinks then fades ══ */
.typewriter-cursor {
    display: inline-block;
    opacity: 0;
}
.typewriter-cursor.is-visible {
    animation: cursorBlink 0.55s steps(1) var(--delay, 0ms) 4 forwards;
}

@keyframes cursorBlink {
    0%, 49% { opacity: 1; }
    50%, 100% { opacity: 0; }
}

/* ══ Skill tags: fly in from random direction, then float ══ */
.skill-tag {
    opacity: 0;
    transform: translate(var(--fly-x), var(--fly-y)) scale(0.65) rotate(8deg);
    transition:
        background  0.2s ease,
        color       0.2s ease,
        border-color 0.2s ease,
        box-shadow  0.2s ease;
}
.skill-tag.is-visible {
    animation:
        flyIn  0.5s cubic-bezier(0.22, 1, 0.36, 1) var(--delay, 0ms) forwards,
        float  3.5s ease-in-out calc(var(--delay, 0ms) + 0.5s) infinite;
}

.skill-tag:hover {
    animation: tagBounce 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both !important;
    box-shadow: 0 4px 14px -2px color-mix(in srgb, currentColor 25%, transparent);
}

/* ══ Keyframes ══ */
@keyframes flyIn {
    0% {
        opacity: 0;
        transform: translate(var(--fly-x), var(--fly-y)) scale(0.6) rotate(8deg);
    }
    70% {
        opacity: 1;
        transform: translate(-2px, -2px) scale(1.07) rotate(-1deg);
    }
    100% {
        opacity: 1;
        transform: translate(0, 0) scale(1) rotate(0deg);
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-3px); }
}

@keyframes tagBounce {
    0%   { transform: scale(1); }
    30%  { transform: scale(1.17) translateY(-4px); }
    60%  { transform: scale(0.95) translateY(1px); }
    80%  { transform: scale(1.05) translateY(-1px); }
    100% { transform: scale(1) translateY(0); }
}
</style>

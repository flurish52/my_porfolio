<template>
    <section
        id="about"
        ref="sectionRef"
        class="min-h-screen px-8 md:px-16 py-20 border-b border-primary/6"
    >
        <!-- Label -->
        <p
            class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-2 anim-item"
            :class="{ 'anim-visible': visible }"
            style="--delay: 0ms"
        >
            // my story
        </p>

        <!-- Heading with letter-by-letter drop -->
        <h2
            class="font-display font-black tracking-tight text-primary mb-8 heading-wrap"
            style="font-size: clamp(1.9rem, 4vw, 2.8rem)"
        >
            <span
                v-for="(char, i) in 'About Me.'"
                :key="i"
                class="heading-char"
                :class="{ 'heading-char--visible': visible }"
                :style="{ '--delay': `${80 + i * 45}ms` }"
            >{{ char === ' ' ? '\u00A0' : char }}</span>
        </h2>

        <!-- Body text — words wave in -->
        <div class="max-w-2xl space-y-4 mb-12">
            <p class="text-[0.95rem] leading-[1.85] text-primary/60">
                <span
                    v-for="(word, i) in words"
                    :key="i"
                    class="word-span"
                    :class="{ 'word-span--visible': visible }"
                    :style="{ '--delay': `${400 + i * 22}ms` }"
                    v-html="word + '&nbsp;'"
                />
            </p>
        </div>

        <!-- Stats -->
        <div class="flex flex-wrap gap-8 md:gap-14">
            <div
                v-for="(stat, i) in statsProp"
                :key="stat.id"
                class="flex flex-col gap-1 stat-block"
                :class="{ 'stat-block--visible': visible }"
                :style="{ '--delay': `${250 + i * 130}ms` }"
            >
                <span class="font-display font-black text-[2.2rem] leading-none tracking-tight text-primary stat-number">
                    {{ displayValues[i] }}{{ stat.suffix }}
                    <span
                        class="stat-underline"
                        :class="{ 'stat-underline--visible': visible }"
                        :style="{ '--delay': `${550 + i * 130}ms` }"
                    />
                </span>
                <span
                    class="font-mono text-[0.58rem] tracking-[0.14em] uppercase text-primary/50 stat-label"
                    :class="{ 'stat-label--visible': visible }"
                    :style="{ '--delay': `${650 + i * 130}ms` }"
                >
                    {{ stat.label }}
                </span>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
    profileProp: {
        type: Object,
        default: () => ({ about: 'Passionate developer crafting elegant web experiences.' }),
    },
    statsProp: {
        type: Array,
        default: () => [
            { id: 1, value: '3',   suffix: '+', label: 'Years Experience' },
            { id: 2, value: '20',  suffix: '+', label: 'Projects Shipped' },
            { id: 3, value: '100', suffix: '%', label: 'Commitment' },
        ],
    },
})

const sectionRef = ref(null)
const visible    = ref(false)

// Plain words for word-by-word animation
const words = computed(() =>
    (props.profileProp?.about || '').replace(/<[^>]+>/g, '').split(' ').filter(Boolean)
)

// Display values — start as the raw value, will be animated if numeric
const displayValues = ref(props.statsProp.map(s => {
    const n = Number(s.value)
    return isNaN(n) ? s.value : 0
}))

// Count-up only for numeric stats
function countUp(index, target, delay) {
    setTimeout(() => {
        const duration = 1400
        const steps    = 45
        let step = 0
        const timer = setInterval(() => {
            step++
            displayValues.value[index] = Math.min(Math.round((target / steps) * step), target)
            if (displayValues.value[index] >= target) clearInterval(timer)
        }, duration / steps)
    }, delay)
}

let observer = null

onMounted(() => {
    observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting && !visible.value) {
                visible.value = true

                // Trigger count-up only for numeric values
                props.statsProp.forEach((stat, i) => {
                    const n = Number(stat.value)
                    if (!isNaN(n)) {
                        countUp(i, n, 250 + i * 130)
                    }
                })

                observer.disconnect()
            }
        },
        { threshold: 0.2 }
    )
    if (sectionRef.value) observer.observe(sectionRef.value)
})

onBeforeUnmount(() => observer?.disconnect())
</script>

<style scoped>
/* ── Shared: elements start hidden, transition in when .anim-visible added ── */

/* Label */
.anim-item {
    opacity: 0;
    transform: translateX(-18px);
    transition: opacity 0.4s ease var(--delay, 0ms), transform 0.4s ease var(--delay, 0ms);
}
.anim-item.anim-visible {
    opacity: 1;
    transform: translateX(0);
}

/* ── Heading chars drop from above ── */
.heading-char {
    display: inline-block;
    opacity: 0;
    transform: translateY(-20px) rotate(-5deg);
    transition: opacity 0.38s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    transform 0.38s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms);
}
.heading-char--visible {
    opacity: 1;
    transform: translateY(0) rotate(0deg);
}

/* ── Words wave up ── */
.word-span {
    display: inline-block;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease var(--delay, 0ms),
    transform 0.3s ease var(--delay, 0ms);
}
.word-span--visible {
    opacity: 1;
    transform: translateY(0);
}

/* ── Stat block pops up ── */
.stat-block {
    opacity: 0;
    transform: translateY(22px) scale(0.9);
    transition: opacity 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms);
    position: relative;
}
.stat-block--visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* ── Stat number ── */
.stat-number {
    position: relative;
    display: inline-flex;
    flex-direction: column;
}

/* ── Underline grows in ── */
.stat-underline {
    display: block;
    height: 2px;
    width: 0;
    background: currentColor;
    opacity: 0.22;
    border-radius: 999px;
    margin-top: 3px;
    transition: width 0.5s ease var(--delay, 0ms);
}
.stat-underline--visible { width: 100%; }

/* ── Stat label slides up ── */
.stat-label {
    opacity: 0;
    transform: translateY(5px);
    transition: opacity 0.3s ease var(--delay, 0ms),
    transform 0.3s ease var(--delay, 0ms);
}
.stat-label--visible {
    opacity: 1;
    transform: translateY(0);
}

/* ── Hover lift on stat block ── */
.stat-block:hover .stat-number {
    transform: translateY(-3px);
    transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.stat-block:hover .stat-underline {
    opacity: 0.5;
    transition: opacity 0.2s ease;
}
</style>

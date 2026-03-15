<template>
    <section
        id="home"
        ref="sectionRef"
        class="relative min-h-fit flex flex-col md:flex-row items-center px-8 md:px-16 py-20
               border-b border-primary/6 overflow-hidden"
    >
        <SidebarPhoto
            class="md:hidden"
            :photo="`/storage/${profileProp.picture}`"
            :name="profileProp.username"
        />

        <!-- Decorative bg glyph -->
        <div
            class="hidden md:block absolute right-0 bottom-0 font-display font-black
                   text-[clamp(5rem,18vw,13rem)] leading-none tracking-[-4px]
                   text-primary select-none pointer-events-none glyph-item"
            :class="{ 'is-visible': visible }"
            aria-hidden="true"
        >{ }
        </div>

        <div class="relative z-10 max-w-2xl w-full">

            <!-- Label -->
            <p
                class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-3 label-item"
                :class="{ 'is-visible': visible }"
            >
                // hello world
            </p>

            <!-- Heading -->
            <h2
                class="font-display font-black leading-[1.05] tracking-tight mb-5"
                style="font-size: clamp(2.4rem, 6vw, 4rem)"
            >
                <span
                    class="block font-serif italic font-normal text-[0.45em] text-primary/45 mb-1 tracking-normal hi-item"
                    :class="{ 'is-visible': visible }"
                >Hi, I'm</span>

                <span class="relative inline-block text-primary">
                    <span
                        v-for="(char, i) in (profile.username || '')"
                        :key="i"
                        class="heading-char"
                        :class="{ 'is-visible': visible }"
                        :style="{ '--delay': `${180 + i * 50}ms` }"
                    >{{ char === ' ' ? '\u00A0' : char }}</span>
                </span>

            </h2>

            <!-- ═══════════════════════════════════════
                 ROTATING PHRASES BLOCK
            ════════════════════════════════════════ -->
            <div
                class="phrase-container mb-8 phrase-entrance"
                :class="{ 'is-visible': visible }"
            >
                <!-- Phase indicator dots -->
                <div class="flex gap-1.5 mb-3">
                    <button
                        v-for="(_, i) in phrases"
                        :key="i"
                        class="phase-dot"
                        :class="{ 'phase-dot--active': i === phraseIndex }"
                        :aria-label="`Phrase ${i + 1}`"
                        @click="jumpTo(i)"
                    />
                </div>

                <!-- Phrase display area — fixed height so layout doesn't jump -->
                <div class="phrase-stage" aria-live="polite">
                    <!-- Prefix tag -->
                    <span class="font-mono text-[0.6rem] tracking-[0.18em] uppercase text-primary/30 mb-1 block">
                        {{ phrases[phraseIndex]?.tag }}
                    </span>

                    <!-- Characters type in one by one -->
                    <p class="text-base leading-[1.8] text-primary/60 phrase-text">
                        <span
                            v-for="(char, ci) in displayedChars"
                            :key="`${phraseIndex}-${ci}`"
                            class="phrase-char"
                            :class="{
                                'phrase-char--erasing': isErasing,
                                'phrase-char--last': ci === displayedChars.length - 1 && !isErasing
                            }"
                        >{{ char }}</span>
                        <!-- Typing cursor -->
                        <span class="typing-cursor" :class="{ 'typing-cursor--pause': isPausing }">|</span>
                    </p>
                </div>
            </div>

            <!-- CTA buttons -->
            <div class="flex flex-wrap gap-3 mb-10">
                <button
                    class="cta-primary inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                           bg-primary text-tertiary text-sm font-semibold tracking-wide
                           hover:opacity-85 active:scale-95 transition-all duration-200 btn-item"
                    :class="{ 'is-visible': visible }"
                    style="--delay: 700ms"
                    @click="scrollToSection('projects')"
                >
                    View Projects
                    <svg class="w-4 h-4 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
                <button
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                           border border-primary/25 text-primary text-sm font-semibold tracking-wide
                           hover:border-primary/50 hover:bg-primary/5
                           active:scale-95 transition-all duration-200 btn-item"
                    :class="{ 'is-visible': visible }"
                    style="--delay: 820ms"
                    @click="scrollToSection('contact')"
                >
                    Get in Touch
                </button>
            </div>

            <!-- Tech chips -->
            <div class="flex flex-wrap gap-2">
                <span
                    v-for="(skill, i) in skillsProp"
                    :key="skill.id"
                    class="chip-item font-mono text-[0.65rem] tracking-wide px-2.5 py-1 rounded
                           border border-primary/15 text-primary/80
                           hover:border-primary/40 hover:text-primary/50
                           transition-colors duration-200 cursor-default"
                    :class="{ 'is-visible': visible }"
                    :style="{ '--delay': `${900 + i * 35}ms` }"
                >{{ skill.name }}</span>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import SidebarPhoto from "@/Components/SideBar/SidebarPhoto.vue"

const props = defineProps({
    profileProp: { type: Object, default: () => ({}) },
    skillsProp:  { type: Array,  default: () => [] },
})

const emit = defineEmits(['navigate'])

const sectionRef = ref(null)
const visible    = ref(false)

const profile = computed(() => props.profileProp || {})

// ── Rotating phrases — swap these out for real content ──────────────────
const phrases = computed(() => [
    {
        tag: '// what I do',
        text: props.profileProp?.home_description ||
            'I build pixel-perfect UIs and scalable APIs that people actually love using.',
    },
    {
        tag: '// my approach',
        text: 'Clean code, thoughtful architecture, and an obsession with the details that make products feel alive.',
    },
    {
        tag: '// currently into',
        text: 'Full-stack web apps, developer tooling, and making complex things feel surprisingly simple.',
    },
    {
        tag: '// fun fact',
        text: 'I believe the best interfaces are the ones you never have to think about — they just work.',
    },
])

// ── Typewriter state ────────────────────────────────────────────────────
const phraseIndex   = ref(0)
const displayedChars = ref([])
const isErasing     = ref(false)
const isPausing     = ref(false)

let typeTimer = null

const TYPING_SPEED  = 28   // ms per char
const ERASING_SPEED = 14   // ms per char (faster erase)
const HOLD_DURATION = 2800 // ms to hold full phrase
const START_DELAY   = 900  // ms before first phrase starts

function typeNextChar() {
    const full = phrases.value[phraseIndex.value].text
    if (displayedChars.value.length < full.length) {
        displayedChars.value.push(full[displayedChars.value.length])
        typeTimer = setTimeout(typeNextChar, TYPING_SPEED + Math.random() * 18)
    } else {
        // Finished typing — pause then erase
        isPausing.value = true
        typeTimer = setTimeout(() => {
            isPausing.value = false
            isErasing.value = true
            eraseNextChar()
        }, HOLD_DURATION)
    }
}

function eraseNextChar() {
    if (displayedChars.value.length > 0) {
        displayedChars.value.pop()
        typeTimer = setTimeout(eraseNextChar, ERASING_SPEED)
    } else {
        // Finished erasing — move to next phrase
        isErasing.value = false
        phraseIndex.value = (phraseIndex.value + 1) % phrases.value.length
        typeTimer = setTimeout(typeNextChar, 300)
    }
}

function jumpTo(i) {
    clearTimeout(typeTimer)
    isErasing.value  = false
    isPausing.value  = false
    displayedChars.value = []
    phraseIndex.value = i
    typeTimer = setTimeout(typeNextChar, 200)
}

function scrollToSection(id) {
    emit('navigate', id)
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })
}

onMounted(() => {
    setTimeout(() => {
        visible.value = true
        typeTimer = setTimeout(typeNextChar, START_DELAY)
    }, 80)
})

onBeforeUnmount(() => clearTimeout(typeTimer))
</script>

<style scoped>
/* ── Entrance animations ── */
.label-item {
    opacity: 0; transform: translateX(-18px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}
.label-item.is-visible { opacity: 1; transform: translateX(0); }

.hi-item {
    opacity: 0; transform: translateY(8px);
    transition: opacity 0.35s ease 100ms, transform 0.35s ease 100ms;
}
.hi-item.is-visible { opacity: 1; transform: translateY(0); }

.heading-char {
    display: inline-block; opacity: 0;
    transform: translateY(-20px) rotate(-5deg);
    transition: opacity 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms);
}
.heading-char.is-visible { opacity: 1; transform: translateY(0) rotate(0deg); }

.underline-item {
    transform: scaleX(0); transform-origin: left;
    transition: transform 0.5s ease var(--delay, 0ms);
}
.underline-item.is-visible {
    transform: scaleX(1);
    animation: underlinePulse 2.5s ease-in-out 1s infinite;
}

/* ── Phrase container ── */
.phrase-entrance {
    opacity: 0; transform: translateY(12px);
    transition: opacity 0.5s ease 600ms, transform 0.5s ease 600ms;
}
.phrase-entrance.is-visible { opacity: 1; transform: translateY(0); }

.phrase-stage {
    min-height: 5rem; /* prevents layout shift as text changes */
}

/* ── Phase dots ── */
.phase-dot {
    width: 20px; height: 3px; border-radius: 999px;
    background: color-mix(in srgb, currentColor 15%, transparent);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    cursor: pointer;
}
.phase-dot--active {
    width: 32px;
    background: color-mix(in srgb, currentColor 55%, transparent);
}
.phase-dot:hover:not(.phase-dot--active) {
    background: color-mix(in srgb, currentColor 28%, transparent);
}

/* ── Individual typed characters ── */
.phrase-char {
    display: inline;
    transition: opacity 0.08s ease;
}
.phrase-char--erasing { opacity: 0.4; }

/* Last char gets a subtle highlight while typing */
.phrase-char--last {
    opacity: 0.9;
}

/* ── Typing cursor blinks, pauses when holding ── */
.typing-cursor {
    display: inline-block;
    font-weight: 100;
    margin-left: 1px;
    opacity: 1;
    animation: cursorBlink 0.55s steps(1) infinite;
}
.typing-cursor--pause {
    animation: none;
    opacity: 1;
}

/* ── Buttons ── */
.btn-item {
    opacity: 0; transform: translateY(14px) scale(0.95);
    transition: opacity 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms);
}
.btn-item.is-visible { opacity: 1; transform: translateY(0) scale(1); }

.arrow-icon { transition: transform 0.2s ease; }
.cta-primary:hover .arrow-icon { transform: translateX(4px); }

/* ── Chips ── */
.chip-item {
    opacity: 0; transform: scale(0.82) translateY(6px);
    transition: opacity 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms),
    transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) var(--delay, 0ms);
}
.chip-item.is-visible { opacity: 1; transform: scale(1) translateY(0); }

/* ── Glyph ── */
.glyph-item {
    opacity: 0; transform: translateX(40px);
    transition: opacity 1.2s ease 400ms, transform 1.2s ease 400ms;
}
.glyph-item.is-visible { opacity: 0.045; transform: translateX(0); }

/* ── Keyframes ── */
@keyframes cursorBlink {
    0%, 49% { opacity: 1; }
    50%, 100% { opacity: 0; }
}
@keyframes underlinePulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.45; box-shadow: 0 0 8px 1px currentColor; }
}
</style>

<template>
    <div class="flex flex-col items-center pt-2 pb-1">
        <div
            class="photo-wrapper relative flex items-center justify-center"
            :class="{ 'is-ready': ready }"
        >
            <!-- Corner brackets (pure CSS) -->
            <span class="corner corner-tl" aria-hidden="true" />
            <span class="corner corner-tr" aria-hidden="true" />
            <span class="corner corner-bl" aria-hidden="true" />
            <span class="corner corner-br" aria-hidden="true" />

            <!-- Rotating arc ring -->
            <span class="ring ring-outer"  />
            <span class="ring ring-inner"  />

            <!-- Photo -->
            <div class="photo-frame">
                <img
                    v-if="photo"
                    :src="photo"
                    :alt="`${name} profile photo`"
                    class="photo-img"
                />
                <div v-else class="photo-initials">
                    {{ initials }}
                </div>

                <!-- One-time scan sweep -->
                <span class="scan-sweep" aria-hidden="true" />
            </div>

            <!-- Status label bottom -->
            <div class="status-label px-3 bg-tertiary text-primary" aria-hidden="true">
                <span class="status-dot" />
                <span class="font-mono text-[0.48rem] tracking-[0.15em] uppercase">
                    {{ statusText }}
                </span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue'

const props = defineProps({
    photo: { type: String, default: null },
    name:  { type: String, default: 'Atuo Israel' },
})

watch(() => props, () => {}, { immediate: true })

const initials = computed(() =>
    props.name.split(' ').map(w => w.charAt(0).toUpperCase()).slice(0, 2).join('')
)

const ready = ref(false)
const statusLines = ['Available', 'Full-Stack', 'Building', 'Online']
const statusIndex = ref(0)
const statusText  = computed(() => statusLines[statusIndex.value])

let timer = null
onMounted(() => {
    setTimeout(() => { ready.value = true }, 60)
    timer = setInterval(() => {
        statusIndex.value = (statusIndex.value + 1) % statusLines.length
    }, 2400)
})
onBeforeUnmount(() => clearInterval(timer))
</script>

<style scoped>
/* ══════════════════════════
   WRAPPER — everything is
   positioned relative to this
══════════════════════════ */
.photo-wrapper {
    width: 10rem;
    height: 10rem;
}

@media (min-width: 768px) {
    .photo-wrapper { width: 14rem; height: 14rem; }
}

/* ══════════════════════════
   RINGS
══════════════════════════ */
.ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    opacity: 0;
    transition: opacity 1s ease;
    outline: none;
    box-shadow: none;
}
.is-ready .ring { opacity: 1; }

.ring-outer {
    border: 4px dashed rgba(0,0,0, 0.12);
    animation: spinCW 50s linear infinite;
}
.ring-inner {
    inset: 8px;
    border: 4px dashed rgba(0,0,0,0.07);
    animation: spinCCW 50s linear infinite;
}

/* ══════════════════════════
   CORNER BRACKETS
══════════════════════════ */
.corner {
    position: absolute;
    width: 14px;
    height: 14px;
    opacity: 0;
    transition: opacity 0.2s ease, transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
@media (min-width: 768px) {
    .corner { width: 18px; height: 18px; }
}

.corner-tl {
    top: 6px; left: 6px;
    border-top: 2px solid rgba(0,0,0,0.35);
    border-left: 2px solid rgba(0,0,0,0.35);
    transform: translate(4px, 4px);
    transition-delay: 0.7s;
}
.corner-tr {
    top: 6px; right: 6px;
    border-top: 2px solid rgba(0,0,0,0.35);
    border-right: 2px solid rgba(0,0,0,0.35);
    transform: translate(-4px, 4px);
    transition-delay: 0.8s;
}
.corner-bl {
    bottom: 22px; left: 6px;
    border-bottom: 2px solid rgba(0,0,0,0.35);
    border-left: 2px solid rgba(0,0,0,0.35);
    transform: translate(4px, -4px);
    transition-delay: 0.9s;
}
.corner-br {
    bottom: 22px; right: 6px;
    border-bottom: 2px solid rgba(0,0,0,0.35);
    border-right: 2px solid rgba(0,0,0,0.35);
    transform: translate(-4px, -4px);
    transition-delay: 1.0s;
}

.is-ready .corner {
    opacity: 1;
    transform: translate(0, 0);
}

/* ══════════════════════════
   PHOTO FRAME — centered
══════════════════════════ */
.photo-frame {
    position: relative;
    width: 78%;
    height: 78%;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid rgba(0,0,0,0.12);
    background: rgba(0,0,0,0.04);
    opacity: 0;
    transform: scale(0.85);
    transition: opacity 0.45s cubic-bezier(0.34,1.56,0.64,1) 0.15s,
    transform 0.45s cubic-bezier(0.34,1.56,0.64,1) 0.15s,
    box-shadow 0.3s ease;
    flex-shrink: 0;
}
.is-ready .photo-frame {
    opacity: 1;
    transform: scale(1);
}
.photo-frame:hover {
    box-shadow: 0 0 0 4px rgba(0,0,0,0.07);
}

.photo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1);
}
.photo-frame:hover .photo-img { transform: scale(1.05); }

.photo-initials {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-display, serif);
    font-weight: 900;
    font-size: 1.5rem;
    color: rgba(0,0,0,0.6);
    letter-spacing: -0.02em;
}

/* ══════════════════════════
   SCAN SWEEP (one-time)
══════════════════════════ */
.scan-sweep {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        180deg,
        transparent 0%,
        rgba(0,0,0,0.06) 50%,
        transparent 100%
    );
    transform: translateY(-100%);
    animation: scanDown 0.9s ease 0.6s forwards;
    pointer-events: none;
}
@keyframes scanDown {
    from { transform: translateY(-100%); }
    to   { transform: translateY(100%); }
}

/* ══════════════════════════
   STATUS LABEL
══════════════════════════ */
.status-label {
    position: absolute;
    bottom: 10px;
    border-radius: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 4px;
    opacity: 0;
    transition: opacity 0.4s ease 1.2s;
}
.is-ready .status-label { opacity: 1; }

.status-dot {
    width: 5px; height: 5px;
    border-radius: 50%;
    background: rgba(0,0,0,0.3);
    animation: dotPulse 2.4s ease-in-out infinite;
}
@keyframes dotPulse {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50%       { opacity: 0.8; transform: scale(1.3); }
}

/* ══════════════════════════
   KEYFRAMES
══════════════════════════ */
@keyframes spinCW  { to { transform: rotate(360deg); } }
@keyframes spinCCW { to { transform: rotate(-360deg); } }
</style>

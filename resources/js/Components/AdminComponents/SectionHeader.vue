<script setup>
import { ref } from 'vue'

const props = defineProps({
    title: {
        type: String,
        required: true
    }
})

const open = ref(false)
let emits = defineEmits(['toggle'])

function toggle() {
    emits('toggle', props.title)
    open.value = !open.value
}
</script>

<template>
    <div class="accordion-item">
        <header
            @click="toggle"
            class="cursor-pointer px-8 md:px-16 py-4 bg-primary text-tertiary flex items-center justify-between rounded-md hover:shadow-lg transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]"
        >
      <span class="text-xl font-semibold text-tertiary capitalize relative overflow-hidden">
        <span class="inline-block transition-all duration-300" :class="{ 'translate-x-1': open }">
          {{ title }}
        </span>
      </span>

            <svg
                class="w-5 h-5 transition-all duration-300 ease-in-out"
                :class="{ 'rotate-180 scale-110': open, 'scale-100': !open }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                />
            </svg>
        </header>

        <!-- Add smooth border-bottom animation when open -->
        <div
            class="w-full h-0.5 bg-tertiary/20 mx-auto transition-all duration-300 ease-in-out"
            :class="{ 'w-full opacity-100 mt-2': open, 'w-0 opacity-0': !open }"
        ></div>
    </div>
</template>

<style scoped>
.accordion-item {
    transition: all 0.3s ease;
}

/* Optional: Add a subtle pulse animation on the icon when open */
@keyframes gentlePulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.rotate-180 {
    animation: gentlePulse 0.3s ease-in-out;
}

/* Smooth shadow transition */
header {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

header:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Add a subtle shimmer effect on hover */
header::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    /*width: 100%;*/
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
    );
    transition: left 0.5s ease;
    pointer-events: none;
}

header:hover::after {
    left: 100%;
}
</style>

<template>
    <div class="flex flex-col items-center text-center px-3 mt-2 animate-slide-down">

        <!-- Name -->
        <h1 class="font-display font-black text-xl leading-tight tracking-tight text-primary mt-1">
            {{ name }}
        </h1>

        <!-- Animated underline -->
        <div class="mt-1.5 mb-2.5 flex justify-center">
            <div class="h-0.5 w-10 bg-primary rounded-full animate-expand-x origin-center" />
        </div>

        <!-- Role badge -->
        <div
            class="inline-flex items-center gap-1.5 px-3 py-1
             rounded-full border border-primary/20 bg-primary/5
             text-[0.6rem] font-bold tracking-widest uppercase text-primary/70 mb-2.5"
        >
            <!-- Pulsing dot -->
            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse" />
            Full-Stack Developer
        </div>

        <!-- Italic description -->
        <p class="font-serif italic text-[0.78rem] leading-relaxed text-primary/55 px-1">
            "{{ description }}"
        </p>
    </div>
</template>

<script setup>
defineProps({
    name: {
        type: String,
        default: 'Atuo Israel',
    },
    description: {
        type: String,
        default: 'Crafting elegant web experiences — pixel-perfect UIs, scalable APIs, and everything in between.',
    },
})
</script>

<style scoped>
@keyframes slide-down {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes expand-x {
    from { transform: scaleX(0); }
    to   { transform: scaleX(1); }
}

.animate-slide-down { animation: slide-down 0.45s ease 0.15s both; }
.animate-expand-x   { animation: expand-x 0.5s ease 0.35s both; }
</style>

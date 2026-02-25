<template>
    <div class="flex flex-col items-center pt-2 pb-1">
        <!-- Orbit ring wrapper -->
        <div class="relative flex items-center justify-center w-28 h-28 md:w-56 md:h-56">

            <!-- Spinning dashed ring -->
            <div
                class="absolute inset-0 rounded-full border-2 border-dashed border-primary/30 animate-spin-slow"
            />

            <!-- Solid accent ring -->
            <div
                class="absolute inset-1.5 rounded-full border border-primary/20"
            />

            <!-- Photo frame -->
            <div
                class="relative w-full h-full rounded-full border-2 border-primary
           shadow-[0_0_0_4px_theme(colors.primary/10%)]
           overflow-hidden animate-fade-scale flex items-center justify-center bg-gray-100"
            >
                <img
                    v-if="photo"
                    :src="photo"
                    :alt="`${name} profile photo`"
                    class="w-72 h-72 object-contain  l"
                />

                <!-- Initials fallback -->
                <div
                    v-else
                    class="w-full h-full flex items-center justify-center
               bg-gradient-to-br from-primary/10 to-primary/5
               font-display font-black text-2xl text-primary tracking-tight"
                >
                    {{ initials }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    photo: {
        type: String,
        default: null,
    },
    name: {
        type: String,
        default: 'Atuo Israel',
    },
})

const initials = computed(() =>
    props.name
        .split(' ')
        .map((w) => w.charAt(0).toUpperCase())
        .slice(0, 2)
        .join('')
)
</script>

<style scoped>
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

@keyframes fade-scale {
    from { opacity: 0; transform: scale(0.65); }
    to   { opacity: 1; transform: scale(1); }
}

.animate-spin-slow   { animation: spin-slow 14s linear infinite; }
.animate-fade-scale  { animation: fade-scale 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both; }
</style>

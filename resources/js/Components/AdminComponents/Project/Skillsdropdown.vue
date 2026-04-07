<template>
    <div class="flex flex-col">
        <label class="text-[0.72rem] font-medium text-[#78716c] uppercase tracking-wide mb-1.5">
            Skills Used <span class="font-normal normal-case tracking-normal text-[#b5b0aa]">(one or more)</span>
        </label>
        <div class="relative" ref="dropdownRef">
            <button
                type="button"
                @click="open = !open"
                :disabled="disabled"
                class="w-full h-10 px-3.5 flex items-center justify-between gap-2 bg-white rounded-[10px] border cursor-pointer transition focus:outline-none focus:border-[#1c1917] focus:shadow-[0_0_0_3px_rgba(28,25,23,0.07)] disabled:opacity-50 disabled:cursor-not-allowed"
                :class="error ? 'border-red-400' : 'border-[#ddd9d4]'"
            >
                <span class="text-sm truncate" :class="modelValue.length ? 'text-[#1c1917]' : 'text-[#c0bbb5]'">
                    {{ modelValue.length ? `${modelValue.length} skill${modelValue.length > 1 ? 's' : ''} selected` : 'Select skills…' }}
                </span>
                <svg class="w-[15px] h-[15px] text-[#a8a29e] flex-shrink-0 transition-transform duration-150" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>

            <div v-if="open" class="absolute top-[calc(100%+6px)] left-0 right-0 z-30 bg-white border border-[#e5e3df] rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.10)] overflow-hidden">
                <div class="max-h-44 overflow-y-auto py-1">
                    <label v-for="skill in skills" :key="skill.id" class="flex items-center gap-2.5 px-3.5 py-2 cursor-pointer hover:bg-[#f5f3f0] transition-colors">
                        <input type="checkbox" :value="skill.id" :checked="modelValue.includes(skill.id)" @change="toggle(skill.id)" class="w-3.5 h-3.5 rounded cursor-pointer accent-[#1c1917]" />
                        <span class="text-[0.8125rem] text-[#1c1917]">{{ skill.name }}</span>
                    </label>
                    <p v-if="!skills.length" class="px-3.5 py-2 text-xs text-[#a8a29e]">No skills available.</p>
                </div>
                <div v-if="modelValue.length" class="border-t border-[#eceae6] px-3.5 py-2 flex items-center justify-between">
                    <span class="font-mono text-[0.7rem] text-[#a8a29e]">{{ modelValue.length }} selected</span>
                    <button type="button" @click="$emit('update:modelValue', [])" class="text-[0.7rem] text-red-400 hover:text-red-600 bg-transparent border-none cursor-pointer p-0 transition-colors">Clear all</button>
                </div>
            </div>
        </div>

        <!-- Badges -->
        <div v-if="modelValue.length" class="flex flex-wrap gap-1.5 mt-2">
            <span v-for="id in modelValue" :key="id" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-[5px] bg-[#f0ede9] border border-[#e5e3df] text-[#44403c] text-[0.7rem] font-medium pr-1.5">
                {{ skillName(id) }}
                <button type="button" @click="remove(id)" class="flex items-center justify-center bg-transparent border-none cursor-pointer p-0 text-[#a8a29e] hover:text-red-400 transition-colors">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
            </span>
        </div>
        <p v-if="error" class="mt-1 text-[0.7rem] text-red-400">
            {{ Array.isArray(error) ? error[0] : error }}
        </p>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
    modelValue: { type: Array,   default: () => [] },
    skills:     { type: Array,   default: () => [] },
    disabled:   { type: Boolean, default: false },
    error:      { default: null },
})
const emit = defineEmits(['update:modelValue'])

const open        = ref(false)
const dropdownRef = ref(null)

function skillName(id) { return props.skills.find(s => s.id === id)?.name ?? id }

function toggle(id) {
    const next = props.modelValue.includes(id)
        ? props.modelValue.filter(i => i !== id)
        : [...props.modelValue, id]
    emit('update:modelValue', next)
}

function remove(id) { emit('update:modelValue', props.modelValue.filter(i => i !== id)) }

function onOutside(e) {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) open.value = false
}

onMounted(()        => document.addEventListener('mousedown', onOutside))
onBeforeUnmount(()  => document.removeEventListener('mousedown', onOutside))
</script>

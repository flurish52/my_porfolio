<template>
    <div class="bg-[#fafaf9] border border-[#e5e3df] rounded-2xl overflow-hidden shadow-[0_1px_2px_rgba(0,0,0,0.04),0_4px_16px_rgba(0,0,0,0.03)] hover:shadow-[0_1px_2px_rgba(0,0,0,0.05),0_8px_24px_rgba(0,0,0,0.06)] transition-shadow duration-200">

        <!-- Header -->
        <div class="flex items-start gap-4 px-6 py-5 border-b border-[#eceae6] bg-white">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="font-mono text-[0.6rem] font-medium tracking-[0.1em] text-[#a09d98] bg-[#f0ede9] border border-[#e5e3df] rounded px-1.5 py-0.5 leading-none">NEW</span>
                    <h2 class="m-0 text-sm font-semibold text-[#1c1917] tracking-tight">Add Project</h2>
                </div>
                <p class="mt-1 text-[0.72rem] text-[#a8a29e] leading-snug">Fill in the project details and link the skills used.</p>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-5 bg-[#fafaf9] flex flex-col gap-4">

            <!-- Row 1: Title + Skills -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                <!-- Title -->
                <div class="flex flex-col">
                    <label class="text-[0.72rem] font-medium text-[#78716c] uppercase tracking-wide mb-1.5">Project Title</label>
                    <div
                        class="flex items-center gap-2.5 bg-white border rounded-[10px] px-3.5 transition focus-within:border-[#1c1917] focus-within:shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                        :class="form.errors?.title ? 'border-red-400' : 'border-[#ddd9d4]'"
                    >
                        <svg class="w-[15px] h-[15px] text-[#c0bbb5] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                        </svg>
                        <input
                            v-model="form.title"
                            type="text"
                            placeholder="e.g. Portfolio Website…"
                            :disabled="form.saving"
                            class="flex-1 border-none outline-none bg-transparent text-sm text-[#1c1917] placeholder-[#c0bbb5] py-2.5 disabled:opacity-50 disabled:cursor-not-allowed"
                        />
                    </div>
                    <p v-if="form.errors?.title" class="mt-1 text-[0.7rem] text-red-400">
                        {{ Array.isArray(form.errors.title) ? form.errors.title[0] : form.errors.title }}
                    </p>
                </div>

                <!-- Skills multi-select -->
                <SkillsDropdown
                    v-model="form.skill_ids"
                    :skills="skills"
                    :disabled="form.saving"
                    :error="form.errors?.skill_ids"
                />
            </div>

            <!-- Row 2: Role + Link -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                <!-- Role -->
                <div class="flex flex-col">
                    <label class="text-[0.72rem] font-medium text-[#78716c] uppercase tracking-wide mb-1.5">
                        Role <span class="font-normal normal-case tracking-normal text-[#b5b0aa]">(optional)</span>
                    </label>
                    <div
                        class="flex items-center gap-2.5 bg-white border rounded-[10px] px-3.5 transition focus-within:border-[#1c1917] focus-within:shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                        :class="form.errors?.role ? 'border-red-400' : 'border-[#ddd9d4]'"
                    >
                        <svg class="w-[15px] h-[15px] text-[#c0bbb5] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                        <input
                            v-model="form.role"
                            type="text"
                            placeholder="e.g. Lead Developer…"
                            :disabled="form.saving"
                            class="flex-1 border-none outline-none bg-transparent text-sm text-[#1c1917] placeholder-[#c0bbb5] py-2.5 disabled:opacity-50 disabled:cursor-not-allowed"
                        />
                    </div>
                    <p v-if="form.errors?.role" class="mt-1 text-[0.7rem] text-red-400">
                        {{ Array.isArray(form.errors.role) ? form.errors.role[0] : form.errors.role }}
                    </p>
                </div>

                <!-- Link -->
                <div class="flex flex-col">
                    <label class="text-[0.72rem] font-medium text-[#78716c] uppercase tracking-wide mb-1.5">
                        Link <span class="font-normal normal-case tracking-normal text-[#b5b0aa]">(optional)</span>
                    </label>
                    <div
                        class="flex items-center gap-2.5 bg-white border rounded-[10px] px-3.5 transition focus-within:border-[#1c1917] focus-within:shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                        :class="form.errors?.link ? 'border-red-400' : 'border-[#ddd9d4]'"
                    >
                        <svg class="w-[15px] h-[15px] text-[#c0bbb5] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                        </svg>
                        <input
                            v-model="form.link"
                            type="url"
                            placeholder="https://…"
                            :disabled="form.saving"
                            class="flex-1 border-none outline-none bg-transparent text-sm text-[#1c1917] placeholder-[#c0bbb5] py-2.5 disabled:opacity-50 disabled:cursor-not-allowed"
                        />
                    </div>
                    <p v-if="form.errors?.link" class="mt-1 text-[0.7rem] text-red-400">
                        {{ Array.isArray(form.errors.link) ? form.errors.link[0] : form.errors.link }}
                    </p>
                </div>
            </div>

            <!-- Row 3: Image upload -->
            <ProjectImageUploader
                v-model="form.image"
                :disabled="form.saving"
                :external-error="form.errors?.image"
            />

            <!-- Row 4: Description -->
            <div class="flex flex-col">
                <label class="text-[0.72rem] font-medium text-[#78716c] uppercase tracking-wide mb-1.5">Description</label>
                <div
                    class="bg-white border rounded-[10px] transition focus-within:border-[#1c1917] focus-within:shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                    :class="form.errors?.description ? 'border-red-400' : 'border-[#ddd9d4]'"
                >
                    <textarea
                        v-model="form.description"
                        rows="3"
                        placeholder="Brief description of the project…"
                        :disabled="form.saving"
                        class="w-full block border-none outline-none bg-transparent text-sm text-[#1c1917] placeholder-[#c0bbb5] px-3.5 py-2.5 resize-y leading-relaxed disabled:opacity-50 disabled:cursor-not-allowed"
                    ></textarea>
                </div>
                <p v-if="form.errors?.description" class="mt-1 text-[0.7rem] text-red-400">
                    {{ Array.isArray(form.errors.description) ? form.errors.description[0] : form.errors.description }}
                </p>
            </div>

            <!-- General error -->
            <p v-if="form.errors?.general" class="m-0 text-[0.75rem] text-red-600 bg-[#fff5f5] border border-[#fecaca] rounded-lg px-3 py-2">
                {{ form.errors.general }}
            </p>

            <!-- Save -->
            <div class="flex justify-end pt-1">
                <button
                    @click="$emit('save')"
                    :disabled="form.saving || !form.title.trim()"
                    class="inline-flex items-center justify-center gap-1.5 px-5 h-10 rounded-[10px] bg-[#1c1917] text-[#fafaf9] border-none text-[0.8125rem] font-semibold tracking-tight cursor-pointer whitespace-nowrap transition-all hover:opacity-80 active:scale-[0.97] disabled:opacity-35 disabled:cursor-not-allowed disabled:scale-100"
                >
                    <span v-if="form.saving" class="inline-block w-3.5 h-3.5 border-2 border-white/30 border-t-white rounded-full animate-spin flex-shrink-0"></span>
                    <svg v-else class="w-[15px] h-[15px]" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    {{ form.saving ? 'Saving…' : 'Save Project' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import ProjectImageUploader from './ProjectImageUploader.vue'
import SkillsDropdown from './SkillsDropdown.vue'

defineProps({
    form:   { type: Object, required: true },
    skills: { type: Array,  default: () => [] },
})
defineEmits(['save'])
</script>

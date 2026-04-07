<template>
    <div class="bg-[#fafaf9] border border-[#e5e3df] rounded-2xl overflow-hidden shadow-[0_1px_2px_rgba(0,0,0,0.04),0_4px_16px_rgba(0,0,0,0.03)] hover:shadow-[0_1px_2px_rgba(0,0,0,0.05),0_8px_24px_rgba(0,0,0,0.06)] transition-shadow duration-200">

        <!-- Header -->
        <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-[#eceae6] bg-white">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="font-mono text-[0.6rem] font-medium tracking-[0.1em] text-[#a09d98] bg-[#f0ede9] border border-[#e5e3df] rounded px-1.5 py-0.5 leading-none">LIST</span>
                    <h2 class="m-0 text-sm font-semibold text-[#1c1917] tracking-tight">Existing Projects</h2>
                </div>
                <p class="mt-1 text-[0.72rem] text-[#a8a29e] leading-snug">
                    {{ list.length }} {{ list.length === 1 ? 'project' : 'projects' }} total
                </p>
            </div>
            <span class="inline-flex items-center justify-center min-w-[28px] h-[22px] px-2 rounded-full bg-[#1c1917] text-[#fafaf9] font-mono text-[0.7rem] font-medium tracking-wide">
                {{ list.length }}
            </span>
        </div>

        <!-- Empty state -->
        <div v-if="list.length === 0" class="flex flex-col items-center justify-center py-16 px-6 text-center gap-2">
            <div class="w-11 h-11 rounded-xl bg-[#f0ede9] border border-[#e5e3df] flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-[#c0bbb5]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
            </div>
            <p class="m-0 text-sm font-semibold text-[#44403c]">No projects yet</p>
            <p class="m-0 text-xs text-[#a8a29e] max-w-[240px] leading-relaxed">Create your first project using the form above.</p>
        </div>

        <!-- Table -->
        <div v-else class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-[#f5f3f0] border-b border-[#eceae6]">
                    <th class="w-[52px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">#</th>
                    <th class="min-w-[140px] max-w-[200px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Title</th>
                    <th class="min-w-[120px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Role</th>
                    <th class="min-w-[180px] max-w-[260px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Description</th>
                    <th class="min-w-[160px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Skills</th>
                    <th class="min-w-[80px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Image</th>
                    <th class="min-w-[80px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Link</th>
                    <th class="px-5 py-2.5 text-right font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(project, index) in list"
                    :key="project.id"
                    class="border-b border-[#f0ede9] last:border-b-0 transition-colors duration-100 hover:bg-[#f7f5f2]"
                    :class="editing.id === project.id ? 'bg-[#fdf8f2] border-l-[3px] border-l-[#1c1917]' : ''"
                >
                    <!-- # -->
                    <td class="w-[52px] px-5 py-3.5 align-top">
                        <span class="font-mono text-[0.7rem] text-[#c0bbb5] tracking-wide">{{ String(index + 1).padStart(2, '0') }}</span>
                    </td>

                    <!-- Title -->
                    <td class="min-w-[140px] max-w-[200px] px-5 py-3.5 align-top">
                        <template v-if="editing.id === project.id">
                            <input
                                v-model="editing.title"
                                type="text"
                                placeholder="Project title"
                                ref="editTitleInput"
                                @keydown.esc="$emit('cancel-edit')"
                                class="w-full px-2.5 py-1.5 border border-[#1c1917] rounded-[7px] bg-white font-sans text-[0.8125rem] text-[#1c1917] outline-none shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                            />
                            <p v-if="editing.errors?.title" class="mt-1 text-[0.7rem] text-red-400">{{ arrFirst(editing.errors.title) }}</p>
                        </template>
                        <span v-else class="text-sm font-semibold text-[#1c1917] tracking-tight">{{ project.title }}</span>
                    </td>

                    <!-- Role -->
                    <td class="min-w-[120px] px-5 py-3.5 align-top">
                        <template v-if="editing.id === project.id">
                            <input
                                v-model="editing.role"
                                type="text"
                                placeholder="Role"
                                @keydown.esc="$emit('cancel-edit')"
                                class="w-full px-2.5 py-1.5 border border-[#1c1917] rounded-[7px] bg-white font-sans text-[0.8125rem] text-[#1c1917] outline-none shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                            />
                            <p v-if="editing.errors?.role" class="mt-1 text-[0.7rem] text-red-400">{{ arrFirst(editing.errors.role) }}</p>
                        </template>
                        <template v-else>
                            <span v-if="project.role" class="inline-flex items-center px-2 py-0.5 rounded-[5px] bg-[#f0ede9] border border-[#e5e3df] text-[#44403c] text-[0.7rem] font-medium">{{ project.role }}</span>
                            <span v-else class="text-[0.8rem] text-[#c0bbb5]">—</span>
                        </template>
                    </td>

                    <!-- Description -->
                    <td class="min-w-[180px] max-w-[260px] px-5 py-3.5 align-top">
                        <template v-if="editing.id === project.id">
                            <textarea
                                v-model="editing.description"
                                rows="2"
                                placeholder="Description"
                                @keydown.esc="$emit('cancel-edit')"
                                class="w-full px-2.5 py-1.5 border border-[#1c1917] rounded-[7px] bg-white font-sans text-[0.8125rem] text-[#1c1917] outline-none shadow-[0_0_0_3px_rgba(28,25,23,0.07)] resize-y leading-relaxed"
                            ></textarea>
                            <p v-if="editing.errors?.description" class="mt-1 text-[0.7rem] text-red-400">{{ arrFirst(editing.errors.description) }}</p>
                        </template>
                        <span v-else class="text-[0.8rem] text-[#78716c] leading-relaxed line-clamp-2">{{ project.description || '—' }}</span>
                    </td>

                    <!-- Skills -->
                    <td class="min-w-[160px] px-5 py-3.5 align-top">
                        <template v-if="editing.id === project.id">
                            <SkillsDropdown
                                v-model="editing.skill_ids"
                                :skills="skills"
                                :error="editing.errors?.skill_ids"
                                compact
                            />
                        </template>
                        <div v-else class="flex flex-wrap gap-1.5">
                            <span v-for="skill in project.skills" :key="skill.id" class="inline-flex items-center px-2 py-0.5 rounded-[5px] bg-[#f0ede9] border border-[#e5e3df] text-[#44403c] text-[0.7rem] font-medium">{{ skill.name }}</span>
                            <span v-if="!project.skills?.length" class="text-[0.8rem] text-[#c0bbb5]">—</span>
                        </div>
                    </td>

                    <!-- Image -->
                    <td class="min-w-[80px] px-5 py-3.5 align-top">
                        <template v-if="editing.id === project.id">
                            <ProjectImageUploader
                                v-model="editing.image"
                                :external-error="editing.errors?.image"
                                compact
                            />
                        </template>
                        <div v-else>
                            <div v-if="project.image" class="w-9 h-9 rounded-[7px] overflow-hidden border border-[#e5e3df] bg-[#f5f3f0]">
                                <img :src="`/storage/${project.image}`" :alt="project.title" class="w-full h-full object-cover" @error="e => e.target.parentElement.style.display='none'" />
                            </div>
                            <span v-else class="text-[0.8rem] text-[#c0bbb5]">—</span>
                        </div>
                    </td>

                    <!-- Link -->
                    <td class="min-w-[80px] px-5 py-3.5 align-top">
                        <template v-if="editing.id === project.id">
                            <input
                                v-model="editing.link"
                                type="url"
                                placeholder="Link to your project e.g https://…"
                                @keydown.esc="$emit('cancel-edit')"
                                class="w-full px-2.5 py-1.5 border border-[#1c1917] rounded-[7px] bg-white font-sans text-[0.8125rem] text-[#1c1917] outline-none shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                            />
                            <p v-if="editing.errors?.link" class="mt-1 text-[0.7rem] text-red-400">{{ arrFirst(editing.errors.link) }}</p>
                        </template>
                        <div v-else>
                            <a
                                v-if="project.link"
                                :href="project.link"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1 text-[0.75rem] text-[#1c1917] font-medium hover:underline underline-offset-2"
                            >
                                <svg class="w-3 h-3 text-[#a8a29e] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                                Visit
                            </a>
                            <span v-else class="text-[0.8rem] text-[#c0bbb5]">—</span>
                        </div>
                    </td>

                    <!-- Actions -->
                    <td class="px-5 py-3.5 align-top text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-1.5 flex-wrap">
                            <p v-if="editing.id === project.id && editing.errors?.general" class="mr-2 text-[0.7rem] text-red-400">
                                {{ editing.errors.general }}
                            </p>

                            <template v-if="editing.id === project.id">
                                <button
                                    @click="$emit('confirm-edit', project)"
                                    :disabled="editing.saving || !editing.title.trim()"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] bg-[#1c1917] text-[#fafaf9] border-none text-xs font-semibold cursor-pointer whitespace-nowrap transition-all hover:opacity-80 active:scale-[0.96] disabled:opacity-40 disabled:cursor-not-allowed"
                                >
                                    <span v-if="editing.saving" class="inline-block w-[11px] h-[11px] border-2 border-white/30 border-t-white rounded-full animate-spin flex-shrink-0"></span>
                                    <svg v-else class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                    </svg>
                                    {{ editing.saving ? 'Saving…' : 'Confirm' }}
                                </button>
                                <button
                                    @click="$emit('cancel-edit')"
                                    class="inline-flex items-center px-3 py-1.5 rounded-[7px] bg-transparent border border-[#e5e3df] text-[#78716c] text-xs font-semibold cursor-pointer whitespace-nowrap hover:bg-[#f0ede9] transition-colors"
                                >
                                    Cancel
                                </button>
                            </template>

                            <template v-else>
                                <button
                                    @click="$emit('start-edit', project)"
                                    :disabled="!!deleting"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] bg-[#f5f3f0] border border-[#e5e3df] text-[#44403c] text-xs font-semibold cursor-pointer whitespace-nowrap transition-colors hover:bg-[#eceae6] hover:text-[#1c1917] active:scale-[0.96] disabled:opacity-40 disabled:cursor-not-allowed"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                    </svg>
                                    Edit
                                </button>
                                <button
                                    @click="$emit('delete', project)"
                                    :disabled="deleting === project.id"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] bg-[#fff5f5] border border-[#fecaca] text-red-400 text-xs font-semibold cursor-pointer whitespace-nowrap transition-colors hover:bg-[#fee2e2] active:scale-[0.96] disabled:opacity-40 disabled:cursor-not-allowed"
                                >
                                    <span v-if="deleting === project.id" class="inline-block w-[11px] h-[11px] border-2 border-red-200 border-t-red-400 rounded-full animate-spin flex-shrink-0"></span>
                                    <svg v-else class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                    {{ deleting === project.id ? 'Deleting…' : 'Delete' }}
                                </button>
                            </template>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, nextTick, watch } from 'vue'
import SkillsDropdown from './SkillsDropdown.vue'
import ProjectImageUploader from './ProjectImageUploader.vue'

const props = defineProps({
    list:     { type: Object, required: true },   // ref passed in
    editing:  { type: Object, required: true },
    deleting: { default: null },
    skills:   { type: Array, default: () => [] },
})

defineEmits(['start-edit', 'cancel-edit', 'confirm-edit', 'delete'])

const editTitleInput = ref(null)

watch(() => props.editing.id, async (id) => {
    if (id !== null) {
        await nextTick()
        editTitleInput.value?.focus()
    }
})

function arrFirst(v) { return Array.isArray(v) ? v[0] : v }
</script>

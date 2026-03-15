<template>
    <div class="flex flex-col gap-5">

        <!-- ── Toast ──────────────────────────────────────────── -->
        <transition
            enter-active-class="transition-all duration-250 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            leave-active-class="transition-all duration-200 ease-in"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-if="toast.show"
                class="fixed top-5 right-5 z-[9999] flex items-start gap-3 px-4 py-3.5 rounded-xl border max-w-sm w-full shadow-[0_8px_32px_rgba(0,0,0,0.10)]"
                :class="toast.type === 'success'
                    ? 'bg-[#f0fdf4] border-[#bbf7d0]'
                    : 'bg-[#fff5f5] border-[#fecaca]'"
            >
                <div
                    class="flex-shrink-0 w-[22px] h-[22px] rounded-full flex items-center justify-center mt-px"
                    :class="toast.type === 'success' ? 'bg-[#dcfce7]' : 'bg-[#fee2e2]'"
                >
                    <svg v-if="toast.type === 'success'" class="w-3 h-3 text-[#16a34a]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    <svg v-else class="w-3 h-3 text-[#ef4444]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="m-0 text-[0.8125rem] font-semibold" :class="toast.type === 'success' ? 'text-[#15803d]' : 'text-[#dc2626]'">
                        {{ toast.type === 'success' ? 'Success' : 'Error' }}
                    </p>
                    <p class="m-0 mt-0.5 text-[0.72rem] leading-snug" :class="toast.type === 'success' ? 'text-[#166534]' : 'text-[#b91c1c]'">
                        {{ toast.message }}
                    </p>
                </div>
                <button @click="toast.show = false" class="flex-shrink-0 bg-transparent border-none cursor-pointer p-0 text-gray-400 hover:text-gray-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </transition>

        <!-- ── Create Form ────────────────────────────────────── -->
        <div class="bg-[#fafaf9] border border-[#e5e3df] rounded-2xl overflow-hidden shadow-[0_1px_2px_rgba(0,0,0,0.04),0_4px_16px_rgba(0,0,0,0.03)] hover:shadow-[0_1px_2px_rgba(0,0,0,0.05),0_8px_24px_rgba(0,0,0,0.06)] transition-shadow duration-200">

            <!-- Header -->
            <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-[#eceae6] bg-white">
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
                    <div class="flex flex-col">
                        <label class="text-[0.72rem] font-medium text-[#78716c] uppercase tracking-wide mb-1.5">
                            Skills Used <span class="font-normal normal-case tracking-normal text-[#b5b0aa]">(one or more)</span>
                        </label>
                        <div class="relative" ref="formDropdownRef">
                            <button
                                type="button"
                                @click="formDropdownOpen = !formDropdownOpen"
                                :disabled="form.saving"
                                class="w-full h-10 px-3.5 flex items-center justify-between gap-2 bg-white rounded-[10px] border cursor-pointer transition focus:outline-none focus:border-[#1c1917] focus:shadow-[0_0_0_3px_rgba(28,25,23,0.07)] disabled:opacity-50 disabled:cursor-not-allowed"
                                :class="form.errors?.skill_ids ? 'border-red-400' : 'border-[#ddd9d4]'"
                            >
                                <span class="text-sm truncate" :class="form.skill_ids.length ? 'text-[#1c1917]' : 'text-[#c0bbb5]'">
                                    {{ form.skill_ids.length ? `${form.skill_ids.length} skill${form.skill_ids.length > 1 ? 's' : ''} selected` : 'Select skills…' }}
                                </span>
                                <svg class="w-[15px] h-[15px] text-[#a8a29e] flex-shrink-0 transition-transform duration-150" :class="{ 'rotate-180': formDropdownOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </button>

                            <div v-if="formDropdownOpen" class="absolute top-[calc(100%+6px)] left-0 right-0 z-30 bg-white border border-[#e5e3df] rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.10)] overflow-hidden">
                                <div class="max-h-44 overflow-y-auto py-1">
                                    <label v-for="skill in skills" :key="skill.id" class="flex items-center gap-2.5 px-3.5 py-2 cursor-pointer hover:bg-[#f5f3f0] transition-colors">
                                        <input type="checkbox" :value="skill.id" v-model="form.skill_ids" class="w-3.5 h-3.5 rounded cursor-pointer accent-[#1c1917]" />
                                        <span class="text-[0.8125rem] text-[#1c1917]">{{ skill.name }}</span>
                                    </label>
                                    <p v-if="!skills.length" class="px-3.5 py-2 text-xs text-[#a8a29e]">No skills available.</p>
                                </div>
                                <div v-if="form.skill_ids.length" class="border-t border-[#eceae6] px-3.5 py-2 flex items-center justify-between">
                                    <span class="font-mono text-[0.7rem] text-[#a8a29e]">{{ form.skill_ids.length }} selected</span>
                                    <button type="button" @click="form.skill_ids = []" class="text-[0.7rem] text-red-400 hover:text-red-600 bg-transparent border-none cursor-pointer p-0 transition-colors">Clear all</button>
                                </div>
                            </div>
                        </div>

                        <!-- Badges -->
                        <div v-if="form.skill_ids.length" class="flex flex-wrap gap-1.5 mt-2">
                            <span v-for="id in form.skill_ids" :key="id" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-[5px] bg-[#f0ede9] border border-[#e5e3df] text-[#44403c] text-[0.7rem] font-medium pr-1.5">
                                {{ skillName(id) }}
                                <button type="button" @click="form.skill_ids = form.skill_ids.filter(i => i !== id)" class="flex items-center justify-center bg-transparent border-none cursor-pointer p-0 text-[#a8a29e] hover:text-red-400 transition-colors">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                                </button>
                            </span>
                        </div>
                        <p v-if="form.errors?.skill_ids" class="mt-1 text-[0.7rem] text-red-400">
                            {{ Array.isArray(form.errors.skill_ids) ? form.errors.skill_ids[0] : form.errors.skill_ids }}
                        </p>
                    </div>
                </div>

                <!-- Row 2: Description -->
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
                        @click="saveProject"
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

        <!-- ── Table Card ─────────────────────────────────────── -->
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

            <!-- Empty -->
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
                        <th class="min-w-[180px] max-w-[260px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Description</th>
                        <th class="min-w-[160px] px-5 py-2.5 text-left font-mono text-[0.62rem] font-medium tracking-[0.08em] text-[#a8a29e] uppercase whitespace-nowrap">Skills</th>
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
                        <!-- Index -->
                        <td class="w-[52px] px-5 py-3.5 align-top">
                            <span class="font-mono text-[0.7rem] text-[#c0bbb5] tracking-wide">{{ String(index + 1).padStart(2, '0') }}</span>
                        </td>

                        <!-- Title -->
                        <td class="min-w-[140px] max-w-[200px] px-5 py-3.5 align-top">
                            <div v-if="editing.id === project.id">
                                <input
                                    v-model="editing.title"
                                    type="text"
                                    placeholder="Project title"
                                    ref="editTitleInput"
                                    @keydown.esc="cancelEdit"
                                    class="w-full px-2.5 py-1.5 border border-[#1c1917] rounded-[7px] bg-white font-sans text-[0.8125rem] text-[#1c1917] outline-none shadow-[0_0_0_3px_rgba(28,25,23,0.07)]"
                                />
                                <p v-if="editing.errors?.title" class="mt-1 text-[0.7rem] text-red-400">
                                    {{ Array.isArray(editing.errors.title) ? editing.errors.title[0] : editing.errors.title }}
                                </p>
                            </div>
                            <span v-else class="text-sm font-semibold text-[#1c1917] tracking-tight">{{ project.title }}</span>
                        </td>

                        <!-- Description -->
                        <td class="min-w-[180px] max-w-[260px] px-5 py-3.5 align-top">
                            <div v-if="editing.id === project.id">
                                    <textarea
                                        v-model="editing.description"
                                        rows="2"
                                        placeholder="Description"
                                        @keydown.esc="cancelEdit"
                                        class="w-full px-2.5 py-1.5 border border-[#1c1917] rounded-[7px] bg-white font-sans text-[0.8125rem] text-[#1c1917] outline-none shadow-[0_0_0_3px_rgba(28,25,23,0.07)] resize-y leading-relaxed"
                                    ></textarea>
                                <p v-if="editing.errors?.description" class="mt-1 text-[0.7rem] text-red-400">
                                    {{ Array.isArray(editing.errors.description) ? editing.errors.description[0] : editing.errors.description }}
                                </p>
                            </div>
                            <span v-else class="text-[0.8rem] text-[#78716c] leading-relaxed line-clamp-2">{{ project.description || '—' }}</span>
                        </td>

                        <!-- Skills -->
                        <td class="min-w-[160px] px-5 py-3.5 align-top">
                            <!-- Edit dropdown -->
                            <div v-if="editing.id === project.id">
                                <div class="relative" :ref="el => editDropdownRefs[project.id] = el">
                                    <button
                                        type="button"
                                        @click="editDropdownOpen = editDropdownOpen === project.id ? null : project.id"
                                        class="w-full h-8 px-2.5 flex items-center justify-between gap-2 bg-white border border-[#1c1917] rounded-[7px] cursor-pointer focus:outline-none"
                                    >
                                            <span class="text-sm truncate" :class="editing.skill_ids.length ? 'text-[#1c1917]' : 'text-[#c0bbb5]'">
                                                {{ editing.skill_ids.length ? `${editing.skill_ids.length} selected` : 'Select…' }}
                                            </span>
                                        <svg class="w-[15px] h-[15px] text-[#a8a29e] flex-shrink-0 transition-transform duration-150" :class="{ 'rotate-180': editDropdownOpen === project.id }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>

                                    <div v-if="editDropdownOpen === project.id"
                                         class="absolute  left-0 right-0 z-30 bg-white border border-[#e5e3df] rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.10)] overflow-hidden min-w-[180px]">
                                        <div class="max-h-44 overflow-y-auto py-1">
                                            <label v-for="skill in skills" :key="skill.id" class="flex items-center gap-2.5 px-3.5 py-2 cursor-pointer hover:bg-[#f5f3f0] transition-colors">
                                                <input type="checkbox" :value="skill.id" v-model="editing.skill_ids" class="w-3.5 h-3.5 rounded cursor-pointer accent-[#1c1917]" />
                                                <span class="text-[0.8125rem] text-[#1c1917]">{{ skill.name }}</span>
                                            </label>
                                        </div>
                                        <div v-if="editing.skill_ids.length" class="border-t border-[#eceae6] px-3.5 py-2 flex items-center justify-between">
                                            <span class="font-mono text-[0.7rem] text-[#a8a29e]">{{ editing.skill_ids.length }} selected</span>
                                            <button type="button" @click="editing.skill_ids = []" class="text-[0.7rem] text-red-400 hover:text-red-600 bg-transparent border-none cursor-pointer p-0">Clear</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit badges -->
                                <div v-if="editing.skill_ids.length" class="flex flex-wrap gap-1.5 mt-2">
                                        <span v-for="id in editing.skill_ids" :key="id" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-[5px] bg-[#f0ede9] border border-[#e5e3df] text-[#44403c] text-[0.7rem] font-medium pr-1.5">
                                            {{ skillName(id) }}
                                            <button type="button" @click="editing.skill_ids = editing.skill_ids.filter(i => i !== id)" class="flex items-center bg-transparent border-none cursor-pointer p-0 text-[#a8a29e] hover:text-red-400 transition-colors">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                                            </button>
                                        </span>
                                </div>
                                <p v-if="editing.errors?.skill_ids" class="mt-1 text-[0.7rem] text-red-400">
                                    {{ Array.isArray(editing.errors.skill_ids) ? editing.errors.skill_ids[0] : editing.errors.skill_ids }}
                                </p>
                            </div>

                            <!-- Display badges -->
                            <div v-else class="flex flex-wrap gap-1.5">
                                <span v-for="skill in project.skills" :key="skill.id" class="inline-flex items-center px-2 py-0.5 rounded-[5px] bg-[#f0ede9] border border-[#e5e3df] text-[#44403c] text-[0.7rem] font-medium">{{ skill.name }}</span>
                                <span v-if="!project.skills?.length" class="text-[0.8rem] text-[#c0bbb5]">—</span>
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
                                        @click="confirmEdit(project)"
                                        :disabled="editing.saving || !editing.title.trim()"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] bg-[#1c1917] text-[#fafaf9] border-none text-xs font-semibold cursor-pointer whitespace-nowrap transition-all hover:opacity-80 active:scale-[0.96] disabled:opacity-40 disabled:cursor-not-allowed"
                                    >
                                        <span v-if="editing.saving" class="inline-block w-[11px] h-[11px] border-2 border-white/30 border-t-white rounded-full animate-spin flex-shrink-0"></span>
                                        <svg v-else class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                        </svg>
                                        {{ editing.saving ? 'Saving…' : 'Confirm' }}
                                    </button>
                                    <button @click="cancelEdit" class="inline-flex items-center px-3 py-1.5 rounded-[7px] bg-transparent border border-[#e5e3df] text-[#78716c] text-xs font-semibold cursor-pointer whitespace-nowrap hover:bg-[#f0ede9] transition-colors">
                                        Cancel
                                    </button>
                                </template>

                                <template v-else>
                                    <button
                                        @click="startEdit(project)"
                                        :disabled="!!deleting"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[7px] bg-[#f5f3f0] border border-[#e5e3df] text-[#44403c] text-xs font-semibold cursor-pointer whitespace-nowrap transition-colors hover:bg-[#eceae6] hover:text-[#1c1917] active:scale-[0.96] disabled:opacity-40 disabled:cursor-not-allowed"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteProject(project)"
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

    </div>
</template>

<script setup>
import { ref, nextTick, watch, onMounted, onBeforeUnmount } from 'vue'
import axios from 'axios'

const props = defineProps({
    initialProjects: { type: Array, default: () => [] },
    skills: { type: Array, default: () => [] },
})

const list = ref([...props.initialProjects])
watch(() => props.initialProjects, val => { list.value = [...val] })

function skillName(id) {
    return props.skills.find(s => s.id === id)?.name ?? id
}

function extractSkillIds(project) {
    return (project.skills ?? []).map(s => typeof s === 'object' ? s.id : s)
}

function extractErrors(err) {
    const data = err?.response?.data
    if (data?.errors) return data.errors
    if (data?.message) return { general: data.message }
    return { general: 'Something went wrong. Please try again.' }
}

// ── Toast ─────────────────────────────────────────────────
const toast = ref({ show: false, type: 'success', message: '' })
let toastTimer = null

function showToast(type, message) {
    clearTimeout(toastTimer)
    toast.value = { show: true, type, message }
    toastTimer = setTimeout(() => (toast.value.show = false), 4500)
}

// ── Outside click ─────────────────────────────────────────
const formDropdownRef = ref(null)
const formDropdownOpen = ref(false)
const editDropdownOpen = ref(null)
const editDropdownRefs = ref({})
let emits = defineEmits(['saved'])

function handleOutsideClick(e) {
    if (formDropdownRef.value && !formDropdownRef.value.contains(e.target)) {
        formDropdownOpen.value = false
    }
    if (editDropdownOpen.value !== null) {
        const el = editDropdownRefs.value[editDropdownOpen.value]
        if (el && !el.contains(e.target)) editDropdownOpen.value = null
    }
}

onMounted(() => document.addEventListener('mousedown', handleOutsideClick))
onBeforeUnmount(() => document.removeEventListener('mousedown', handleOutsideClick))

// ── Create ────────────────────────────────────────────────
const form = ref({ title: '', description: '', skill_ids: [], saving: false, errors: {} })

async function saveProject() {
    if (!form.value.title.trim()) return
    form.value.saving = true
    form.value.errors = {}
    try {
        const { data } = await axios.post('/project', {
            title: form.value.title.trim(),
            description: form.value.description.trim(),
            skill_ids: form.value.skill_ids,
        })
        emits('saved')
        showToast('success', `"${form.value.title}" was added successfully.`)
        form.value.title = ''
        form.value.description = ''
        form.value.skill_ids = []
    } catch (err) {
        form.value.errors = extractErrors(err)
        showToast('error', 'Failed to save project. Check the fields below.')
    } finally {
        form.value.saving = false
    }
}

// ── Edit ──────────────────────────────────────────────────
const editing = ref({ id: null, title: '', description: '', skill_ids: [], saving: false, errors: {} })
const editTitleInput = ref(null)

function startEdit(project) {
    editing.value = {
        id: project.id,
        title: project.title,
        description: project.description ?? '',
        skill_ids: extractSkillIds(project),
        saving: false,
        errors: {},
    }
    nextTick(() => editTitleInput.value?.focus())
}

function cancelEdit() {
    editing.value = { id: null, title: '', description: '', skill_ids: [], saving: false, errors: {} }
    editDropdownOpen.value = null
}

async function confirmEdit(project) {
    if (!editing.value.title.trim()) return
    editing.value.saving = true
    editing.value.errors = {}
    try {
        const { data } = await axios.put(`/project/${project.id}`, {
            title: editing.value.title.trim(),
            description: editing.value.description.trim(),
            skill_ids: editing.value.skill_ids,
        })
        const i = list.value.findIndex(p => p.id === project.id)
        if (i !== -1) list.value[i] = data
        cancelEdit()
        showToast('success', `"${editing.value.title}" was updated successfully.`)
        emits('saved')
    } catch (err) {
        editing.value.errors = extractErrors(err)
        showToast('error', 'Failed to update project. Check the fields.')
    } finally {
        editing.value.saving = false
    }
}

// ── Delete ────────────────────────────────────────────────
const deleting = ref(null)

async function deleteProject(project) {
    if (!confirm(`Delete "${project.title}"? This cannot be undone.`)) return
    deleting.value = project.id
    try {
        await axios.delete(`/project/${project.id}`)
        list.value = list.value.filter(p => p.id !== project.id)
        showToast('success', `"${project.title}" was deleted.`)
        emits('saved')
    } catch (err) {
        const errors = extractErrors(err)
        showToast('error', errors.general ?? 'Failed to delete project.')
    } finally {
        deleting.value = null
    }
}
</script>

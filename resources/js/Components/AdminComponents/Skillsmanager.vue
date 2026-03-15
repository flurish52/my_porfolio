<template>
    <div class="space-y-6">
        <!-- Toast Notification -->
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-if="toast.show"
                class="fixed top-5 right-5 z-50 flex items-start gap-3 px-4 py-3.5 rounded-xl shadow-lg border max-w-sm w-full"
                :class="toast.type === 'success'
                    ? 'bg-emerald-50 dark:bg-emerald-900/30 border-emerald-200 dark:border-emerald-700'
                    : 'bg-red-50 dark:bg-red-900/30 border-red-200 dark:border-red-700'"
            >
                <div
                    class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center mt-0.5"
                    :class="toast.type === 'success' ? 'bg-emerald-100 dark:bg-emerald-800' : 'bg-red-100 dark:bg-red-800'"
                >
                    <svg v-if="toast.type === 'success'" class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    <svg v-else class="w-3.5 h-3.5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold" :class="toast.type === 'success' ? 'text-emerald-800 dark:text-emerald-300' : 'text-red-800 dark:text-red-300'">
                        {{ toast.type === 'success' ? 'Success' : 'Error' }}
                    </p>
                    <p class="text-xs mt-0.5" :class="toast.type === 'success' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400'">
                        {{ toast.message }}
                    </p>
                </div>
                <button @click="toast.show = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </transition>
         <!-- Create Skill Form -->
        <div class="bg-white min-h-fit dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm ">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">New Skill</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Add a new skill and assign it to one or more categories</p>
            </div>

            <div class="px-5 py-4">
                <div class="flex flex-col sm:flex-row gap-3">

                    <!-- Skill Name -->
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                            Skill Name
                        </label>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="e.g. Vue.js, Photoshop…"
                            :disabled="form.saving"
                            @keydown.enter="saveSkill"
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition disabled:opacity-50 disabled:cursor-not-allowed"
                        />
                    </div>

                    <!-- Multi-category dropdown -->
                    <div class="sm:w-64">
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                            Categories
                            <span class="text-gray-400 font-normal">(select one or more)</span>
                        </label>
                        <div class="relative" ref="formDropdownRef">
                            <!-- Trigger -->
                            <button
                                type="button"
                                @click="formDropdownOpen = !formDropdownOpen"
                                :disabled="form.saving"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-left flex items-center justify-between gap-2 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span class="truncate" :class="form.category_ids.length ? 'text-gray-800 dark:text-gray-100' : 'text-gray-400 dark:text-gray-600'">
                                    {{ form.category_ids.length ? `${form.category_ids.length} selected` : 'Select categories…' }}
                                </span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform" :class="{ 'rotate-180': formDropdownOpen }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div
                                v-if="formDropdownOpen"
                                class="absolute z-20 mt-1.5 w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden"
                            >
                                <div class="max-h-48 overflow-y-auto py-1">
                                    <label
                                        v-for="cat in categories"
                                        :key="cat.id"
                                        class="flex items-center gap-2.5 px-3.5 py-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                                    >
                                        <input
                                            type="checkbox"
                                            :value="cat.id"
                                            v-model="form.category_ids"
                                            class="w-3.5 h-3.5 rounded border-gray-300 text-primary focus:ring-primary/30 cursor-pointer"
                                        />
                                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ cat.name }} bb</span>
                                    </label>
                                    <p v-if="!categories.length" class="px-3.5 py-2 text-xs text-gray-400">No categories available.</p>
                                </div>
                                <!-- Selected count footer -->
                                <div v-if="form.category_ids.length" class="border-t border-gray-100 dark:border-gray-800 px-3.5 py-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-400">{{ form.category_ids.length }} selected</span>
                                    <button type="button" @click="form.category_ids = []" class="text-xs text-red-400 hover:text-red-600 transition">Clear</button>
                                </div>
                            </div>
                        </div>

                        <!-- Selected badges preview -->
                        <div v-if="form.category_ids.length" class="flex flex-wrap gap-1.5 mt-2">
                            <span
                                v-for="id in form.category_ids"
                                :key="id"
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-primary/10 text-primary text-xs font-medium"
                            >
                                {{ categoryName(id) }}
                                <button type="button" @click="form.category_ids = form.category_ids.filter(i => i !== id)" class="hover:opacity-70 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex items-end">
                        <button
                            @click="saveSkill"
                            :disabled="form.saving || !form.name.trim() || !form.category_ids.length"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-primary text-white hover:opacity-90 active:scale-95 transition-all duration-150 disabled:opacity-40 disabled:cursor-not-allowed disabled:scale-100 shadow-sm"
                        >
                            <svg v-if="form.saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            {{ form.saving ? 'Saving…' : 'Save Skill' }}
                        </button>
                    </div>
                </div>

                <!-- Inline field errors -->
                <div v-if="form.errors && Object.keys(form.errors).length" class="mt-3 space-y-1">
                    <p v-for="(messages, field) in form.errors" :key="field" class="text-xs text-red-500">
                        <span class="font-medium capitalize">{{ field.replace('_', ' ') }}:</span>
                        {{ Array.isArray(messages) ? messages[0] : messages }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Skills Table -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Existing Skills</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                        {{ list.length }} {{ list.length === 1 ? 'skill' : 'skills' }} total
                    </p>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary/10 text-primary text-xs font-semibold">
                    {{ list.length }}
                </span>
            </div>

            <!-- Empty State -->
            <div v-if="list.length === 0" class="flex flex-col items-center justify-center py-14 px-6 text-center">
                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">No skills yet</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Create your first skill using the form above.</p>
            </div>

            <!-- Table -->
            <div v-else class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40">
                        <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3 w-14">#</th>
                        <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">Skill</th>
                        <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">Categories</th>
                        <th class="text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/80">
                    <tr
                        v-for="(skill, index) in list"
                        :key="skill.id"
                        class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors"
                        :class="{ 'bg-primary/5 dark:bg-primary/5': editing.id === skill.id }"
                    >
                        <!-- Index -->
                        <td class="px-5 py-3.5 text-xs font-medium text-gray-400 dark:text-gray-600 w-14 align-top pt-4">
                            {{ index + 1 }}
                        </td>

                        <!-- Skill Name -->
                        <td class="px-5 py-3.5 align-top pt-4">
                            <div v-if="editing.id === skill.id">
                                <input
                                    v-model="editing.name"
                                    type="text"
                                    @keydown.esc="cancelEdit"
                                    placeholder="Skill name"
                                    class="w-full px-3 py-1.5 text-sm rounded-lg border border-primary/50 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary/30 transition"
                                    ref="editNameInput"
                                />
                            </div>
                            <span v-else class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ skill.name }}
                                </span>
                        </td>

                        <!-- Categories -->
                        <td class="px-5 py-3.5 align-top pt-4">
                            <!-- Edit mode: inline multi-select dropdown -->
                            <div v-if="editing.id === skill.id" class="relative" :ref="el => editDropdownRefs[skill.id] = el">
                                <button
                                    type="button"
                                    @click="editDropdownOpen = editDropdownOpen === skill.id ? null : skill.id"
                                    class="w-full min-w-[160px] px-3 py-1.5 text-sm rounded-lg border border-primary/50 bg-white dark:bg-gray-800 text-left flex items-center justify-between gap-2 focus:outline-none focus:ring-2 focus:ring-primary/30 transition"
                                >
                                        <span :class="editing.category_ids.length ? 'text-gray-800 dark:text-gray-100' : 'text-gray-400'" class="text-sm truncate">
                                            {{ editing.category_ids.length ? `${editing.category_ids.length} selected` : 'Select…' }}
                                        </span>
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0 transition-transform" :class="{ 'rotate-180': editDropdownOpen === skill.id }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </button>

                                <div
                                    v-if="editDropdownOpen === skill.id"
                                    class="absolute z-20 mt-1.5 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden"
                                >
                                    <div class="max-h-44 overflow-y-auto py-1">
                                        <label
                                            v-for="cat in categories"
                                            :key="cat.id"
                                            class="flex items-center gap-2.5 px-3.5 py-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                                        >
                                            <input
                                                type="checkbox"
                                                :value="cat.id"
                                                v-model="editing.category_ids"
                                                class="w-3.5 h-3.5 rounded border-gray-300 text-primary focus:ring-primary/30 cursor-pointer"
                                            />
                                            <span class="text-sm text-gray-700 dark:text-gray-200">{{ cat.name }}</span>
                                        </label>
                                    </div>
                                    <div v-if="editing.category_ids.length" class="border-t border-gray-100 dark:border-gray-800 px-3.5 py-2 flex items-center justify-between">
                                        <span class="text-xs text-gray-400">{{ editing.category_ids.length }} selected</span>
                                        <button type="button" @click="editing.category_ids = []" class="text-xs text-red-400 hover:text-red-600 transition">Clear</button>
                                    </div>
                                </div>

                                <!-- Selected badges in edit mode -->
                                <div v-if="editing.category_ids.length" class="flex flex-wrap gap-1.5 mt-2">
                                        <span
                                            v-for="id in editing.category_ids"
                                            :key="id"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-primary/10 text-primary text-xs font-medium"
                                        >
                                            {{ categoryName(id) }}
                                            <button type="button" @click="editing.category_ids = editing.category_ids.filter(i => i !== id)" class="hover:opacity-70 transition">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </span>
                                </div>
                            </div>

                            <!-- Display mode: category badges -->
                            <div v-else class="flex flex-wrap gap-1.5">
                                    <span
                                        v-for="cat in skill.categories"
                                        :key="cat.id"
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg bg-secondary/10 text-secondary text-xs font-semibold"
                                    >
                                        {{ cat.name }}
                                    </span>
                                <span v-if="!skill.categories?.length" class="text-xs text-gray-400">—</span>
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-3.5 align-top pt-4">
                            <div class="flex items-center justify-end gap-2">

                                <!-- Editing mode -->
                                <template v-if="editing.id === skill.id">
                                    <div v-if="editing.errors && Object.keys(editing.errors).length" class="mr-2">
                                        <p v-for="(messages, field) in editing.errors" :key="field" class="text-xs text-red-500 whitespace-nowrap">
                                            {{ Array.isArray(messages) ? messages[0] : messages }}
                                        </p>
                                    </div>
                                    <button
                                        @click="confirmEdit(skill)"
                                        :disabled="editing.saving || !editing.name.trim() || !editing.category_ids.length"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary text-white hover:opacity-90 transition disabled:opacity-40"
                                    >
                                        <svg v-if="editing.saving" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                        </svg>
                                        <svg v-else class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                        </svg>
                                        {{ editing.saving ? 'Saving…' : 'Confirm' }}
                                    </button>
                                    <button
                                        @click="cancelEdit"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                                    >
                                        Cancel
                                    </button>
                                </template>

                                <!-- Default mode -->
                                <template v-else>
                                    <button
                                        @click="startEdit(skill)"
                                        :disabled="!!deleting"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-secondary border border-secondary/30 bg-secondary/5 hover:bg-secondary/10 transition disabled:opacity-40"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteSkill(skill)"
                                        :disabled="deleting === skill.id"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-red-500 border border-red-200 dark:border-red-500/20 bg-red-50 dark:bg-red-500/5 hover:bg-red-100 dark:hover:bg-red-500/10 transition disabled:opacity-40"
                                    >
                                        <svg v-if="deleting === skill.id" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                        </svg>
                                        <svg v-else class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                        {{ deleting === skill.id ? 'Deleting…' : 'Delete' }}
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
    initialSkills: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
})

// Local reactive list
const list = ref([...props.initialSkills])
watch(() => props.initialSkills, (val) => { list.value = [...val] })

// ── Helpers ───────────────────────────────────────────────
function categoryName(id) {
    return props.categories.find(c => c.id === id)?.name ?? id
}

// Extract IDs from a skill's categories array (handles both {id, name} objects and raw id values)
function extractCategoryIds(skill) {
    return (skill.categories ?? []).map(c => (typeof c === 'object' ? c.id : c))
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
    toastTimer = setTimeout(() => (toast.value.show = false), 4000)
}

// ── Dropdown: close on outside click ─────────────────────
const formDropdownRef = ref(null)
const formDropdownOpen = ref(false)
const editDropdownOpen = ref(null)   // holds the skill.id of the open edit dropdown, or null
const editDropdownRefs = ref({})

function handleOutsideClick(e) {
    if (formDropdownRef.value && !formDropdownRef.value.contains(e.target)) {
        formDropdownOpen.value = false
    }
    // Close edit dropdown if click is outside its container
    if (editDropdownOpen.value !== null) {
        const el = editDropdownRefs.value[editDropdownOpen.value]
        if (el && !el.contains(e.target)) {
            editDropdownOpen.value = null
        }
    }
}

onMounted(() => document.addEventListener('mousedown', handleOutsideClick))
onBeforeUnmount(() => document.removeEventListener('mousedown', handleOutsideClick))

// ── Create ────────────────────────────────────────────────
const form = ref({ name: '', category_ids: [], saving: false, errors: {} })
const emits = defineEmits(['saved'])

async function saveSkill() {
    if (!form.value.name.trim() || !form.value.category_ids.length) return

    form.value.saving = true
    form.value.errors = {}

    try {
        const { data } = await axios.post('/skill', {
            name: form.value.name.trim(),
            category_ids: form.value.category_ids,   // array of IDs only
        })

        form.value.name = ''
        emits('saved')
        form.value.category_ids = []
        showToast('success', `"${data.name}" was added successfully.`)
    } catch (err) {
        form.value.errors = extractErrors(err)
        showToast('error', 'Failed to save skill. Check the fields below.')
    } finally {
        form.value.saving = false
    }
}

// ── Edit ──────────────────────────────────────────────────
const editing = ref({ id: null, name: '', category_ids: [], saving: false, errors: {} })
const editNameInput = ref(null)

function startEdit(skill) {
    editing.value = {
        id: skill.id,
        name: skill.name,
        category_ids: extractCategoryIds(skill),
        saving: false,
        errors: {},
    }
    nextTick(() => editNameInput.value?.focus())
}

function cancelEdit() {
    editing.value = { id: null, name: '', category_ids: [], saving: false, errors: {} }
    editDropdownOpen.value = null
}

async function confirmEdit(skill) {
    if (!editing.value.name.trim() || !editing.value.category_ids.length) return

    editing.value.saving = true
    editing.value.errors = {}

    try {
        const { data } = await axios.put(`/skill/${skill.id}`, {
            name: editing.value.name.trim(),
            category_ids: editing.value.category_ids,   // array of IDs only
        })
        const i = list.value.findIndex(s => s.id === skill.id)
        if (i !== -1) list.value[i] = data
        emits('saved')
        cancelEdit()
        showToast('success', `"${data.name}" was updated successfully.`)
    } catch (err) {
        editing.value.errors = extractErrors(err)
        showToast('error', 'Failed to update skill. Check the fields.')
    } finally {
        editing.value.saving = false
    }
}

// ── Delete ────────────────────────────────────────────────
const deleting = ref(null)

async function deleteSkill(skill) {
    if (!confirm(`Delete "${skill.name}"? This cannot be undone.`)) return

    deleting.value = skill.id

    try {
        await axios.delete(`/skill/${skill.id}`)
        showToast('success', `"${skill.name}" was deleted.`)
        emits('saved')
    } catch (err) {
        const errors = extractErrors(err)
        showToast('error', errors.general ?? 'Failed to delete skill.')
    } finally {
        deleting.value = null
    }
}
</script>

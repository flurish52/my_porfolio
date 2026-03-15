<template>
    <div class="space-y-6">
        <!-- Create Category Form -->
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">New Category</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Add a new category to your collection</p>
            </div>

            <div class="px-5 py-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <label for="category-name"
                               class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1.5">
                            Category Name
                        </label>
                        <input
                            id="category-name"
                            v-model="form.name"
                            type="text"
                            placeholder="e.g. Electronics, Clothing…"
                            :disabled="form.saving"
                            @keydown.enter="saveCategory"
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition disabled:opacity-50 disabled:cursor-not-allowed"
                        />
                        <p v-if="form.error" class="mt-1.5 text-xs text-red-500">{{ form.error }}</p>
                    </div>

                    <div class="flex items-end">
                        <button
                            @click="saveCategory"
                            :disabled="form.saving || !form.name.trim()"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-primary text-white hover:opacity-90 active:scale-95 transition-all duration-150 disabled:opacity-40 disabled:cursor-not-allowed disabled:scale-100 shadow-sm"
                        >
                            <svg v-if="form.saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            {{ form.saving ? 'Saving…' : 'Save Category' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div
            class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Existing Categories</h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                        {{ list.length }} {{ list.length === 1 ? 'category' : 'categories' }} total
                    </p>
                </div>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary/10 text-primary text-xs font-semibold">
                    {{ list.length }}
                </span>
            </div>

            <!-- Empty State -->
            <div v-if="list.length === 0" class="flex flex-col items-center justify-center py-14 px-6 text-center">
                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">No categories yet</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Create your first category using the form
                    above.</p>
            </div>

            <!-- Table -->
            <div v-else class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40">
                        <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3 w-14">
                            #
                        </th>
                        <th class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">
                            Name
                        </th>
                        <th class="text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide px-5 py-3">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/80">
                    <tr
                        v-for="(category, index) in list"
                        :key="category.id"
                        class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors"
                    >
                        <!-- Index -->
                        <td class="px-5 py-3.5 text-xs font-medium text-gray-400 dark:text-gray-600 w-14">
                            {{ index + 1 }}
                        </td>

                        <!-- Name / inline edit -->
                        <td class="px-5 py-3.5">
                            <div v-if="editing.id === category.id">
                                <input
                                    v-model="editing.name"
                                    type="text"
                                    @keydown.enter="confirmEdit(category)"
                                    @keydown.esc="cancelEdit"
                                    class="w-full px-3 py-1.5 text-sm rounded-lg border border-primary/50 bg-primary/5 dark:bg-primary/10 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary/30 transition"
                                    ref="editInput"
                                />
                                <p v-if="editing.error" class="mt-1 text-xs text-red-500">{{ editing.error }}</p>
                            </div>
                            <span v-else class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ category.name }}
                                </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-end gap-2">

                                <!-- Editing mode -->
                                <template v-if="editing.id === category.id">
                                    <button
                                        @click="confirmEdit(category)"
                                        :disabled="editing.saving || !editing.name.trim()"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary text-white hover:opacity-90 transition disabled:opacity-40"
                                    >
                                        <svg v-if="editing.saving" class="w-3 h-3 animate-spin" fill="none"
                                             viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                        </svg>
                                        <svg v-else class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m4.5 12.75 6 6 9-13.5"/>
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
                                        @click="startEdit(category)"
                                        :disabled="!!deleting"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-secondary border border-secondary/30 bg-secondary/5 hover:bg-secondary/10 transition disabled:opacity-40"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteCategory(category)"
                                        :disabled="deleting === category.id"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-red-500 border border-red-200 dark:border-red-500/20 bg-red-50 dark:bg-red-500/5 hover:bg-red-100 dark:hover:bg-red-500/10 transition disabled:opacity-40"
                                    >
                                        <svg v-if="deleting === category.id" class="w-3 h-3 animate-spin" fill="none"
                                             viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                        </svg>
                                        <svg v-else class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                        {{ deleting === category.id ? 'Deleting…' : 'Delete' }}
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
import {ref, nextTick, onMounted, watch} from 'vue'
import axios from 'axios'

const props = defineProps({
    initialCategories: {
        type: Array,
        default: () => [
            {id: ' ', name: ' '},
            {id: ' ', name: ' '},
            {id: ' ', name: ' '},
        ],
    },
})

// Local reactive copy — component owns its list from here on
const list = ref([...props.initialCategories])

watch(
    () => props.initialCategories,
    (newValue) => {
        list.value = [...newValue]
    }
)


// ── Create ────────────────────────────────────────────────
const form = ref({name: '', saving: false, error: '', success: ''})

let emits = defineEmits(['saved'])

async function saveCategory() {
    if (!form.value.name.trim()) return

    form.value.saving = true
    form.value.error = ''
    form.value.success = ''

    try {
        const {data} = await axios.post('/categories', {
            name: form.value.name.trim(),
        })
        list.value.push(data)
        form.value.success = data.message
        form.value.name = ''
        emits('saved')
    } catch (err) {
        form.value.error =
            err?.response?.data?.message ?? 'Failed to save. Please try again.'
    } finally {
        form.value.saving = false
    }
}

// ── Edit ──────────────────────────────────────────────────
const editing = ref({id: null, name: '', saving: false, error: ''})
const editInput = ref(null)

function startEdit(category) {
    editing.value = {id: category.id, name: category.name, saving: false, error: ''}
    nextTick(() => editInput.value?.focus())
}

function cancelEdit() {
    editing.value = {id: null, name: '', saving: false, error: ''}
}

async function confirmEdit(category) {
    if (!editing.value.name.trim()) return

    editing.value.saving = true
    editing.value.error = ''

    try {
        const {data} = await axios.put(`/categories/${category.id}`, {
            name: editing.value.name.trim(),
        })
        emits('saved')
        cancelEdit()

    } catch (err) {
        editing.value.error =
            err?.response?.data?.message ?? 'Failed to update. Please try again.'
    } finally {
        editing.value.saving = false
    }
}

// ── Delete ────────────────────────────────────────────────
const deleting = ref(null)

async function deleteCategory(category) {
    if (!confirm(`Delete "${category.name}"? This cannot be undone.`)) return

    deleting.value = category.id

    try {
        await axios.delete(`/categories/${category.id}`)
        emits('saved')
    } catch (err) {
        console.error(err?.response?.data?.message ?? 'Failed to delete.')
    } finally {
        deleting.value = null
    }
}
</script>

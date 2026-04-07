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
                :class="toast.type === 'success' ? 'bg-[#f0fdf4] border-[#bbf7d0]' : 'bg-[#fff5f5] border-[#fecaca]'"
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
        <ProjectForm
            :form="form"
            :skills="skills"
            @save="saveProject(emit.bind(null, 'saved'))"
        />

        <!-- ── Table ──────────────────────────────────────────── -->
        <ProjectTable
            :list="list"
            :editing="editing"
            :deleting="deleting"
            :skills="skills"
            @start-edit="startEdit"
            @cancel-edit="cancelEdit"
            @confirm-edit="project => confirmEdit(project, emit.bind(null, 'saved'))"
            @delete="project => deleteProject(project, emit.bind(null, 'saved'))"
        />
    </div>
</template>

<script setup>
import { toRef } from 'vue'
import { useProjects } from '../composables/useProjects.js'
import ProjectForm  from './ProjectForm.vue'
import ProjectTable from './ProjectTable.vue'

const props = defineProps({
    initialProjects: { type: Array, default: () => [] },
    skills:          { type: Array, default: () => [] },
})

const emit = defineEmits(['saved'])

const {
    list,
    toast,
    form,    saveProject,
    editing, startEdit, cancelEdit, confirmEdit,
    deleting, deleteProject,
} = useProjects(toRef(props, 'initialProjects'))
</script>

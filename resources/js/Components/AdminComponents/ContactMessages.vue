<template>
    <div class="w-full">

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <p class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35">
                // inbox
            </p>
            <p class="text-sm text-primary/40">
                {{ contactMessages.length }} message{{ contactMessages.length !== 1 ? 's' : '' }} received
            </p>
        </div>

        <!-- Desktop Table — horizontally scrollable -->
        <div class="hidden md:block rounded-xl overflow-hidden border border-primary/10 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[700px]">
                    <thead>
                    <tr class="bg-primary text-tertiary">
                        <th class="text-left px-4 py-3.5 font-mono text-[0.6rem] tracking-[0.15em] uppercase font-semibold w-10">#</th>
                        <th class="text-left px-4 py-3.5 font-mono text-[0.6rem] tracking-[0.15em] uppercase font-semibold">Sender</th>
                        <th class="text-left px-4 py-3.5 font-mono text-[0.6rem] tracking-[0.15em] uppercase font-semibold">Email</th>
                        <th class="text-left px-4 py-3.5 font-mono text-[0.6rem] tracking-[0.15em] uppercase font-semibold">Message</th>
                        <th class="text-left px-4 py-3.5 font-mono text-[0.6rem] tracking-[0.15em] uppercase font-semibold whitespace-nowrap">Date</th>
                        <th class="text-center px-4 py-3.5 font-mono text-[0.6rem] tracking-[0.15em] uppercase font-semibold">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="(msg, i) in contactMessages"
                        :key="msg.id"
                        class="border-t border-primary/6 transition-colors duration-150 cursor-pointer"
                        :class="[
                                i % 2 === 0 ? 'bg-surface' : 'bg-primary/[0.02]',
                                hoveredRow === msg.id ? '!bg-primary/[0.05]' : ''
                            ]"
                        @mouseenter="hoveredRow = msg.id"
                        @mouseleave="hoveredRow = null"
                        @click="openMessage(msg)"
                    >
                        <td class="px-4 py-3.5 font-mono text-[0.65rem] text-primary/30">{{ i + 1 }}</td>

                        <td class="px-4 py-3.5" @click.stop>
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                        <span class="font-mono text-[0.55rem] font-bold text-primary/60">
                                            {{ initials(msg.contact_user_name) }}
                                        </span>
                                </div>
                                <span class="font-medium text-primary text-[0.8rem] leading-tight whitespace-nowrap">
                                        {{ msg.contact_user_name }}
                                    </span>
                            </div>
                        </td>

                        <td class="px-4 py-3.5" @click.stop>
                            <a :href="`mailto:${msg.contact_user_email}`"
                               class="text-[0.78rem] text-primary/55 hover:text-primary transition-colors duration-150 font-mono whitespace-nowrap">
                                {{ msg.contact_user_email }}
                            </a>
                        </td>

                        <td class="px-4 py-3.5 max-w-[240px]">
                            <p class="text-[0.78rem] text-primary/60 leading-relaxed line-clamp-2">
                                {{ msg.contact_user_message }}
                            </p>
                        </td>

                        <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="font-mono text-[0.65rem] text-primary/40">
                                    {{ formatDate(msg.created_at) }}
                                </span>
                        </td>

                        <td class="px-4 py-3.5" @click.stop>
                            <div class="flex items-center justify-center gap-2">
                                <!-- View -->
                                <button
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                               bg-primary/8 text-primary/70 hover:bg-primary hover:text-tertiary
                                               transition-all duration-200 text-[0.7rem] font-medium"
                                    title="View full message"
                                    @click="openMessage(msg)"
                                >
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </button>

                                <!-- Delete -->
                                <button
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                               bg-red-50 text-red-400 hover:bg-red-500 hover:text-white
                                               transition-all duration-200 text-[0.7rem] font-medium"
                                    title="Delete"
                                    @click="confirmDelete(msg)"
                                >
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="contactMessages.length === 0">
                        <td colspan="6" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-8 h-8 text-primary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="font-mono text-[0.7rem] text-primary/30 tracking-wider uppercase">No messages yet</p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-3">
            <div v-if="contactMessages.length === 0" class="text-center py-12">
                <p class="font-mono text-[0.7rem] text-primary/30 tracking-wider uppercase">No messages yet</p>
            </div>

            <div
                v-for="msg in contactMessages"
                :key="msg.id"
                class="rounded-xl border border-primary/10 overflow-hidden bg-surface shadow-sm"
            >
                <div class="bg-primary text-tertiary px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-surface/20 flex items-center justify-center flex-shrink-0">
                            <span class="font-mono text-[0.55rem] font-bold text-surface">{{ initials(msg.contact_user_name) }}</span>
                        </div>
                        <div>
                            <p class="text-surface text-[0.8rem] font-semibold leading-tight">{{ msg.contact_user_name }}</p>
                            <p class="text-surface/60 font-mono text-[0.6rem]">{{ msg.contact_user_email }}</p>
                        </div>
                    </div>
                    <span class="font-mono text-[0.58rem] text-surface/50">{{ formatDate(msg.created_at) }}</span>
                </div>

                <div class="px-4 py-3">
                    <p class="text-[0.82rem] text-primary/60 leading-relaxed line-clamp-3">{{ msg.contact_user_message }}</p>
                </div>

                <div class="px-4 pb-3 flex gap-2">
                    <button
                        class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg
                               bg-primary/8 text-primary/70 hover:bg-primary hover:text-tertiary
                               transition-all duration-200 text-[0.72rem] font-medium"
                        @click="openMessage(msg)"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View
                    </button>
                    <button
                        class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg
                               bg-red-50 text-red-400 hover:bg-red-500 hover:text-white
                               transition-all duration-200 text-[0.72rem] font-medium"
                        @click="confirmDelete(msg)"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════
             VIEW MESSAGE MODAL
        ══════════════════════════════════ -->
        <Transition
            enter-active-class="transition-all duration-200 ease-out"
            enter-from-class="opacity-0"
            leave-active-class="transition-all duration-150 ease-in"
            leave-to-class="opacity-0"
        >
            <div
                v-if="viewTarget"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/35 backdrop-blur-sm"
                @click.self="viewTarget = null"
            >
                <Transition
                    enter-active-class="transition-all duration-200 ease-out"
                    enter-from-class="opacity-0 scale-95 translate-y-2"
                    leave-active-class="transition-all duration-150 ease-in"
                    leave-to-class="opacity-0 scale-95 translate-y-2"
                >
                    <div v-if="viewTarget" class="bg-surface rounded-2xl border border-primary/10 shadow-2xl w-full max-w-lg flex flex-col overflow-hidden">

                        <!-- Modal header -->
                        <div class="bg-primary px-5 py-4 flex items-center justify-between flex-shrink-0">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-surface/20 flex items-center justify-center flex-shrink-0">
                                    <span class="font-mono text-[0.6rem] font-bold text-surface">
                                        {{ initials(viewTarget.contact_user_name) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-tertiary font-semibold text-sm leading-tight">{{ viewTarget.contact_user_name }}</p>
                                    <p class="text-tertiary/60 font-mono text-[0.62rem]">{{ viewTarget.contact_user_email }}</p>
                                </div>
                            </div>
                            <!-- Close -->
                            <button
                                class="w-7 h-7 rounded-lg bg-surface/15 hover:bg-surface/25 flex items-center justify-center
                                       text-tertiary/70 hover:text-tertiary transition-all duration-150"
                                @click="viewTarget = null"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Date strip -->
                        <div class="px-5 py-2 border-b border-primary/6 flex items-center justify-between bg-primary/[0.02]">
                            <span class="font-mono text-[0.6rem] tracking-[0.12em] uppercase text-primary/30">Received</span>
                            <span class="font-mono text-[0.62rem] text-primary/45">{{ formatDate(viewTarget.created_at) }}</span>
                        </div>

                        <!-- Message body — scrollable -->
                        <div class="px-5 py-4 overflow-y-auto flex-1" style="max-height: 55vh">
                            <p class="text-[0.88rem] text-primary/70 leading-[1.9] whitespace-pre-wrap">{{ viewTarget.contact_user_message }}</p>
                        </div>

                        <!-- Modal actions -->
                        <div class="px-5 py-4 border-t border-primary/8 flex gap-2.5 flex-shrink-0">
                            <!-- Reply -->

                           <a :href="`mailto:${viewTarget.contact_user_email}?subject=Re: Your message`"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg
                            bg-primary text-tertiary hover:opacity-85
                            transition-all duration-200 text-[0.78rem] font-medium"
                            >
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                            Reply
                            </a>

                            <!-- Delete -->
                            <button
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg
                                       bg-red-50 text-red-400 hover:bg-red-500 hover:text-white
                                       transition-all duration-200 text-[0.78rem] font-medium"
                                @click="confirmDeleteFromView"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>

                            <!-- Close -->
                            <button
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg
                                       border border-primary/15 text-primary/60 hover:bg-primary/5
                                       transition-all duration-200 text-[0.78rem] font-medium"
                                @click="viewTarget = null"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>

        <!-- ══════════════════════════════════
             DELETE CONFIRM MODAL
        ══════════════════════════════════ -->
        <Transition
            enter-active-class="transition-all duration-200 ease-out"
            enter-from-class="opacity-0"
            leave-active-class="transition-all duration-150 ease-in"
            leave-to-class="opacity-0"
        >
            <div
                v-if="deleteTarget"
                class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
                @click.self="deleteTarget = null"
            >
                <Transition
                    enter-active-class="transition-all duration-200 ease-out"
                    enter-from-class="opacity-0 scale-95"
                    leave-active-class="transition-all duration-150 ease-in"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div v-if="deleteTarget" class="bg-primary text-tertiary rounded-2xl border border-primary/10 shadow-xl p-6 max-w-sm w-full">
                        <div class="flex items-center gap-3 mb-4 text-tertiary ">
                            <div class="w-9 h-9 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-display font-bold text-tertiary text-sm">Delete message?</h3>
                                <p class="text-tertiary  text-[0.75rem]">From {{ deleteTarget.contact_user_name }}</p>
                            </div>
                        </div>
                        <p class="text-[0.8rem] text-primary/55 mb-5 leading-relaxed text-tertiary ">
                            This will permanently remove this message. This action cannot be undone.
                        </p>
                        <div class="flex gap-2">
                            <button
                                class="flex-1 px-4 py-2 rounded-lg border border-tertiary/15 text-tertiary
                                       hover:bg-primary/5 transition-colors duration-150 text-sm font-medium"
                                @click="deleteTarget = null"
                            >Cancel</button>
                            <button
                                class="flex-1 px-4 py-2 rounded-lg bg-red-500 text-white
                                       hover:bg-red-600 transition-colors duration-150 text-sm font-medium"
                                @click="deleteMessage"
                            >Delete</button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import {nextTick, ref} from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    contactMessages: { type: Array, default: () => [] },
})

const hoveredRow   = ref(null)
const viewTarget   = ref(null)
const deleteTarget = ref(null)

function initials(name = '') {
    return name.split(' ').map(w => w[0]?.toUpperCase()).slice(0, 2).join('')
}

function formatDate(dateStr) {
    if (!dateStr) return '—'
    return new Date(dateStr).toLocaleDateString('en-GB', {
        day: '2-digit', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    })
}

function openMessage(msg) {
    viewTarget.value = msg
}

function confirmDelete(msg) {
    deleteTarget.value = msg
}

// Called from inside the view modal — close view then show delete confirm
function confirmDeleteFromView() {
    const msg = viewTarget.value
    viewTarget.value = null
    setTimeout(() => { deleteTarget.value = msg }, 160)
}

function deleteMessage() {
    if (!deleteTarget.value) return

    const scrollY = window.scrollY

    router.delete(route('contact.destroy', deleteTarget.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteTarget.value = null
        },
        onFinish: () => {
            deleteTarget.value = null
            nextTick(() => window.scrollTo({ top: scrollY, behavior: 'instant' }))
        },
    })
}
</script>

<template>
    <button
        class="flex items-center gap-2 text-red-500 hover:text-red-600
               hover:bg-red-50 px-3 py-1.5 rounded-lg
               transition-all duration-200 text-sm font-medium group"
        @click="logout"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-0.5"
        >
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18 12H9m0 0l3-3m-3 3l3 3"/>
        </svg>
        Logout
    </button>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

function logout() {
    router.post(route('logout'))
}
</script>

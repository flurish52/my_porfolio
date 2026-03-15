<template>
    <div class="side-nav-header group">
        <!-- App Logo + Name -->
        <div class="flex items-center gap-3 px-4 py-5">
            <div class="logo-mark bg-primary  flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0
                          0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0
                          0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09
                           3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                </svg>
            </div>

            <div class="min-w-0 ">
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate leading-tight">
                    {{ appName }}
                </p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate leading-tight mt-0.5">
                    {{ appTagline }}
                </p>
            </div>
        </div>

        <!-- Divider -->
        <div class="mx-4 border-t border-gray-100 dark:border-gray-800"></div>

        <!-- Admin User Block -->
        <div class="px-3 pt-4 pb-2">
            <button
                @click="$emit('profile-click')"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-all duration-150 text-left group/btn"
            >
                <!-- Avatar -->
                <div class="relative flex-shrink-0">
                    <img
                        v-if="user.avatar"
                        :src="user.avatar"
                        :alt="user.name"
                        class="w-8 h-8 rounded-full object-cover ring-2 ring-white dark:ring-gray-900 shadow"
                    />
                    <div
                        v-else
                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shadow avatar-fallback"
                    >
                        {{ initials }}
                    </div>
                    <!-- Online indicator -->
                    <span
                        class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full border-2 border-white dark:border-gray-900"
                        :class="statusColor"
                    ></span>
                </div>

                <!-- User info -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate leading-tight">
                        {{ user.name }}
                    </p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate leading-tight mt-0.5">
                        {{ user.role }}
                    </p>
                </div>

                <!-- Chevron -->
                <svg
                    class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 group-hover/btn:text-gray-500 dark:group-hover/btn:text-gray-400 flex-shrink-0 transition-colors"
                    fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    appName: {
        type: String,
        default: 'AdminPanel',
    },
    appTagline: {
        type: String,
        default: 'Portfolio setup',
    },
    user: {
        type: Object,
        default: () => ({
            name: 'Alex Johnson',
            role: 'Super Admin',
            avatar: null,
            status: 'online', // 'online' | 'away' | 'offline'
        }),
    },
})

defineEmits(['profile-click'])

const initials = computed(() => {
    return props.user.name
        .split(' ')
        .map(n => n[0])
        .slice(0, 2)
        .join('')
        .toUpperCase()
})

const statusColor = computed(() => ({
    'bg-emerald-400': props.user.status === 'online',
    'bg-amber-400':   props.user.status === 'away',
    'bg-gray-300':    props.user.status === 'offline',
}))
</script>

<style scoped>
.logo-mark {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

.avatar-fallback {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}
</style>

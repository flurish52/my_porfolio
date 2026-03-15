<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="morph-wrapper">
            <div class="morph-card">

                <!-- Greeting -->
                <div class="morph-header">
                    <h1 class="morph-title">Welcome back</h1>
                    <p class="morph-subtitle">Sign in to continue</p>
                </div>

                <!-- Status -->
                <div v-if="status" class="morph-status">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="morph-form">

                    <!-- Email -->
                    <div class="morph-field">
                        <InputLabel for="email" value="Email" class="morph-label" />
                        <div class="morph-input-wrap">
                            <span class="morph-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </span>
                            <TextInput
                                id="email"
                                type="email"
                                class="morph-input"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />
                        </div>
                        <InputError class="morph-error" :message="form.errors.email" />
                    </div>

                    <!-- Password -->
                    <div class="morph-field">
                        <InputLabel for="password" value="Password" class="morph-label" />
                        <div class="morph-input-wrap">
                            <span class="morph-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <TextInput
                                id="password"
                                type="password"
                                class="morph-input"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                        </div>
                        <InputError class="morph-error" :message="form.errors.password" />
                    </div>

                    <!-- Remember me -->
                    <div class="morph-remember">
                        <label class="morph-check-label">
                            <div class="morph-checkbox-wrap">
                                <Checkbox name="remember" v-model:checked="form.remember" class="morph-checkbox" />
                            </div>
                            <span class="morph-check-text">Remember me</span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="morph-actions">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="morph-forgot"
                        >
                            Forgot password?
                        </Link>

                        <PrimaryButton
                            class="morph-btn"
                            :class="{ 'morph-btn--loading': form.processing }"
                            :disabled="form.processing"
                        >
                            <span v-if="!form.processing">Sign in</span>
                            <span v-else class="morph-spinner"></span>
                        </PrimaryButton>
                    </div>

                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
/* ─── Tokens ─────────────────────────────────────────── */
:root,
.morph-wrapper {
    --bg:       #e0e5ec;
    --surface:  #e0e5ec;
    --shadow-l: #ffffff;
    --shadow-d: #a3b1c6;
    --accent:   #5b8dee;
    --accent-d: #3a6fd8;
    --text:     #4a5568;
    --text-lt:  #8898aa;
    --error:    #e53e3e;
    --success:  #38a169;
    --radius:   16px;
    --radius-sm: 10px;
    --font: 'DM Sans', 'Nunito', system-ui, sans-serif;
}

/* ─── Layout ─────────────────────────────────────────── */
.morph-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg);
    font-family: var(--font);
    padding: 2rem;
}

.morph-card {
    width: 100%;
    max-width: 420px;
    background: var(--surface);
    border-radius: 28px;
    padding: 2.5rem 2.25rem;
    box-shadow:
        8px 8px 20px var(--shadow-d),
        -8px -8px 20px var(--shadow-l);
}

/* ─── Header ─────────────────────────────────────────── */
.morph-header {
    margin-bottom: 2rem;
    text-align: center;
}

.morph-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.5px;
    margin: 0 0 0.25rem;
}

.morph-subtitle {
    font-size: 0.875rem;
    color: var(--text-lt);
    margin: 0;
}

/* ─── Status ─────────────────────────────────────────── */
.morph-status {
    margin-bottom: 1.25rem;
    padding: 0.75rem 1rem;
    border-radius: var(--radius-sm);
    background: var(--surface);
    box-shadow:
        inset 3px 3px 7px var(--shadow-d),
        inset -3px -3px 7px var(--shadow-l);
    font-size: 0.875rem;
    color: var(--success);
    font-weight: 500;
    text-align: center;
}

/* ─── Form ───────────────────────────────────────────── */
.morph-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.morph-field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.morph-label {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--text-lt);
}

/* ─── Input ──────────────────────────────────────────── */
.morph-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    border-radius: var(--radius-sm);
    background: var(--surface);
    box-shadow:
        inset 4px 4px 9px var(--shadow-d),
        inset -4px -4px 9px var(--shadow-l);
    transition: box-shadow 0.2s ease;
}

.morph-input-wrap:focus-within {
    box-shadow:
        inset 4px 4px 9px var(--shadow-d),
        inset -4px -4px 9px var(--shadow-l),
        0 0 0 2px var(--accent);
}

.morph-icon {
    position: absolute;
    left: 0.875rem;
    color: var(--text-lt);
    display: flex;
    align-items: center;
    pointer-events: none;
}

/* Override TextInput styles to blend in */
.morph-input-wrap :deep(input),
.morph-input {
    width: 100% !important;
    border: none !important;
    outline: none !important;
    background: transparent !important;
    padding: 0.8rem 1rem 0.8rem 2.75rem !important;
    font-size: 0.9375rem !important;
    color: var(--text) !important;
    font-family: var(--font) !important;
    border-radius: var(--radius-sm) !important;
    box-shadow: none !important;
    ring: none !important;
}

.morph-input-wrap :deep(input:focus) {
    box-shadow: none !important;
    outline: none !important;
    border: none !important;
    ring: none !important;
}

/* ─── Error ──────────────────────────────────────────── */
.morph-error {
    font-size: 0.8rem;
    color: var(--error);
    padding-left: 0.25rem;
}

/* ─── Remember ───────────────────────────────────────── */
.morph-remember {
    margin-top: -0.25rem;
}

.morph-check-label {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    cursor: pointer;
    user-select: none;
}

.morph-checkbox-wrap {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    background: var(--surface);
    box-shadow:
        3px 3px 7px var(--shadow-d),
        -3px -3px 7px var(--shadow-l);
    display: flex;
    align-items: center;
    justify-content: center;
}

.morph-checkbox-wrap :deep(input[type="checkbox"]) {
    width: 14px;
    height: 14px;
    cursor: pointer;
    accent-color: var(--accent);
}

.morph-check-text {
    font-size: 0.875rem;
    color: var(--text-lt);
    font-weight: 500;
}

/* ─── Actions ────────────────────────────────────────── */
.morph-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 0.5rem;
    gap: 1rem;
}

.morph-forgot {
    font-size: 0.8125rem;
    color: var(--text-lt);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
    white-space: nowrap;
}

.morph-forgot:hover {
    color: var(--accent);
}

/* ─── Button ─────────────────────────────────────────── */
.morph-actions :deep(.morph-btn),
.morph-btn {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.5rem !important;
    padding: 0.7rem 1.75rem !important;
    background: var(--accent) !important;
    color: #fff !important;
    font-size: 0.9375rem !important;
    font-weight: 600 !important;
    font-family: var(--font) !important;
    border: none !important;
    border-radius: var(--radius-sm) !important;
    cursor: pointer !important;
    letter-spacing: 0.01em !important;
    transition: all 0.18s ease !important;
    box-shadow:
        5px 5px 12px color-mix(in srgb, var(--accent) 40%, var(--shadow-d)),
        -3px -3px 8px var(--shadow-l) !important;
}

.morph-actions :deep(.morph-btn:hover),
.morph-btn:hover {
    background: var(--accent-d) !important;
    box-shadow:
        3px 3px 8px color-mix(in srgb, var(--accent-d) 50%, var(--shadow-d)),
        -2px -2px 6px var(--shadow-l) !important;
    transform: translateY(-1px) !important;
}

.morph-actions :deep(.morph-btn:active),
.morph-btn:active {
    box-shadow:
        inset 2px 2px 6px color-mix(in srgb, var(--accent-d) 60%, #000),
        inset -2px -2px 4px color-mix(in srgb, var(--accent) 30%, #fff) !important;
    transform: translateY(0) !important;
}

.morph-btn--loading {
    opacity: 0.7 !important;
    cursor: not-allowed !important;
    pointer-events: none !important;
}

/* ─── Spinner ────────────────────────────────────────── */
.morph-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,0.35);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ─── Dark mode support ──────────────────────────────── */
@media (prefers-color-scheme: dark) {
    .morph-wrapper {
        --bg:       #1e2230;
        --surface:  #1e2230;
        --shadow-l: #262d42;
        --shadow-d: #161b28;
        --text:     #c8d0e7;
        --text-lt:  #6b7a99;
        --accent:   #5b8dee;
        --accent-d: #3a6fd8;
    }
}
</style>

<template>
    <PublicLayout
        :name="profile.username"
        :tagline="profile.nav_description || undefined"
        @navigate="scrollToSection"
    >
        <!-- Search + social previews. Copy comes from the DB (seo_title / seo_description) once those fields exist. -->
        <Head>
            <title>{{ seoTitle }}</title>
            <meta head-key="description" name="description" :content="seoDescription" />
            <meta head-key="og:type" property="og:type" content="website" />
            <meta head-key="og:title" property="og:title" :content="seoTitle" />
            <meta head-key="og:description" property="og:description" :content="seoDescription" />
            <link v-if="canonical" head-key="canonical" rel="canonical" :href="canonical" />
            <meta v-if="ogImage" head-key="og:image" property="og:image" :content="ogImage" />
        </Head>

        <TopNav
            :name="profile.username"
            :links="navLinks"
            :active-section="activeSection"
            @navigate="scrollToSection"
        />

        <main id="main">
            <LandingSection :profileProp="profileProp" :skillsProp="skillsProp" />

            <!-- Work comes right after the hero: proof first -->
            <Projects :projectsProp="projectsProp" />


            <About :profileProp="profileProp" :statsProp="statsProp" />

            <Skills :categories="categoryProp" />

            <Servicessection :services="services" />
            <!-- ══════════ Contact ══════════ -->
            <section id="contact" class="bg-surface py-20 md:py-28">
                <div class="mx-auto grid max-w-6xl gap-12 px-5 md:px-8 lg:grid-cols-5 lg:gap-16">
                    <div class="lg:col-span-2">
                        <h2 class="text-3xl font-extrabold tracking-tight text-secondary md:text-4xl">
                            Tell me what you're building.
                        </h2>
                        <p class="mt-4 max-w-md leading-relaxed text-secondary-muted">
                            Every message is read by me, not a team. You'll get an honest answer
                            within 24 hours, even if the answer is that I'm not the right fit.
                        </p>
                    </div>

                    <div class="lg:col-span-3">
                        <form
                            class="flex flex-col gap-5 rounded-2xl border border-line bg-canvas p-6 shadow-card md:p-8"
                            novalidate
                            :aria-busy="loading"
                            @submit.prevent="handleSubmit"
                        >
                            <p
                                v-if="success"
                                role="status"
                                class="rounded-lg bg-primary-soft px-4 py-3 text-sm font-medium text-primary-dark"
                            >
                                {{ successMessage }}
                            </p>
                            <p
                                v-if="errorMessage"
                                role="alert"
                                class="rounded-lg bg-red-50 px-4 py-3 text-sm font-medium text-red-700"
                            >
                                {{ errorMessage }}
                            </p>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="flex flex-col gap-2">
                                    <label for="cf-name" class="text-sm font-semibold text-secondary">Your name</label>
                                    <input
                                        id="cf-name"
                                        v-model="form.name"
                                        name="name"
                                        type="text"
                                        autocomplete="name"
                                        placeholder="Jane Doe"
                                        class="rounded-lg border border-line bg-surface px-4 py-3 text-sm text-secondary placeholder:text-secondary-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                    />
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="cf-email" class="text-sm font-semibold text-secondary">Email</label>
                                    <input
                                        id="cf-email"
                                        v-model="form.email"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        placeholder="you@example.com"
                                        class="rounded-lg border border-line bg-surface px-4 py-3 text-sm text-secondary placeholder:text-secondary-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                    />
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="cf-message" class="text-sm font-semibold text-secondary">About your project</label>
                                <textarea
                                    id="cf-message"
                                    v-model="form.message"
                                    name="message"
                                    rows="5"
                                    placeholder="What do you need, and by when?"
                                    class="resize-y rounded-lg border border-line bg-surface px-4 py-3 text-sm text-secondary placeholder:text-secondary-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                />
                            </div>

                            <button
                                type="submit"
                                :disabled="loading"
                                class="self-start rounded-lg bg-primary px-7 py-3 text-sm font-semibold text-surface transition-colors duration-200 hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {{ loading ? 'Sending…' : 'Send message' }}
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </PublicLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted, onBeforeUnmount } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import TopNav from '@/Components/TopNav.vue'
import Skills from '@/Components/WelcomeSections/Skills.vue'
import About from '@/Components/WelcomeSections/About.vue'
import Projects from '@/Components/WelcomeSections/Projects.vue'
import LandingSection from '@/Components/WelcomeSections/LandingSection.vue'
import Servicessection from '@/Components/WelcomeSections/Servicessection.vue'

// ── Props from backend (Laravel passes these) ──────────────────────────────
const props = defineProps({
    profileProp: { type: Object, default: null },
    statsProp: { type: [Object, Array], default: null },
    projectsProp: { type: [Object, Array], default: null },
    categoryProp: { type: [Object, Array], default: null },
    skillsProp: { type: [Object, Array], default: null },
    linksProp: { type: Array, default: null },
    services: { type: [Object, Array], default: () => [] },
})

// ── Profile (reactive; refreshed from /profile/settings) ───────────────────
const profile = reactive(
    props.profileProp || {
        picture: '',
        username: 'Ashobel',
        nav_description: '',
    }
)

// ── SEO ────────────────────────────────────────────────────────────────────
const seoTitle = computed(
    () => profile.seo_title || `${profile.username} | Full-Stack Web Developer`
)
const seoDescription = computed(
    () =>
        profile.seo_description ||
        `${profile.username} is a full-stack web developer building fast, reliable websites and business software for small and medium businesses.`
)
// Browser-only values, so they are skipped safely if you enable Inertia SSR later
const canonical = typeof window !== 'undefined' ? `${window.location.origin}/` : ''
const ogImage = computed(() =>
    typeof window !== 'undefined' && profile.picture
        ? `${window.location.origin}/storage/${profile.picture}`
        : ''
)

// ── Nav links (same order as the page) ─────────────────────────────────────
const navLinks = ref(
    props.linksProp || [
        { id: 'home', label: 'Home', icon: null },
        { id: 'projects', label: 'Work', icon: null },
        { id: 'services', label: 'Services', icon: null },
        { id: 'about', label: 'About', icon: null },
        { id: 'skills', label: 'Skills', icon: null },
        { id: 'contact', label: 'Contact', icon: null },
    ]
)

// ── Scroll-spy ─────────────────────────────────────────────────────────────
const activeSection = ref('home')

// ── Contact form ───────────────────────────────────────────────────────────
const form = reactive({ name: '', email: '', message: '' })
const loading = ref(false)
const success = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

function handleSubmit() {
    success.value = false
    errorMessage.value = ''
    successMessage.value = ''
    loading.value = true

    axios
        .post('/contact-me', {
            contact_user_name: form.name,
            contact_user_email: form.email,
            contact_user_message: form.message,
        })
        .then((response) => {
            success.value = true
            successMessage.value = response.data.message
            Object.assign(form, { name: '', email: '', message: '' })
        })
        .catch((error) => {
            errorMessage.value =
                error.response?.data?.message || 'Something went wrong. Please try again.'
            console.error(error)
        })
        .finally(() => {
            loading.value = false
        })
}

// ── Scroll to section (offset for the sticky nav) ──────────────────────────
const NAV_OFFSET = 72

function scrollToSection(id) {
    const el = document.getElementById(id)
    if (!el) return
    const top = el.getBoundingClientRect().top + window.scrollY - (id === 'home' ? 0 : NAV_OFFSET)
    window.scrollTo({ top, behavior: 'smooth' })
}

function getProfileSettings() {
    axios.get('/profile/settings').then((r) => {
        Object.assign(profile, r.data)
    })
}

// ── Intersection Observer ──────────────────────────────────────────────────
let observer

onMounted(() => {
    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) activeSection.value = entry.target.id
            })
        },
        { rootMargin: '-40% 0px -55% 0px', threshold: 0 }
    )

    navLinks.value
        .map(({ id }) => document.getElementById(id))
        .filter(Boolean)
        .forEach((el) => observer.observe(el))

    getProfileSettings()
})

onBeforeUnmount(() => observer?.disconnect())
</script>

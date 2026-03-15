<template>
    <div class="relative min-h-screen bg-surface font-sans text-primary">
        <!-- ── Sidebar ───────────────────────────────────────────────────── -->
        <IntroductionSidebar
            :photo="`/storage/${profileProp.picture}`"
            :name="profile.username"
            :description="profileProp.nav_description"
            :occupation="profileProp.occupation"
            :links="navLinks"
            :active-section="activeSection"
            @navigate="scrollToSection"
        />


        <!-- ── Main content (offset by sidebar on desktop) ───────────────── -->
        <main
            class="md:ml-[22%] md:max-w-[calc(100%-max(22%,210px))]
             flex flex-col mb-6 md:px-16 bg-tertiary"
        >

            <!-- ─────────────────────────────────────────────────────────────
                 MOBILE ONLY: sticky active-section breadcrumb
                 Sits below the sticky mobile header (top-[53px])
            ──────────────────────────────────────────────────────────────── -->
            <div
                class="md:hidden sticky top-[53px] z-30
               flex items-center gap-2 px-5 py-2
               bg-surface/95 backdrop-blur-md border-b border-primary/8
               text-[0.62rem] font-bold tracking-[0.18em] uppercase text-primary/60
               transition-all duration-300"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse flex-shrink-0"/>
                {{ activeSectionLabel }}
            </div>

            <!-- ══════════════════════════════════════
                 SECTION: Home
            ═══════════════════════════════════════ -->
            <LandingSection
            :profileProp="profileProp"
            :skillsProp="skillsProp"
            />


            <!-- ══════════════════════════════════════
                 SECTION: About
            ═══════════════════════════════════════ -->
            <About
            :profileProp="profileProp"
            :statsProp="statsProp"
            />


            <!-- ══════════════════════════════════════
                 SECTION: Projects
            ═══════════════════════════════════════ -->
            <Projects
            :projectsProp="projectsProp"
            />

            <!-- ══════════════════════════════════════
                 SECTION: Skills
            ═══════════════════════════════════════ -->
            <Skills
            :categories="categoryProp"
            />

            <!-- ══════════════════════════════════════
                 SECTION: Contact
            ═══════════════════════════════════════ -->
            <section
                id="contact"
                class="min-h-screen py-20 mb-32 md:mb-0 bg-tertiary px-8"
            >
                <p class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-surface/30 mb-2">
                    // reach out
                </p>
                <h2
                    class="font-display font-black tracking-tight text-surface mb-3"
                    style="font-size: clamp(1.9rem, 4vw, 2.8rem)"
                >Let's Build Something.</h2>
                <p class="text-sm leading-relaxed text-surface/55 max-w-md mb-10">
                    Have a project in mind or just want to say hello? I usually respond within 24 hours.
                </p>

                <form
                    class="flex flex-col gap-4 max-w-full"
                    novalidate
                    @submit.prevent="handleSubmit"
                >
                    <div v-if="success" class="text-green-600"> {{ successMessage }}</div>
                    <div v-if="errorMessage" class="text-red-600"> {{ errorMessage }}</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="font-mono text-[0.58rem] tracking-[0.14em] uppercase text-surface/40"
                                   for="cf-name">Name</label>
                            <input
                                id="cf-name"
                                v-model="form.name"
                                type="text"
                                placeholder="Your name"
                                autocomplete="name"
                                class="bg-surface/8 border border-surface/15 rounded-lg px-4 py-2.5
                       text-sm text-surface placeholder:text-surface/25
                       focus:outline-none focus:border-surface/40 focus:bg-surface/12
                       transition-colors duration-200"
                            />
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="font-mono text-[0.58rem] tracking-[0.14em] uppercase text-surface/40"
                                   for="cf-email">Email</label>
                            <input
                                id="cf-email"
                                v-model="form.email"
                                type="email"
                                placeholder="you@example.com"
                                autocomplete="email"
                                class="bg-surface/8 border border-surface/15 rounded-lg px-4 py-2.5
                       text-sm text-surface placeholder:text-surface/25
                       focus:outline-none focus:border-surface/40 focus:bg-surface/12
                       transition-colors duration-200"
                            />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="font-mono text-[0.58rem] tracking-[0.14em] uppercase text-surface/40"
                               for="cf-message">Message</label>
                        <textarea
                            id="cf-message"
                            v-model="form.message"
                            rows="5"
                            placeholder="Tell me about your project…"
                            class="bg-surface/8 border border-surface/15 rounded-lg px-4 py-2.5
                     text-sm text-surface placeholder:text-surface/25 resize-y
                     focus:outline-none focus:border-surface/40 focus:bg-surface/12
                     transition-colors duration-200"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="self-start inline-flex items-center gap-2
                        px-6 py-2.5 rounded-lg
                        bg-primary text-tertiary text-sm font-bold tracking-wide
                        hover:opacity-90 active:scale-95 transition-all duration-200
                        disabled:opacity-50 disabled:cursor-not-allowed">

                        <span v-if="!loading">Send Message →</span>
                        <span v-else>Sending...</span>
                    </button>
                </form>
            </section>
        </main>
        <section
            id="footer"
            class="md:hidden absolute bottom-0 px-8 mt-24 md:px-16 bg-primary w-full"
        >
            <Footer
            :name="profileProp.username"
            :tagline="profileProp.nav_description"
            />
        </section>
    </div>
</template>

<script setup>
import {ref, reactive, computed, onMounted, onBeforeUnmount} from 'vue'
import IntroductionSidebar from '../components/SideBar/IntroductionSidebar.vue'
import Footer from "@/Components/Footer.vue";
import axios from "axios";
import Skills from "@/Components/WelcomeSections/Skills.vue";
import About from "@/Components/WelcomeSections/About.vue";
import Projects from "@/Components/WelcomeSections/Projects.vue";
import LandingSection from "@/Components/WelcomeSections/LandingSection.vue";

// ── Props from backend (Laravel passes these) ──────────────────────────────
const props = defineProps({
    profileProp: {type: Object, default: null},
    statsProp: {type: Object, default: null},
    projectsProp: {type: Object, default: null},
    categoryProp: {type: Object, default: null},
    skillsProp: {type: Object, default: null},
    linksProp: {type: Array, default: null},
})

// ── Profile defaults (override via props from backend) ────────────────────
const profile = reactive(props.profileProp || {
    picture: '/profile.png',
    username: 'Atuo Israel Beshuwhobel',
    nav_description: 'Crafting elegant web experiences — pixel-perfect UIs, scalable APIs, and everything in between.',
})

// ── Nav link defaults ──────────────────────────────────────────────────────
const navLinks = ref(props.linksProp || [
    {id: 'home', label: 'Home', icon: null},
    {id: 'about', label: 'About Me', icon: null},
    {id: 'projects', label: 'Projects', icon: null},
    {id: 'skills', label: 'Skills', icon: null},
    {id: 'contact', label: 'Contact', icon: null},
])

// ── Active section (scroll-spy) ────────────────────────────────────────────
const activeSection = ref('home')

const success = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

const loading = ref(false)

const activeSectionLabel = computed(() => {
    const found = navLinks.value.find((l) => l.id === activeSection.value)
    return found?.label ?? ''
})

// ── Contact form ───────────────────────────────────────────────────────────
const form = reactive({name: '', email: '', message: ''})


function handleSubmit() {
    success.value = false
    errorMessage.value = ''
    successMessage.value = ''
    loading.value = true

    axios.post('contact-me', {
        contact_user_name: form.name,
        contact_user_email: form.email,
        contact_user_message: form.message
    })
        .then(response => {
            success.value = true
            successMessage.value = response.data.message
            Object.assign(form, {name: '', email: '', message: ''})
        })
        .catch(error => {
            success.value = false
            errorMessage.value =
                error.response?.data?.message ||
                'Something went wrong. Please try again.'
            console.error(error)
        })
        .finally(() => {
            loading.value = false
        })
}

// ── Scroll to section ──────────────────────────────────────────────────────
function scrollToSection(id) {
    const el = document.getElementById(id)
    if (el) el.scrollIntoView({behavior: 'smooth', block: 'start'})
}
function getProfileSettings() { axios.get('/profile/settings').then(r => { profile.value = r.data }) }


// ── Intersection Observer for scroll-spy ─────────────────────────────────
let observer

onMounted(() => {
    const sectionEls = navLinks.value
        .map(({id}) => document.getElementById(id))
        .filter(Boolean)

    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) activeSection.value = entry.target.id
            })
        },
        {threshold: 0.3}
    )

    sectionEls.forEach((el) => observer.observe(el))

    getProfileSettings()
})

onBeforeUnmount(() => observer?.disconnect())
</script>

<style scoped>
@keyframes expand-x {
    from {
        transform: scaleX(0);
        opacity: 0;
    }
    to {
        transform: scaleX(1);
        opacity: 1;
    }
}

.animate-expand-x {
    animation: expand-x 0.6s ease 0.3s both;
}
</style>

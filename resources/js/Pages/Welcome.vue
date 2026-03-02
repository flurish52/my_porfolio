<template>
    <div class="relative min-h-screen bg-surface font-sans text-primary">

        <!-- ── Sidebar ───────────────────────────────────────────────────── -->
        <IntroductionSidebar
            :photo="profile.photo"
            :name="profile.name"
            :description="profile.description"
            :links="navLinks"
            :active-section="activeSection"
            @navigate="scrollToSection"
        />

        <!-- ── Main content (offset by sidebar on desktop) ───────────────── -->
        <main
            class="md:ml-[22%] md:max-w-[calc(100%-max(22%,210px))]
             flex flex-col mb-6"
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
            <section
                id="home"
                class="relative min-h-fit flex flex-col md:flex-row items-center px-8 md:px-16 py-20
               border-b border-primary/6 overflow-hidden"
            >
                <SidebarPhoto
                    class="md:hidden"
                    :photo="profile.photo"
                    :name="profile.name"
                />
                <!-- Decorative bg glyph -->
                <div
                    class=" absolute right-0 bottom-0 font-display font-black
                 text-[clamp(5rem,18vw,13rem)] leading-none tracking-[-4px]
                 text-primary/[0.025] select-none pointer-events-none"
                    aria-hidden="true"
                >{ }
                </div>

                <div class="relative z-10 max-w-2xl w-full">
                    <p class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-3">
                        // hello world
                    </p>

                    <h2 class="font-display font-black leading-[1.05] tracking-tight mb-5"
                        style="font-size: clamp(2.4rem, 6vw, 4rem)">
            <span class="block font-serif italic font-normal text-[0.45em] text-primary/45 mb-1 tracking-normal">
              Hi, I'm
            </span>
                        <span class="relative inline-block text-primary">
              {{ profile.name }}
                            <!-- Animated underline -->
              <span
                  class="absolute left-0 -bottom-1 h-1 bg-primary rounded-full
                       animate-expand-x origin-left"
                  style="width: 56px"
              />
            </span>
                    </h2>

                    <p class="text-base leading-[1.8] text-primary/55 max-w-[520px] mb-8">
                        I design and engineer things for the web — from robust backend systems
                        to pixel-perfect, accessible interfaces. I care about every detail,
                        from database indices to hover transitions.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap gap-3 mb-10">
                        <button
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                     bg-primary text-tertiary text-sm font-semibold tracking-wide
                     hover:opacity-85 active:scale-95 transition-all duration-200"
                            @click="scrollToSection('projects')"
                        >
                            View Projects
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </button>
                        <button
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                     border border-primary/25 text-primary text-sm font-semibold tracking-wide
                     hover:border-primary/50 hover:bg-primary/5
                     active:scale-95 transition-all duration-200"
                            @click="scrollToSection('contact')"
                        >
                            Get in Touch
                        </button>
                    </div>

                    <!-- Tech chips -->
                    <div class="flex flex-wrap gap-2">
            <span
                v-for="tech in techStack" :key="tech"
                class="font-mono text-[0.65rem] tracking-wide px-2.5 py-1 rounded
                     border border-primary/15 text-primary/80
                     hover:border-primary/40 hover:text-primary/50
                     transition-colors duration-200 cursor-default"
            >{{ tech }}</span>
                    </div>
                </div>
            </section>


            <!-- ══════════════════════════════════════
                 SECTION: About
            ═══════════════════════════════════════ -->
            <section
                id="about"
                class="min-h-screen px-8 md:px-16 py-20 border-b border-primary/6"
            >
                <p class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-2">
                    // my story
                </p>
                <h2
                    class="font-display font-black tracking-tight text-primary mb-8"
                    style="font-size: clamp(1.9rem, 4vw, 2.8rem)"
                >About Me.</h2>

                <div class="max-w-2xl space-y-4 mb-12">
                    <p class="text-[0.95rem] leading-[1.85] text-primary/60">
                        I'm <strong class="text-primary font-semibold">{{ profile.name }}</strong>,
                        a full-stack web developer who thrives at the intersection of engineering
                        and design. I care deeply about writing clean, maintainable code and
                        delivering experiences that feel effortless to use.
                    </p>
                    <p class="text-[0.95rem] leading-[1.85] text-primary/60">
                        Whether I'm architecting a RESTful API, optimising a SQL query,
                        or fine-tuning a CSS animation down to the millisecond — I bring the same
                        level of craft and intention to every layer of the stack.
                    </p>
                    <p class="text-[0.95rem] leading-[1.85] text-primary/60">
                        When I'm not building, I'm mentoring developers, contributing to open source,
                        or exploring whatever new framework the community is excited about this week.
                    </p>
                </div>

                <!-- Stats -->
                <div class="flex flex-wrap gap-8 md:gap-14">
                    <div v-for="stat in stats" :key="stat.label" class="flex flex-col gap-1">
            <span class="font-display font-black text-[2.2rem] leading-none tracking-tight text-primary">
              {{ stat.value }}
            </span>
                        <span class="font-mono text-[0.58rem] tracking-[0.14em] uppercase text-primary/50">
              {{ stat.label }}
            </span>
                    </div>
                </div>
            </section>


            <!-- ══════════════════════════════════════
                 SECTION: Projects
            ═══════════════════════════════════════ -->
            <section
                id="projects"
                class="min-h-screen px-8 md:px-16 py-20 border-b border-primary/6
               bg-primary/[0.015]"
            >
                <p class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-2">
                    // my work
                </p>
                <h2
                    class="font-display font-black tracking-tight text-primary mb-2"
                    style="font-size: clamp(1.9rem, 4vw, 2.8rem)"
                >Projects.</h2>
                <p class="text-sm leading-relaxed text-primary/50 max-w-md mb-10">
                    A curated selection of things I've built — developer tools, SaaS platforms,
                    and full-featured web applications.
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 max-w-3xl">
                    <a
                        v-for="project in projects"
                        :key="project.title"
                        :href="project.link"
                        target="_blank"
                        class="flex flex-col gap-4 p-6 rounded-xl bg-surface
                   border border-primary/8 border-t-2 border-t-primary
                   hover:-translate-y-1 hover:shadow-[0_12px_32px_theme(colors.primary/8%)]
                   transition-all duration-250 group  bg-tertiary"
                    >
                        <div class="flex-1">
              <span class="font-mono text-[0.6rem] tracking-wider text-primary/30 mb-2 block">
                {{ project.number }}
              </span>
                            <h3 class="font-display font-bold text-base text-primary mb-2 leading-snug">
                                {{ project.title }}
                            </h3>
                            <p class="text-sm leading-relaxed text-primary/50">{{ project.desc }}</p>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
              <span
                  v-for="t in project.tech" :key="t"
                  class="font-mono text-[0.58rem] tracking-wide px-2 py-0.5 rounded
                       bg-primary/6 text-primary/55"
              >{{ t }}</span>
                        </div>
                    </a>
                </div>
            </section>

            <!-- ══════════════════════════════════════
                 SECTION: Skills
            ═══════════════════════════════════════ -->
            <section
                id="skills"
                class="min-h-ft px-8 md:px-16 py-20 border-b border-primary/6
               bg-primary/[0.015]"
            >
                <p class="font-mono text-[0.62rem] tracking-[0.22em] uppercase text-primary/35 mb-2">
                    // what I know
                </p>
                <h2
                    class="font-display font-black tracking-tight text-primary mb-10"
                    style="font-size: clamp(1.9rem, 4vw, 2.8rem)"
                >Skills.</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-3xl">
                    <div v-for="group in skillGroups" :key="group.category">
                        <h3 class="font-mono text-[0.6rem] tracking-[0.18em] uppercase text-primary/35
                       font-bold mb-3">
                            {{ group.category }}
                        </h3>
                        <div class="flex flex-wrap gap-1.5">
              <span
                  v-for="skill in group.items" :key="skill"
                  class="text-[0.75rem] px-2.5 py-1 rounded-md
                       border border-primary/14 text-primary/60
                       hover:bg-primary hover:text-surface hover:border-primary
                       transition-all duration-200 cursor-default"
              >{{ skill }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ══════════════════════════════════════
                 SECTION: Contact
            ═══════════════════════════════════════ -->
            <section
                id="contact"
                class="min-h-screen px-8 md:px-16 py-20 bg-tertiary"
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
                    class="flex flex-col gap-4 max-w-[520px]"
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
            <Footer/>
        </section>
    </div>
</template>

<script setup>
import {ref, reactive, computed, onMounted, onBeforeUnmount} from 'vue'
import IntroductionSidebar from '../components/SideBar/IntroductionSidebar.vue'
import SidebarPhoto from "@/Components/SideBar/SidebarPhoto.vue";
import Footer from "@/Components/Footer.vue";

// ── Props from backend (Laravel passes these) ──────────────────────────────
const props = defineProps({
    profileProp: {type: Object, default: null},
    linksProp: {type: Array, default: null},
})

// ── Profile defaults (override via props from backend) ────────────────────
const profile = reactive(props.profileProp || {
    photo: '/profile.png',
    name: 'Atuo Israel Beshuwhobel',
    description: 'Crafting elegant web experiences — pixel-perfect UIs, scalable APIs, and everything in between.',
})

// ── Nav link defaults ──────────────────────────────────────────────────────
const navLinks = ref(props.linksProp || [
    {id: 'home', label: 'Home', icon: null},
    {id: 'about', label: 'About Me', icon: null},
    {id: 'projects', label: 'Projects', icon: null},
    {id: 'skills', label: 'Skills', icon: null},
    {id: 'contact', label: 'Contact', icon: null},
])

// ── Page data ──────────────────────────────────────────────────────────────
const techStack = [
    'Vue.js', 'Laravel', 'TypeScript', 'Tailwind CSS',
    'Node.js', 'PostgreSQL', 'Docker', 'REST APIs',
]

const projects = [
    {
        number: '04',
        title: 'Entroly',
        desc: 'Mini CRM and PMS for managing clients and projects.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL', 'REST API'],
        link: 'https://www.entroly.com.ng'
    },
    {
        number: '05',
        title: 'World City',
        desc: 'Marketplace for people to sell used or new items, no online payments.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL', 'REST API'],
        link: 'https://www.worldcity.com.ng'
    },
    {
        number: '01',
        title: 'Store.stechmax Landing Page',
        desc: 'Frontend of an e-commerce store landing page.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL'],
        link: 'https://www.store.stechmax.com'
    },
    {
        number: '02',
        title: 'FOIDINC',
        desc: 'Website for a Catholic NGO to share programs and updates.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL'],
        link: 'https://www.foidinc.org'
    },
    {
        number: '03',
        title: 'DailyReflectionWithPhilomena',
        desc: 'Platform for daily reflections for a Catholic NGO.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL'],
        link: 'https://dailyreflectionswithphilomena.com'
    },
    {
        number: '06',
        title: 'Energy Reserve',
        desc: 'Company website for a green energy company selling solar products and components.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL'],
        link: 'https://www.energyreserve.com.ng'
    },
    {
        number: '07',
        title: 'Stechmax Landing Page',
        desc: 'Frontend landing page for Stechmax, a tech agency.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL'],
        link: 'https://www.stechmax.com'
    },
    {
        number: '08',
        title: 'Stechmax Academy',
        desc: 'Website for Stechmax Academy, a tech training platform.',
        tech: ['Vue.js', 'Tailwind CSS', 'Laravel', 'MySQL'],
        link: 'https://www.academy.stechmax.com'
    }
]
const stats = [
    {value: '4+', label: 'Years coding'},
    {value: '20+', label: 'Projects shipped'},
    {value: '8+', label: 'Happy clients'},
    {value: '∞', label: 'Playlists on repeat'},
]

const skillGroups = [
    {
        category: 'Frontend',
        items: ['Vue.js', 'Nude.js', 'Vanilla JavaScript', 'Tailwind CSS', 'HTML5', 'CSS3'],
    },
    {
        category: 'Backend',
        items: ['Laravel', 'Node.js', 'REST APIs', 'MySql'],
    },
    {
        category: 'Database & Ops',
        items: ['MySQL', 'Docker'],
    },
    {
        category: 'Tools',
        items: ['Git', 'Vite', 'Postman'],
    },
]

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

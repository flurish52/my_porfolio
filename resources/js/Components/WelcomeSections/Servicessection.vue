<template>
    <section id="services" class="bg-surface py-20 md:py-28">
        <div class="mx-auto max-w-6xl px-5 md:px-8">
            <!-- Header -->
            <div class="max-w-2xl">
                <h2 class="text-3xl font-extrabold tracking-tight text-secondary md:text-4xl">
                    {{ heading }}
                </h2>
                <p class="mt-4 leading-relaxed text-secondary-muted">{{ subheading }}</p>
            </div>

            <!-- Services: a divided list reads calmer than a grid of identical cards -->
            <div class="mt-12 divide-y divide-line border-y border-line">
                <div
                    v-for="service in list"
                    :key="service.title"
                    class="grid gap-6 py-8 md:grid-cols-5 md:gap-10 md:py-10"
                >
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-bold tracking-tight text-secondary">{{ service.title }}</h3>
                        <p class="mt-2 leading-relaxed text-secondary-muted">{{ service.description }}</p>
                    </div>

                    <ul class="grid gap-x-8 gap-y-3 sm:grid-cols-2 md:col-span-3">
                        <li
                            v-for="item in service.items"
                            :key="item.label || item"
                            class="flex items-start gap-3 text-secondary"
                        >
                            <svg viewBox="0 0 24 24" class="mt-0.5 h-5 w-5 flex-shrink-0 text-primary" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-medium">{{ item.label || item }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Process: this one really is a sequence, so the numbers mean something -->
            <div class="mt-20">
                <h3 class="text-2xl font-extrabold tracking-tight text-secondary md:text-3xl">
                    What working with me looks like
                </h3>
                <ol class="mt-10 grid gap-8 md:grid-cols-4">
                    <li v-for="(step, i) in steps" :key="step.title" class="border-t-2 border-primary pt-5">
                        <p class="text-sm font-bold text-primary">Step {{ i + 1 }}</p>
                        <h4 class="mt-1 text-lg font-bold text-secondary">{{ step.title }}</h4>
                        <p class="mt-2 text-sm leading-relaxed text-secondary-muted">{{ step.text }}</p>
                    </li>
                </ol>
            </div>

            <!-- Closing call to action -->
            <div
                class="mt-20 flex flex-col items-start justify-between gap-6 rounded-2xl bg-primary-soft p-8 md:flex-row md:items-center md:p-10"
            >
                <p class="max-w-xl text-xl font-bold leading-snug text-secondary">{{ ctaText }}</p>
                <button
                    type="button"
                    class="rounded-lg bg-primary px-7 py-3.5 text-sm font-semibold text-surface transition-colors duration-200 hover:bg-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                    @click="go('contact')"
                >
                    {{ ctaLabel }}
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    heading: { type: String, default: 'How I can help your business' },
    subheading: {
        type: String,
        default:
            'I build the software small and medium businesses run on: products, internal systems, and the automation that saves your team hours every week.',
    },
    ctaText: { type: String, default: "Have something in mind? Let's talk it through." },
    ctaLabel: { type: String, default: 'Tell me about your project' },
    services: { type: [Array, Object], default: () => [] },
})

// Used when the backend sends nothing (Welcome.vue passes [] by default)
const fallbackServices = [
    {
        title: 'SaaS product development',
        description: 'Full SaaS products built from idea to launch, focused on real business use.',
        items: ['Custom SaaS platforms', 'Multi-tenant systems', 'Authentication and roles', 'API-first architecture'],
    },
    {
        title: 'Business systems',
        description: 'Systems that help you manage customers, payments, and daily operations.',
        items: ['CRM and client management', 'Invoices and payments', 'Dashboards and reports', 'Admin panels'],
    },
    {
        title: 'Automation and workflows',
        description: 'Less manual work, with systems that run tasks and handle processes for you.',
        items: ['Task automation', 'Scheduled jobs', 'Notifications and alerts', 'Third-party integrations'],
    },
    {
        title: 'Launch and support',
        description: 'Help to deploy, improve, and keep your product running after launch.',
        items: ['Deployment and hosting', 'Performance optimization', 'Bug fixes and maintenance', 'Product improvements'],
    },
]

const list = computed(() => {
    const given = Object.values(props.services || {})
    return given.length ? given : fallbackServices
})

// Placeholder copy: confirm each promise is true for you, then move it to the DB.
const steps = [
    { title: 'We talk', text: 'You tell me what you need. I ask questions until I understand your business, then send a clear plan.' },
    { title: 'I design', text: 'You see the screens and flow before any code is written, so nothing surprises you later.' },
    { title: 'I build', text: 'You get regular updates and a working version to try along the way.' },
    { title: 'I launch and stay', text: 'I put it live, walk your team through it, and fix anything that comes up.' },
]

const NAV_OFFSET = 72
function go(id) {
    const el = document.getElementById(id)
    if (!el) return
    window.scrollTo({
        top: el.getBoundingClientRect().top + window.scrollY - NAV_OFFSET,
        behavior: 'smooth',
    })
}
</script>

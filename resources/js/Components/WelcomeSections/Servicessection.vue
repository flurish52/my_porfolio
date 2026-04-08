<template>
    <section
        id="services"
        ref="sectionRef"
        class="rounded-2xl md:mr-6 bg-primary py-20 px-6 md:px-14">
        <!-- Header -->
        <div class="mb-14 animate-fade-in">
            <h2 class="text-4xl font-bold text-secondary">{{ heading }}</h2>
            <p class="mt-3 text-secondary/60 text-lg font-medium tracking-wide">{{ subheading }}</p>
        </div>

        <!-- Service Cards Grid -->
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 mb-14 text-black">
            <ServiceCard
                v-for="(service, index) in services"
                :key="service.title"
                :service="service"
                :style="{ animationDelay: `${index * 100}ms` }"
                class="animate-slide-up"
            />
        </div>
        <!-- CTA Banner -->
        <CtaBanner :text="ctaText" :button-label="ctaButtonLabel" :button-href="ctaButtonHref" />
    </section>
</template>

<script setup>
import { defineProps } from 'vue'
import ServiceCard from "@/Components/WelcomeSections/Services/ServiceCard.vue";
import CtaBanner from "@/Components/WelcomeSections/Services/CtaBanner.vue";

// ─── Props ────────────────────────────────────────────────────────────────────

const props = defineProps({
    heading: {
        type: String,
        default: 'My Services',
    },
    subheading: {
        type: String,
        default: 'Empowering Small & Medium Businesses with Focused SaaS Solutions',
    },
    skillsLabel: {
        type: String,
        default: 'My Skills',
    },
    skills: {
        type: Array,
        default: () => [
            'PHP', 'Laravel', 'Vue.js', 'JavaScript', 'Tailwind CSS', 'MySQL', 'REST APIs', 'Livewire',
        ],
    },
    ctaText: {
        type: String,
        default: "Let's Build Your SaaS Solution!",
    },
    ctaButtonLabel: {
        type: String,
        default: 'Get in Touch',
    },
    ctaButtonHref: {
        type: String,
        default: '#contact',
    },
    services: {
        type: Array,
        default: () => [
            {
                title: 'SaaS Product Development',
                description: 'You get full SaaS products built from idea to launch, focused on real business use.',
                items: [
                    {
                        label: 'Custom SaaS Platforms',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/></svg>`,
                    },
                    {
                        label: 'Multi Tenant Systems',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/></svg>`,
                    },
                    {
                        label: 'Authentication and Roles',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v6"/><path d="M5 8v6a7 7 0 0 0 14 0V8"/></svg>`,
                    },
                    {
                        label: 'API First Architecture',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19 12h2M3 12h2M12 3v2M12 19v2"/></svg>`,
                    },
                ],
            },
            {
                title: 'Business Systems',
                description: 'You get systems that help you manage customers, payments, and daily operations.',
                items: [
                    {
                        label: 'CRM and Client Management',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M17 11v6"/><path d="M21 15h-8"/></svg>`,
                    },
                    {
                        label: 'Invoices and Payments',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h6"/></svg>`,
                    },
                    {
                        label: 'Dashboards and Reports',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="20" x2="4" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="20" y1="20" x2="20" y2="14"/></svg>`,
                    },
                    {
                        label: 'Admin Panels',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>`,
                    },
                ],
            },
            {
                title: 'Automation and Workflows',
                description: 'You reduce manual work with systems that run tasks and handle processes for you.',
                items: [
                    {
                        label: 'Task Automation',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>`,
                    },
                    {
                        label: 'Scheduled Jobs and Cron',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>`,
                    },
                    {
                        label: 'Notifications and Alerts',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/></svg>`,
                    },
                    {
                        label: 'Third Party Integrations',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 18l6-6-6-6"/><path d="M8 6l-6 6 6 6"/></svg>`,
                    },
                ],
            },
            {
                title: 'Launch and Support',
                description: 'You get help to deploy, improve, and keep your SaaS product running.',
                items: [
                    {
                        label: 'Deployment and Hosting',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12"/><path d="M7 8l5-5 5 5"/><path d="M5 21h14"/></svg>`,
                    },
                    {
                        label: 'Performance Optimization',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h4l3 9 6-18 3 9h4"/></svg>`,
                    },
                    {
                        label: 'Bug Fixes and Maintenance',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/><circle cx="12" cy="12" r="10"/></svg>`,
                    },
                    {
                        label: 'Product Improvements',
                        icon: `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"/><path d="M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.13-3.36L23 10"/><path d="M1 14l5.36 4.36A9 9 0 0 0 20.49 15"/></svg>`,
                    },
                ],
            },
        ],
    },

})
</script>

<style scoped>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes slide-up {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.6s ease both;
}

.animate-slide-up {
    animation: slide-up 0.55s ease both;
}
</style>

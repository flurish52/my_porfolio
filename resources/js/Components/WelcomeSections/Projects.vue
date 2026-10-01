<template>
    <section id="projects" class="bg-canvas py-20 md:py-28">
        <div class="mx-auto max-w-6xl px-5 md:px-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-extrabold tracking-tight text-secondary md:text-4xl">
                    Work I'm proud of
                </h2>
                <p class="mt-4 leading-relaxed text-secondary-muted">
                    Real projects, live and in use. Open any of them and see for yourself.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2">
                <article
                    v-for="project in visibleProjects"
                    :key="project.id"
                    class="flex flex-col overflow-hidden rounded-2xl border border-line bg-surface shadow-card transition-colors duration-200 hover:border-primary/40"
                >
                    <div class="aspect-[16/10] overflow-hidden border-b border-line bg-canvas">
                        <img
                            v-if="project.image"
                            :src="`/storage/${project.image}`"
                            :alt="`Screenshot of ${project.title}`"
                            loading="lazy"
                            class="h-full w-full object-cover"
                        />
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <p v-if="project.role" class="text-sm font-medium text-primary">
                            {{ project.role }}
                        </p>
                        <h3 class="mt-1 text-xl font-bold tracking-tight text-secondary">
                            {{ project.title }}
                        </h3>
                        <p class="mt-3 leading-relaxed text-secondary-muted">
                            {{ project.description }}
                        </p>

                        <!-- Optional: shows once the admin panel has an "outcome" field -->
                        <p
                            v-if="project.outcome"
                            class="mt-4 rounded-lg bg-primary-soft px-4 py-3 text-sm font-medium text-primary-dark"
                        >
                            {{ project.outcome }}
                        </p>

                        <ul v-if="project.skills?.length" class="mt-5 flex flex-wrap gap-2">
                            <li
                                v-for="skill in project.skills"
                                :key="skill.id || skill.name"
                                class="rounded-full border border-line bg-canvas px-3 py-1 text-xs font-medium text-secondary-muted"
                            >
                                {{ skill.name }}
                            </li>
                        </ul>

                        <a
                            :href="project.link"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-6 inline-flex items-center gap-2 self-start text-sm font-semibold text-primary hover:text-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary"
                        >
                            Visit live site
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({ projectsProp: { type: [Array, Object], default: () => [] } })

// A dead or malformed link is worse than no project: only show ones that really open.
function hasValidLink(link) {
    try {
        const url = new URL(link)
        return ['http:', 'https:'].includes(url.protocol) && url.hostname.includes('.')
    } catch {
        return false
    }
}

const visibleProjects = computed(() =>
    Object.values(props.projectsProp || {}).filter((p) => p.title && hasValidLink(p.link))
)
</script>

<template>
    <div class="fixed z-50">
        <AdminSideBar
            :links="links"
            :photo="`/storage/${initialProfile.picture}`"
            :name="initialProfile.username"
            @navigate="scrollToSection" />
    </div>

    <main class="md:ml-[22%] md:max-w-[calc(100%-max(22%,210px))] flex flex-col mb-6">
        <section id="general" class="px-8 md:px-16 pt-20 border-b border-primary/6 section-fade">
            <SectionHeader title="general" @toggle="toggle" />
            <div class="collapsible"
                 :class="{ collapsed: !open.general }">
                <div class="px-8 md:px-16 py-4">
                    <Profilesettings
                        :initialProfile="initialProfile"
                        :initialStats="initialStats"

                    />
                </div>
            </div>
        </section>

        <section id="categories" class="px-8 md:px-16 pt-10 border-b border-primary/6 section-fade">
            <SectionHeader title="categories" @toggle="toggle" />
            <div class="collapsible" :class="{ collapsed: !open.categories }">
                <div class="px-8 md:px-16 ">
                    <CategoriesManager :initialCategories="categories" @saved="getCategories" />
                </div>
            </div>
        </section>

        <section id="projects" class="min-h-fit px-8 md:px-16 pt-10 border-b border-primary/6 section-fade">
            <SectionHeader title="projects" @toggle="toggle" />
            <div class="collapsible" :class="{ collapsed: !open.projects }">
                <div class="px-8 md:px-16 py-4">
                    <Projectsmanager :skills="skills" :initialProjects="projects" @saved="getProjects()" />
                </div>
            </div>
        </section>

        <section id="skills" class="min-h-fit px-8 md:px-16 pt-10 border-b border-primary/6 section-fade">
            <SectionHeader title="skills" @toggle="toggle" />
            <div class="collapsible" :class="{ collapsed: !open.skills }">
                <div class="px-8 md:px-16 py-4">
                    <Skillsmanager :initialSkills="skills" :categories="categories" @saved="getSkills" />
                </div>
            </div>
        </section>
        <section id="messages" class="min-h-fit px-8 md:px-16 pt-10 border-b border-primary/6 section-fade">
            <SectionHeader title="messages" @toggle="toggle" />
            <div class="collapsible" :class="{ collapsed: !open.messages }">
                <div class="px-8 md:px-16 py-4">
                    <ContactMessages
                        :contactMessages="props.contactMessages" />
                </div>
            </div>
        </section>

    </main>
</template>

<script setup>
import AdminSideBar from "@/Components/AdminSideBar/AdminSideBar.vue";
import { computed, onMounted, reactive, ref } from "vue";
import CategoriesManager from "@/Components/AdminComponents/Categoriesmanager.vue";
import Skillsmanager from "@/Components/AdminComponents/Skillsmanager.vue";
import axios from "axios";
import Projectsmanager from "@/Components/AdminComponents/Projectsmanager.vue";
import Profilesettings from "@/Components/AdminComponents/Profilesettings.vue";
import SectionHeader from "@/Components/AdminComponents/SectionHeader.vue";
import ContactMessages from "@/Components/AdminComponents/ContactMessages.vue";

const props = defineProps({
    contactMessages: Array,
})
let categories = ref([])
let skills = ref([])
let projects = ref([])
let initialProfile = ref([])
let initialStats = ref([])

const links = ref([
    { id: 'general', label: 'Generals', icon: null },
    { id: 'categories', label: 'Categories', icon: null },
    { id: 'projects', label: 'Projects', icon: null },
    { id: 'skills', label: 'Skills', icon: null },
    { id: 'messages', label: 'Messages', icon: null },
])

const open = reactive({
    general: true,
    categories: false,
    projects: false,
    skills: false,
    messages: false,
})

function toggle(section) {
    open[section] = !open[section]
}

const activeSection = ref('general')

const activeSectionLabel = computed(() => {
    const found = links.value.find((l) => l.id === activeSection.value)
    return found?.label ?? ''
})

function scrollToSection(id) {
    const el = document.getElementById(id)
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

function getCategories() { axios.get('/categories').then(r => { categories.value = r.data }) }
function getProfileSettings() { axios.get('/profile/settings').then(r => { initialProfile.value = r.data }) }
function getSkills() { axios.get('/skills').then(r => { skills.value = r.data }) }
function getProjects() { axios.get('/projects').then(r => { projects.value = r.data }) }
function getStats() { axios.get('/site-stats').then(r => { initialStats.value = r.data }) }

let observer

onMounted(() => {
    const sectionEls = links.value.map(({ id }) => document.getElementById(id)).filter(Boolean)

    observer = new IntersectionObserver(
        (entries) => { entries.forEach((entry) => { if (entry.isIntersecting) activeSection.value = entry.target.id }) },
        { threshold: 0.3 }
    )
    sectionEls.forEach((el) => observer.observe(el))

    getCategories()
    getSkills()
    getProjects()
    getProfileSettings()
    getStats()
})
</script>

<style scoped>
.collapsible {
    display: grid;
    grid-template-rows: 1fr;
    width: 100%;
    max-width: 100%;
    overflow: hidden;
    box-sizing: border-box;
    transition: grid-template-rows 0.3s ease;
}

.collapsible.collapsed {
    grid-template-rows: 0fr;
}

.collapsible > div {
    min-height: 0;
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.collapsible * {
    max-width: 100%;
    box-sizing: border-box;
}
</style>


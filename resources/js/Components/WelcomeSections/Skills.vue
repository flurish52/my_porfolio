<template>
    <section v-if="visibleCategories.length" id="skills" class="bg-surface py-20 md:py-28">
        <div class="mx-auto grid max-w-6xl gap-10 px-5 md:px-8 lg:grid-cols-12 lg:gap-16">
            <!-- Left: heading + category switcher -->
            <div class="lg:col-span-4">
                <h2 class="text-3xl font-extrabold tracking-tight text-secondary md:text-4xl">
                    My toolbox
                </h2>
                <p class="mt-4 leading-relaxed text-secondary-muted">
                    The tools I reach for to design, build and ship software. Pick an area to explore it.
                </p>

                <div
                    role="tablist"
                    aria-label="Skill categories"
                    class="mt-8 flex flex-wrap gap-2 lg:flex-col"
                    @keydown="onKeydown"
                >
                    <button
                        v-for="(category, i) in visibleCategories"
                        :id="`skill-tab-${i}`"
                        :key="category.id || category.name"
                        ref="tabRefs"
                        type="button"
                        role="tab"
                        :aria-selected="i === activeIndex"
                        :aria-controls="`skill-panel`"
                        :tabindex="i === activeIndex ? 0 : -1"
                        class="flex items-center justify-between gap-3 rounded-xl px-4 py-2.5 text-left text-sm font-semibold transition-colors duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary lg:w-full lg:py-3"
                        :class="
                            i === activeIndex
                                ? 'bg-primary text-surface shadow-card'
                                : 'bg-canvas text-secondary hover:bg-primary-soft hover:text-primary-dark'
                        "
                        @click="activeIndex = i"
                    >
                        <span class="whitespace-nowrap">{{ category.name }}</span>
                        <span
                            class="rounded-full px-2 py-0.5 text-xs font-bold"
                            :class="i === activeIndex ? 'bg-surface/20 text-surface' : 'bg-surface text-secondary-muted'"
                        >{{ category.skills.length }}</span>
                    </button>
                </div>
            </div>

            <!-- Right: the skills of the chosen category -->
            <div class="lg:col-span-8">
                <div
                    id="skill-panel"
                    role="tabpanel"
                    :aria-labelledby="`skill-tab-${activeIndex}`"
                    class="rounded-2xl border border-line bg-canvas p-4 sm:p-6 md:min-h-[18rem] md:p-8"
                >
                    <Transition
                        mode="out-in"
                        enter-active-class="transition duration-300 ease-out motion-reduce:transition-none"
                        enter-from-class="translate-y-2 opacity-0"
                        enter-to-class="translate-y-0 opacity-100"
                        leave-active-class="transition duration-150 ease-in motion-reduce:transition-none"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <ul :key="activeIndex" class="grid grid-cols-2 gap-2.5 sm:grid-cols-3 sm:gap-3">
                            <li
                                v-for="skill in activeCategory.skills"
                                :key="skill.id || skill.name"
                                class="group flex items-center gap-2.5 rounded-xl border border-line bg-surface p-3 sm:gap-3 sm:p-3.5 transition-colors duration-200 hover:border-primary/40"
                            >
                                <span
                                    class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-primary-soft text-xs font-bold sm:h-10 sm:w-10 sm:text-sm uppercase text-primary-dark transition-colors duration-200 group-hover:bg-primary group-hover:text-surface"
                                    aria-hidden="true"
                                >{{ monogram(skill.name) }}</span>
                                <span class="min-w-0 break-words text-sm font-semibold text-secondary sm:text-base">{{ skill.name }}</span>
                            </li>
                        </ul>
                    </Transition>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, nextTick, ref } from 'vue'

const props = defineProps({
    categories: { type: [Array, Object], default: () => [] },
})

// Empty categories (like a leftover "dd") are skipped instead of showing a blank tab.
const visibleCategories = computed(() =>
    Object.values(props.categories || {}).filter((c) => c.name && c.skills?.length)
)

const activeIndex = ref(0)
const tabRefs = ref([])

const activeCategory = computed(
    () => visibleCategories.value[activeIndex.value] || visibleCategories.value[0]
)

// "Tailwind CSS" -> TC, "Laravel" -> LA, "Node.js" -> NJ
function monogram(name) {
    const words = String(name).split(/[\s.\-/]+/).filter(Boolean)
    return words.length > 1 ? words[0][0] + words[1][0] : String(name).slice(0, 2)
}

// Arrow keys move between tabs, as people expect from a tab list
async function onKeydown(e) {
    const count = visibleCategories.value.length
    let next = activeIndex.value
    if (e.key === 'ArrowDown' || e.key === 'ArrowRight') next = (next + 1) % count
    else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') next = (next - 1 + count) % count
    else return
    e.preventDefault()
    activeIndex.value = next
    await nextTick()
    tabRefs.value[next]?.focus()
}
</script>

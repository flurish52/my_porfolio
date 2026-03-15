<template>
    <div class="flex flex-col gap-5">

        <!-- ── Toast ──────────────────────────────────────────── -->
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            leave-active-class="transition-all duration-200 ease-in"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-if="toast.show"
                class="fixed top-5 right-5 z-[9999] flex items-start gap-3 px-4 py-3.5 rounded-xl border max-w-sm w-full shadow-lg"
                :class="toast.type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'"
            >
                <div
                    class="flex-shrink-0 w-[22px] h-[22px] rounded-full flex items-center justify-center mt-px"
                    :class="toast.type === 'success' ? 'bg-green-100' : 'bg-red-100'"
                >
                    <svg v-if="toast.type === 'success'" class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    <svg v-else class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="m-0 text-[0.8125rem] font-semibold" :class="toast.type === 'success' ? 'text-green-700' : 'text-red-700'">
                        {{ toast.type === 'success' ? 'Success' : 'Error' }}
                    </p>
                    <p class="m-0 mt-0.5 text-[0.72rem] leading-snug" :class="toast.type === 'success' ? 'text-green-600' : 'text-red-600'">
                        {{ toast.message }}
                    </p>
                </div>
                <button @click="toast.show = false" class="flex-shrink-0 bg-transparent border-none cursor-pointer p-0 text-gray-400 hover:text-gray-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </transition>

        <!-- ══════════════════════════════════════════════════════
             SECTION 1 — PROFILE
        ══════════════════════════════════════════════════════ -->
        <div class="bg-tertiary border border-primary/10 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">

            <!-- Header -->
            <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-primary/10 bg-white">
                <div>
                    <div class="flex items-center gap-2.5">
                        <span class="font-mono text-[0.6rem] font-medium tracking-[0.1em] text-primary/40 bg-primary/5 border border-primary/10 rounded px-1.5 py-0.5 leading-none">PROFILE</span>
                        <h2 class="m-0 text-sm font-semibold text-primary tracking-tight">Personal Information</h2>
                    </div>
                    <p class="mt-1 text-[0.72rem] text-primary/40 leading-snug">Your public-facing identity and bio content.</p>
                </div>
            </div>

            <div class="px-6 py-6 bg-tertiary flex flex-col gap-6">

                <!-- ── Avatar + Username row ───────────────────── -->
                <div class="flex flex-col sm:flex-row gap-5 items-start">
                    <!-- Avatar upload -->
                    <div class="flex flex-col items-center gap-2.5 flex-shrink-0">
                        <div
                            class="relative w-20 h-20 rounded-2xl border-2 border-dashed border-primary/20 bg-white overflow-hidden cursor-pointer group hover:border-secondary transition-colors"
                            @click="$refs.pictureInput.click()"
                        >
                            <img
                                v-if="profile.picture_preview"
                                :src="profile.picture_preview"
                                class="w-full h-full object-cover"
                                alt="Preview"
                            />
                            <div v-else class="w-full h-full flex flex-col items-center justify-center gap-1">
                                <svg class="w-6 h-6 text-primary/20 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                                <span class="text-[0.6rem] text-primary/30 group-hover:text-secondary transition-colors font-medium">Upload</span>
                            </div>
                            <div v-if="profile.picture_preview" class="absolute inset-0 bg-primary/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                                </svg>
                            </div>
                        </div>

                        <input ref="pictureInput" type="file" accept="image/*" class="hidden" @change="handlePictureUpload" />

                        <div class="text-center">
                            <p class="text-[0.65rem] text-primary/40 leading-snug">Max 1 MB</p>
                            <p class="text-[0.65rem] text-primary/40 leading-snug">JPG, PNG, WebP</p>
                        </div>
                        <p v-if="profile.errors?.picture" class="text-[0.68rem] text-red-400 text-center max-w-[90px] leading-snug">{{ profile.errors.picture }}</p>
                    </div>

                    <!-- Username + Occupation -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3 w-full">
                        <!-- Username -->
                        <div class="flex flex-col sm:col-span-2">
                            <label class="text-[0.72rem] font-medium text-primary/50 uppercase tracking-wide mb-1.5">Username</label>
                            <div
                                class="flex items-center gap-2.5 bg-white border rounded-[10px] px-3.5 transition focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)]"
                                :class="profile.errors?.username ? 'border-red-400' : 'border-primary/15'"
                            >
                                <span class="text-sm text-primary/25 font-mono select-none">@</span>
                                <input
                                    v-model="profile.username"
                                    type="text"
                                    placeholder="Full name"
                                    class="flex-1 border-none outline-none bg-transparent text-sm text-primary placeholder-primary/25 py-2.5"
                                />
                            </div>
                            <p v-if="profile.errors?.username" class="mt-1 text-[0.7rem] text-red-400">{{ Array.isArray(profile.errors.username) ? profile.errors.username[0] : profile.errors.username }}</p>
                        </div>

                        <!-- Occupation -->
                        <div class="flex flex-col sm:col-span-2">
                            <label class="text-[0.72rem] font-medium text-primary/50 uppercase tracking-wide mb-1.5">Occupation</label>
                            <div
                                class="flex items-center gap-2.5 bg-white border rounded-[10px] px-3.5 transition focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)]"
                                :class="profile.errors?.occupation ? 'border-red-400' : 'border-primary/15'"
                            >
                                <svg class="w-[15px] h-[15px] text-primary/25 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                                </svg>
                                <input
                                    v-model="profile.occupation"
                                    type="text"
                                    placeholder="e.g. Full-Stack Developer"
                                    class="flex-1 border-none outline-none bg-transparent text-sm text-primary placeholder-primary/25 py-2.5"
                                />
                            </div>
                            <p v-if="profile.errors?.occupation" class="mt-1 text-[0.7rem] text-red-400">{{ Array.isArray(profile.errors.occupation) ? profile.errors.occupation[0] : profile.errors.occupation }}</p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-primary/8"></div>

                <!-- ── Bio fields ──────────────────────────────── -->
                <div class="grid grid-cols-1 gap-4">

                    <!-- About -->
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-[0.72rem] font-medium text-primary/50 uppercase tracking-wide">About</label>
                            <span class="font-mono text-[0.62rem] text-primary/25">Full bio</span>
                        </div>
                        <div
                            class="bg-white border rounded-[10px] transition focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)]"
                            :class="profile.errors?.about ? 'border-red-400' : 'border-primary/15'"
                        >
                            <textarea v-model="profile.about" rows="4" placeholder="Tell visitors about yourself — your background, passions, what drives you…" class="w-full block border-none outline-none bg-transparent text-sm text-primary placeholder-primary/25 px-3.5 py-2.5 resize-y leading-relaxed"></textarea>
                        </div>
                        <p v-if="profile.errors?.about" class="mt-1 text-[0.7rem] text-red-400">{{ Array.isArray(profile.errors.about) ? profile.errors.about[0] : profile.errors.about }}</p>
                    </div>

                    <!-- Nav + Home description -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Nav description -->
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-[0.72rem] font-medium text-primary/50 uppercase tracking-wide">Nav Description</label>
                                <span class="font-mono text-[0.62rem] text-primary/25">Sidebar</span>
                            </div>
                            <div
                                class="bg-white border rounded-[10px] transition focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)]"
                                :class="profile.errors?.nav_description ? 'border-red-400' : 'border-primary/15'"
                            >
                                <textarea v-model="profile.nav_description" rows="3" placeholder="Short line shown under your name in the sidebar nav…" class="w-full block border-none outline-none bg-transparent text-sm text-primary placeholder-primary/25 px-3.5 py-2.5 resize-y leading-relaxed"></textarea>
                            </div>
                            <p v-if="profile.errors?.nav_description" class="mt-1 text-[0.7rem] text-red-400">{{ Array.isArray(profile.errors.nav_description) ? profile.errors.nav_description[0] : profile.errors.nav_description }}</p>
                        </div>

                        <!-- Home description -->
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-[0.72rem] font-medium text-primary/50 uppercase tracking-wide">Home Description</label>
                                <span class="font-mono text-[0.62rem] text-primary/25">Hero</span>
                            </div>
                            <div
                                class="bg-white border rounded-[10px] transition focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)]"
                                :class="profile.errors?.home_description ? 'border-red-400' : 'border-primary/15'"
                            >
                                <textarea v-model="profile.home_description" rows="3" placeholder="Tagline or intro shown on the homepage hero section…" class="w-full block border-none outline-none bg-transparent text-sm text-primary placeholder-primary/25 px-3.5 py-2.5 resize-y leading-relaxed"></textarea>
                            </div>
                            <p v-if="profile.errors?.home_description" class="mt-1 text-[0.7rem] text-red-400">{{ Array.isArray(profile.errors.home_description) ? profile.errors.home_description[0] : profile.errors.home_description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-primary/8"></div>

                <!-- ── Links array ─────────────────────────────── -->
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-[0.72rem] font-medium text-primary/50 uppercase tracking-wide">Links</label>
                            <p class="text-[0.68rem] text-primary/30 mt-0.5">Social profiles, portfolio, CV — anything public.</p>
                        </div>
                        <button
                            type="button"
                            @click="addLink"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[8px] bg-primary/5 border border-primary/10 text-primary/70 text-[0.75rem] font-semibold cursor-pointer hover:bg-primary/10 hover:text-primary transition-colors"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Add Link
                        </button>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div v-for="(link, index) in profile.links" :key="index" class="flex items-center gap-2">
                            <!-- Label input -->
                            <div class="w-28 flex-shrink-0">
                                <div class="flex items-center bg-white border border-primary/15 rounded-[8px] px-2.5 focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)] transition">
                                    <input v-model="link.label" type="text" placeholder="Label" class="w-full border-none outline-none bg-transparent text-[0.8rem] text-primary placeholder-primary/25 py-2" />
                                </div>
                            </div>
                            <!-- URL input -->
                            <div class="flex-1 flex items-center bg-white border border-primary/15 rounded-[8px] px-2.5 gap-2 focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)] transition">
                                <svg class="w-3.5 h-3.5 text-primary/25 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                                </svg>
                                <input v-model="link.url" type="url" placeholder="https://…" class="flex-1 border-none outline-none bg-transparent text-[0.8rem] text-primary placeholder-primary/25 py-2" />
                            </div>
                            <!-- Remove -->
                            <button type="button" @click="removeLink(index)" class="flex-shrink-0 w-7 h-7 rounded-[7px] flex items-center justify-center bg-red-50 border border-red-200 text-red-400 hover:bg-red-100 cursor-pointer transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Empty links -->
                        <div v-if="!profile.links.length" class="flex items-center gap-2.5 px-4 py-3 rounded-[10px] bg-white border border-dashed border-primary/15">
                            <svg class="w-4 h-4 text-primary/20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                            </svg>
                            <span class="text-xs text-primary/35">No links added yet — click "Add Link" to start.</span>
                        </div>
                    </div>
                    <p v-if="profile.errors?.links" class="text-[0.7rem] text-red-400">{{ Array.isArray(profile.errors.links) ? profile.errors.links[0] : profile.errors.links }}</p>
                </div>

                <!-- General error -->
                <p v-if="profile.errors?.general" class="m-0 text-[0.75rem] text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                    {{ profile.errors.general }}
                </p>

                <!-- Save -->
                <div class="flex justify-end pt-1">
                    <button
                        @click="saveProfile"
                        :disabled="profile.saving"
                        class="inline-flex items-center justify-center gap-1.5 px-5 h-10 rounded-[10px] bg-secondary text-white border-none text-[0.8125rem] font-semibold tracking-tight cursor-pointer whitespace-nowrap transition-all hover:opacity-85 active:scale-[0.97] disabled:opacity-40 disabled:cursor-not-allowed"
                    >
                        <span v-if="profile.saving" class="inline-block w-3.5 h-3.5 border-2 border-white/30 border-t-white rounded-full animate-spin flex-shrink-0"></span>
                        <svg v-else class="w-[15px] h-[15px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        {{ profile.saving ? 'Saving…' : 'Save Profile' }}
                    </button>
                </div>

            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════
             SECTION 2 — SITE STATS
        ══════════════════════════════════════════════════════ -->
        <div class="bg-tertiary border border-primary/10 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">

            <!-- Header -->
            <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-primary/10 bg-white">
                <div>
                    <div class="flex items-center gap-2.5">
                        <span class="font-mono text-[0.6rem] font-medium tracking-[0.1em] text-primary/40 bg-primary/5 border border-primary/10 rounded px-1.5 py-0.5 leading-none">STATS</span>
                        <h2 class="m-0 text-sm font-semibold text-primary tracking-tight">Site Statistics</h2>
                    </div>
                    <p class="mt-1 text-[0.72rem] text-primary/40 leading-snug">
                        Highlight numbers shown on your public site — split the
                        <span class="font-mono bg-primary/5 border border-primary/10 px-1 rounded text-[0.65rem] text-primary/60">value</span>
                        and
                        <span class="font-mono bg-primary/5 border border-primary/10 px-1 rounded text-[0.65rem] text-primary/60">label</span>
                        so each part can be styled independently.
                    </p>
                </div>
                <button
                    type="button"
                    @click="addStat"
                    class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-[8px] bg-secondary text-white border-none text-[0.75rem] font-semibold cursor-pointer hover:opacity-85 transition-all whitespace-nowrap"
                >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Add Stat
                </button>
            </div>

            <div class="px-6 py-6 bg-tertiary flex flex-col gap-5">

                <!-- Column headers -->
                <div class="hidden sm:grid grid-cols-[1fr_1fr_2fr_36px] gap-3 px-1">
                    <span class="text-[0.65rem] font-medium text-primary/30 uppercase tracking-wide">Value</span>
                    <span class="text-[0.65rem] font-medium text-primary/30 uppercase tracking-wide">Suffix / Unit</span>
                    <span class="text-[0.65rem] font-medium text-primary/30 uppercase tracking-wide">Label</span>
                    <span></span>
                </div>

                <!-- Stat rows -->
                <div class="flex flex-col gap-3">
                    <div
                        v-for="(stat, index) in stats.items"
                        :key="index"
                        class="grid grid-cols-1 sm:grid-cols-[1fr_1fr_2fr_36px] gap-3 items-start p-4 bg-white rounded-xl border border-primary/10 hover:border-primary/20 transition-colors"
                    >
                        <!-- Value -->
                        <div class="flex flex-col gap-1">
                            <span class="sm:hidden text-[0.65rem] font-medium text-primary/30 uppercase tracking-wide">Value</span>
                            <div class="flex items-center bg-tertiary border border-primary/15 rounded-[8px] px-2.5 focus-within:bg-white focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)] transition">
                                <input v-model="stat.value" type="text" placeholder="4" class="w-full border-none outline-none bg-transparent font-mono text-sm font-semibold text-primary placeholder-primary/25 py-2 tracking-tight" />
                            </div>
                            <p class="text-[0.65rem] text-primary/25">The number itself</p>
                        </div>

                        <!-- Suffix -->
                        <div class="flex flex-col gap-1">
                            <span class="sm:hidden text-[0.65rem] font-medium text-primary/30 uppercase tracking-wide">Suffix / Unit</span>
                            <div class="flex items-center bg-tertiary border border-primary/15 rounded-[8px] px-2.5 focus-within:bg-white focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)] transition">
                                <input v-model="stat.suffix" type="text" placeholder="+" class="w-full border-none outline-none bg-transparent font-mono text-sm font-semibold text-primary placeholder-primary/25 py-2 tracking-tight" />
                            </div>
                            <p class="text-[0.65rem] text-primary/25">e.g. +, ∞, ×, %</p>
                        </div>

                        <!-- Label -->
                        <div class="flex flex-col gap-1">
                            <span class="sm:hidden text-[0.65rem] font-medium text-primary/30 uppercase tracking-wide">Label</span>
                            <div class="flex items-center bg-tertiary border border-primary/15 rounded-[8px] px-2.5 focus-within:bg-white focus-within:border-secondary focus-within:shadow-[0_0_0_3px_rgba(37,99,235,0.12)] transition">
                                <input v-model="stat.label" type="text" placeholder="Years coding" class="w-full border-none outline-none bg-transparent text-sm text-primary placeholder-primary/25 py-2" />
                            </div>
                            <p class="text-[0.65rem] text-primary/25">Description of the number</p>
                        </div>

                        <!-- Remove -->
                        <div class="flex items-start justify-end sm:pt-0 pt-1">
                            <button type="button" @click="removeStat(index)" class="w-9 h-9 rounded-[8px] flex items-center justify-center bg-red-50 border border-red-200 text-red-400 hover:bg-red-100 cursor-pointer transition-colors flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Empty state -->
                    <div v-if="!stats?.items.length" class="flex flex-col items-center justify-center py-10 px-6 rounded-xl border border-dashed border-primary/15 bg-white text-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 border border-primary/10 flex items-center justify-center mb-1">
                            <svg class="w-5 h-5 text-primary/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                            </svg>
                        </div>
                        <p class="m-0 text-sm font-semibold text-primary/60">No stats yet</p>
                        <p class="m-0 text-xs text-primary/35 max-w-[220px] leading-relaxed">Click "Add Stat" above to highlight your key numbers.</p>
                    </div>
                </div>

                <!-- Live preview -->
                <div v-if="stats.items.length" class="mt-1">
                    <p class="text-[0.68rem] font-medium text-primary/30 uppercase tracking-wide mb-2.5">Preview</p>
                    <div class="flex flex-wrap gap-3">
                        <div
                            v-for="(stat, index) in stats.items"
                            :key="index"
                            class="flex flex-col items-center justify-center px-4 py-3 rounded-xl bg-white border border-primary/10 min-w-[90px] text-center"
                        >
                            <span class="font-mono text-xl font-semibold text-primary leading-none tracking-tight">
                                {{ stat.value }}<span class="text-primary/35">{{ stat.suffix }}</span>
                            </span>
                            <span class="text-[0.68rem] text-primary/50 mt-1 leading-snug">{{ stat.label || '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- General error -->
                <p v-if="stats.errors?.general" class="m-0 text-[0.75rem] text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                    {{ stats.errors.general }}
                </p>

                <!-- Save stats -->
                <div class="flex justify-end pt-1">
                    <button
                        @click="saveStats"
                        :disabled="stats.saving || !stats.items.length"
                        class="inline-flex items-center justify-center gap-1.5 px-5 h-10 rounded-[10px] bg-secondary text-white border-none text-[0.8125rem] font-semibold tracking-tight cursor-pointer whitespace-nowrap transition-all hover:opacity-85 active:scale-[0.97] disabled:opacity-40 disabled:cursor-not-allowed"
                    >
                        <span v-if="stats.saving" class="inline-block w-3.5 h-3.5 border-2 border-white/30 border-t-white rounded-full animate-spin flex-shrink-0"></span>
                        <svg v-else class="w-[15px] h-[15px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        {{ stats.saving ? 'Saving…' : 'Save Stats' }}
                    </button>
                </div>

            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import axios from 'axios'

const props = defineProps({
    initialProfile: { type: Object, default: () => ({}) },
    initialStats:   { type: Array,  default: () => [] },
})

// ── Toast ─────────────────────────────────────────────────
const toast = ref({ show: false, type: 'success', message: '' })
let toastTimer = null

function showToast(type, message) {
    clearTimeout(toastTimer)
    toast.value = { show: true, type, message }
    toastTimer = setTimeout(() => (toast.value.show = false), 4500)
}

function extractErrors(err) {
    const data = err?.response?.data
    if (data?.errors)  return data.errors
    if (data?.message) return { general: data.message }
    return { general: 'Something went wrong. Please try again.' }
}

// ── Profile ───────────────────────────────────────────────
const pictureInput = ref(null)
const profile = ref({})

const stats = ref({
    items:  props.initialStats.map(s => ({ value: s.value ?? '', suffix: s.suffix ?? '', label: s.label ?? '' })),
    saving: false,
    errors: {},
})

watch(
    () => [props.initialProfile, props.initialStats],
    ([p, s]) => {

        profile.value = {
            username:         p?.username ?? '',
            occupation:       p?.occupation ?? '',
            about:            p?.about ?? '',
            nav_description:  p?.nav_description ?? '',
            home_description: p?.home_description ?? '',
            links:            p?.links ?? [],
            picture_file:     null,
            picture_preview:  p?.picture ? `/storage/${p.picture}` : null,
            saving:           false,
            errors:           {},
        }

        stats.value = {
            items: props.initialStats?.map(s => ({
                value: s.value ?? '',
                suffix: s.suffix ?? '',
                label: s.label ?? ''
            })) ?? [],
            saving: false,
            errors: {}
        }

    },
    { immediate: true }
)

// True when a profile row already exists in the DB
const isExistingProfile = computed(() => !!props.initialProfile?.id)

function handlePictureUpload(e) {
    const file = e.target.files[0]
    if (!file) return
    if (file.size > 1024 * 1024) {
        profile.value.errors = { ...profile.value.errors, picture: 'Image must be under 1 MB.' }
        return
    }
    profile.value.errors = { ...profile.value.errors, picture: null }
    profile.value.picture_file = file
    profile.value.picture_preview = URL.createObjectURL(file)
}

function addLink()     { profile.value.links.push({ label: '', url: '' }) }
function removeLink(i) { profile.value.links.splice(i, 1) }

async function saveProfile() {
    profile.value.saving = true
    profile.value.errors = {}
    try {
        const payload = new FormData()
        payload.append('username',         profile.value.username)
        payload.append('occupation',       profile.value.occupation)
        payload.append('about',            profile.value.about)
        payload.append('nav_description',  profile.value.nav_description)
        payload.append('home_description', profile.value.home_description)
        payload.append('links',            JSON.stringify(profile.value.links))
        if (profile.value.picture_file) payload.append('picture', profile.value.picture_file)

        if (isExistingProfile.value) {
            // Profile row exists → spoof PUT via POST (FormData can't send PUT natively)
            payload.append('_method', 'PUT')
            await axios.post('/profile/settings', payload, { headers: { 'Content-Type': 'multipart/form-data' } })
        } else {
            await axios.post('/profile/settings', payload, { headers: { 'Content-Type': 'multipart/form-data' } })
        }

        showToast('success', 'Profile updated successfully.')
    } catch (err) {
        profile.value.errors = extractErrors(err)
        showToast('error', 'Failed to save profile. Check the fields below.')
    } finally {
        profile.value.saving = false
    }
}

// ── Stats ─────────────────────────────────────────────────


function addStat()     { stats.value.items.push({ value: '', suffix: '', label: '' }) }
function removeStat(i) { stats.value.items.splice(i, 1) }

async function saveStats() {
    stats.value.saving = true
    stats.value.errors = {}
    try {
        await axios.post('/site-stats', { stats: stats.value.items })
        showToast('success', 'Site stats updated successfully.')
    } catch (err) {
        stats.value.errors = extractErrors(err)
        showToast('error', 'Failed to save stats. Please try again.')
    } finally {
        stats.value.saving = false
    }
}
</script>

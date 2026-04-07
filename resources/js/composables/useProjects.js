import { ref, watch } from 'vue'
import axios from 'axios'

const EMPTY_FORM    = () => ({ title: '', description: '', skill_ids: [], role: '', link: '', image: '', saving: false, errors: {} })
const EMPTY_EDITING = () => ({ id: null, title: '', description: '', skill_ids: [], role: '', link: '', image: '', saving: false, errors: {} })

function extractErrors(err) {
    const data = err?.response?.data
    if (data?.errors)  return data.errors
    if (data?.message) return { general: data.message }
    return { general: 'Something went wrong. Please try again.' }
}

export function useProjects(initialProjects) {
    // ── List ──────────────────────────────────────────────
    const list = ref([...initialProjects.value])
    watch(initialProjects, val => { list.value = [...val] })

    // ── Toast ─────────────────────────────────────────────
    const toast = ref({ show: false, type: 'success', message: '' })
    let toastTimer = null
    function showToast(type, message) {
        clearTimeout(toastTimer)
        toast.value = { show: true, type, message }
        toastTimer  = setTimeout(() => (toast.value.show = false), 4500)
    }

    // ── Create ────────────────────────────────────────────
    const form = ref(EMPTY_FORM())

    async function saveProject(onSaved) {
        if (!form.value.title.trim()) return
        form.value.saving = true
        form.value.errors = {}

        const formData = new FormData()

        formData.append('title', form.value.title.trim())
        formData.append('description', form.value.description.trim())
        formData.append('role', form.value.role.trim())
        formData.append('link', form.value.link.trim())

        form.value.skill_ids.forEach(id => {
            formData.append('skill_ids[]', id)
        })

// image should be File or Blob
        if (form.value.image) {
            formData.append('image', form.value.image)
        }


        try {
            await axios.post('/project', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            showToast('success', `"${form.value.title}" was added successfully.`)
            form.value = EMPTY_FORM()
            onSaved?.()
        } catch (err) {
            form.value.errors = extractErrors(err)
            showToast('error', 'Failed to save project. Check the fields below.')
        } finally {
            form.value.saving = false
        }
    }

    // ── Edit ──────────────────────────────────────────────
    const editing = ref(EMPTY_EDITING())

    function startEdit(project) {
        editing.value = {
            id:          project.id,
            title:       project.title,
            description: project.description ?? '',
            skill_ids:   (project.skills ?? []).map(s => typeof s === 'object' ? s.id : s),
            role:        project.role  ?? '',
            link:        project.link  ?? '',
            image:       project.image ?? '',
            saving:      false,
            errors:      {},
        }
    }

    function cancelEdit() {
        editing.value = EMPTY_EDITING()
    }

    async function confirmEdit(project, onSaved) {
        if (!editing.value.title.trim()) return
        editing.value.saving = true
        editing.value.errors = {}

        const formData =  new FormData()

        formData.append('title', editing.value.title.trim())
        formData.append('description', editing.value.description.trim())
        formData.append('role', editing.value.role.trim())
        formData.append('link', editing.value.link.trim())
        formData.append('_method', 'PUT')

        editing.value.skill_ids.forEach(id => {
            formData.append('skill_ids[]', id)
        })
        if (editing.value.image) {
            formData.append('image', editing.value.image)
        }

        try {
            const { data } =    await axios.post(`/project/${project.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })

            const i = list.value.findIndex(p => p.id === project.id)
            if (i !== -1) list.value[i] = data
            showToast('success', `"${editing.value.title}" was updated successfully.`)
            cancelEdit()
            onSaved?.()
        } catch (err) {
            editing.value.errors = extractErrors(err)
            showToast('error', 'Failed to update project. Check the fields.')
        } finally {
            editing.value.saving = false
        }
    }

    // ── Delete ────────────────────────────────────────────
    const deleting = ref(null)

    async function deleteProject(project, onSaved) {
        if (!confirm(`Delete "${project.title}"? This cannot be undone.`)) return
        deleting.value = project.id
        try {
            await axios.delete(`/project/${project.id}`)
            list.value = list.value.filter(p => p.id !== project.id)
            showToast('success', `"${project.title}" was deleted.`)
            onSaved?.()
        } catch (err) {
            const errors = extractErrors(err)
            showToast('error', errors.general ?? 'Failed to delete project.')
        } finally {
            deleting.value = null
        }
    }

    return {
        list,
        toast,
        form,    saveProject,
        editing, startEdit, cancelEdit, confirmEdit,
        deleting, deleteProject,
    }
}

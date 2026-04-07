<template>
    <div class="flex flex-col">
        <label class="text-[0.72rem] font-medium text-[#78716c] uppercase tracking-wide mb-1.5">
            Image <span class="font-normal normal-case tracking-normal text-[#b5b0aa]">(optional, max 1 MB)</span>
        </label>

        <!-- Drop zone / preview -->
        <div
            class="relative flex items-center gap-3 bg-white border rounded-[10px] px-3.5 py-2.5 transition cursor-pointer"
            :class="[
                isDragging ? 'border-[#1c1917] shadow-[0_0_0_3px_rgba(28,25,23,0.07)] bg-[#f5f3f0]' : hasError ? 'border-red-400' : 'border-[#ddd9d4]',
                'focus-within:border-[#1c1917] focus-within:shadow-[0_0_0_3px_rgba(28,25,23,0.07)]'
            ]"
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="onDrop"
            @click="triggerInput"
        >
            <!-- Hidden file input -->
            <input
                ref="fileInput"
                type="file"
                accept="image/*"
                class="sr-only"
                :disabled="disabled || compressing"
                @change="onFileChange"
            />

            <!-- Thumbnail or placeholder icon -->
            <div class="flex-shrink-0 w-9 h-9 rounded-[7px] overflow-hidden border border-[#e5e3df] bg-[#f5f3f0] flex items-center justify-center">
                <img
                    v-if="preview"
                    :src="preview"
                    alt="Preview"
                    class="w-full h-full object-cover"
                />
                <svg v-else class="w-[18px] h-[18px] text-[#c0bbb5]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                </svg>
            </div>

            <!-- Label / status text -->
            <div class="flex-1 min-w-0">
                <p v-if="compressing" class="m-0 text-[0.8125rem] text-[#78716c] flex items-center gap-1.5">
                    <span class="inline-block w-3 h-3 border-2 border-[#c0bbb5] border-t-[#78716c] rounded-full animate-spin flex-shrink-0"></span>
                    Compressing…
                </p>
                <p v-else-if="fileName" class="m-0 text-[0.8125rem] text-[#1c1917] font-medium truncate">{{ fileName }}</p>
                <p v-else class="m-0 text-[0.8125rem] text-[#c0bbb5]">Click or drag & drop an image…</p>
                <p v-if="sizeLabel && !compressing" class="m-0 mt-0.5 font-mono text-[0.68rem] text-[#a8a29e]">{{ sizeLabel }}</p>
            </div>

            <!-- Clear button -->
            <button
                v-if="preview && !compressing"
                type="button"
                @click.stop="clear"
                class="flex-shrink-0 flex items-center justify-center w-6 h-6 rounded-full bg-[#f0ede9] border border-[#e5e3df] text-[#a8a29e] hover:text-red-400 hover:border-red-200 hover:bg-[#fff5f5] transition-colors bg-transparent border-none cursor-pointer p-0"
            >
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <p v-if="error" class="mt-1 text-[0.7rem] text-red-400">{{ error }}</p>
        <p v-else-if="externalError" class="mt-1 text-[0.7rem] text-red-400">
            {{ Array.isArray(externalError) ? externalError[0] : externalError }}
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    modelValue: { type: String, default: '' },   // base64 data URL
    disabled: { type: Boolean, default: false },
    externalError: { default: null },
})

const emit = defineEmits(['update:modelValue'])

const fileInput   = ref(null)
const preview     = ref(`/storage/${props.modelValue}` || '')
const fileName    = ref('')
const sizeLabel   = ref('')
const isDragging  = ref(false)
const compressing = ref(false)
const error       = ref('')

const compressedFile = ref(null)

watch(() => props.modelValue, val => {
    if (!val) { preview.value = ''; fileName.value = ''; sizeLabel.value = '' }
})

const MAX_BYTES = 1 * 1024 * 1024   // 1 MB target output

function triggerInput() {
    if (!props.disabled && !compressing.value) fileInput.value?.click()
}

function onDrop(e) {
    isDragging.value = false
    const file = e.dataTransfer?.files?.[0]
    if (file) processFile(file)
}

function onFileChange(e) {
    const file = e.target.files?.[0]
    if (file) processFile(file)
    e.target.value = ''   // reset so same file can be re-selected
}

async function processFile(file) {
    error.value = ''
    if (!file.type.startsWith('image/')) {
        error.value = 'Please select an image file.'
        return
    }

    compressing.value = true
    fileName.value = file.name

    try {
        const blob = await compressImage(file, MAX_BYTES)

        // store compressed file
        compressedFile.value = new File([blob], file.name, {
            type: 'image/jpeg'
        })

        // preview with blob URL
        if (preview.value) URL.revokeObjectURL(preview.value)
        preview.value = URL.createObjectURL(blob)

        sizeLabel.value = formatBytes(blob.size)

        // send file instead of base64
        emit('update:modelValue', compressedFile.value)

    } catch (e) {
        error.value = e.message ?? 'Failed to process image.'
    } finally {
        compressing.value = false
    }
}

/**
 * Compress an image File to a target byte budget using a canvas.
 * Iteratively reduces JPEG quality until the base64 output fits within maxBytes.
 */
function compressImage(file, maxBytes) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader()
        reader.onerror = () => reject(new Error('Could not read file. \n please Make sure the image size, \n type and dimentions are as recommended.'))
        reader.onload = (e) => {
            const img = new Image()
            img.onerror = () => reject(new Error('Could not load image.'))
            img.onload = () => {
                const canvas = document.createElement('canvas')
                const ctx    = canvas.getContext('2d')

                // Scale down if very large — cap longest side at 2000px
                let { width, height } = img
                const MAX_DIM = 2000
                if (width > MAX_DIM || height > MAX_DIM) {
                    const ratio = Math.min(MAX_DIM / width, MAX_DIM / height)
                    width  = Math.round(width  * ratio)
                    height = Math.round(height * ratio)
                }

                canvas.width  = width
                canvas.height = height
                ctx.drawImage(img, 0, 0, width, height)

                // Try decreasing quality until we hit budget
                let quality = 0.92
                let dataUrl = canvas.toDataURL('image/jpeg', quality)

                while (dataUrl.length * 0.75 > maxBytes && quality > 0.1) {
                    quality = Math.max(quality - 0.08, 0.1)
                    dataUrl = canvas.toDataURL('image/jpeg', quality)
                }

                // If still over budget at minimum quality, reduce dimensions too
                if (dataUrl.length * 0.75 > maxBytes) {
                    let scale = 0.8
                    while (dataUrl.length * 0.75 > maxBytes && scale > 0.2) {
                        canvas.width  = Math.round(width  * scale)
                        canvas.height = Math.round(height * scale)
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height)
                        // keep last quality
                        scale  -= 0.1
                    }
                }

                canvas.toBlob((blob) => {
                    if (!blob) return reject(new Error('Compression failed'))
                    resolve(blob)
                }, 'image/jpeg', quality)
            }
            img.src = e.target.result
        }
        reader.readAsDataURL(file)
    })
}

function clear() {
    if (preview.value) URL.revokeObjectURL(preview.value)

    preview.value  = ''
    fileName.value = ''
    sizeLabel.value = ''
    error.value    = ''
    compressedFile.value = null

    emit('update:modelValue', null)
}

function formatBytes(bytes) {
    if (bytes < 1024)       return `${bytes} B`
    if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`
    return `${(bytes / (1024 * 1024)).toFixed(2)} MB`
}

const hasError = computed => !!(error.value || props.externalError)
</script>

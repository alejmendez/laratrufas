<script setup>
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps({
  imagePreview: {
    type: Boolean,
    default: false,
  },
  accept: {
    type: String,
    default: 'image/*',
  },
  image: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['change'])

const fileInput = ref(null)
const fileRemove = ref(false)
const filePreview = ref(null)

const preview = computed(() => {
  if (fileRemove.value) {
    return null
  }
  if (filePreview.value) {
    return filePreview.value
  }

  return props.image
})

const changeFileHandler = (e) => {
  const [file] = e.target.files
  emit('change', {
    fileRemove: fileRemove.value,
    fileInput: fileInput.value,
  })
  if (file) {
    fileRemove.value = false
    filePreview.value = URL.createObjectURL(file)
  }
}

const fileRemoveHandler = () => {
  fileRemove.value = true
  fileInput.value.value = null
  filePreview.value = null
  emit('change', {
    fileRemove: fileRemove.value,
    fileInput: fileInput.value,
  })
}
</script>

<template>
  <div class="flex flex-row gap-x-5">
    <div v-if="props.imagePreview">
      <div
        class="w-32 border rounded-md"
        :class="{ 'h-full': !preview }"
      >
        <img
          class="w-full"
          :src="preview"
          v-if="preview"
        />
      </div>
    </div>
    <div class="w-full">
      <div class="mb-2 w-full">{{ t('generics.form.file.select_a_image') }}</div>
      <input
        ref="fileInput"
        type="file"
        className="input-file mb-4"
        style="width: 160px;"
        :accept="accept"
        @change="changeFileHandler"
      />
      <button
        class="btn btn-secondary"
        @click.prevent="fileRemoveHandler"
      >
        {{ t('generics.form.file.remove_image') }}
      </button>
    </div>
  </div>
</template>

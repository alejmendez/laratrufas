<script setup>
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';

import { Button } from '@/Components/ui/button';
import VInput from '@/Components/form/VInput.vue';

const { t } = useI18n();

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
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  withRemove: {
    type: Boolean,
    default: true,
  },
  showPathFile: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['change']);

const fileInput = ref(null);
const fileRemove = ref(false);
const filePreview = ref(null);
const filePath = ref('');

const preview = computed(() => {
  if (fileRemove.value) {
    return null;
  }
  if (filePreview.value) {
    return filePreview.value;
  }

  return props.image;
});

const changeFileHandler = (e) => {
  const [file] = e.target.files;
  emit('change', {
    fileRemove: false,
    fileInput: file,
  });
  if (file) {
    fileRemove.value = false;
    filePreview.value = URL.createObjectURL(file);
    filePath.value = file.name;
  }
};

const fileRemoveHandler = () => {
  fileRemove.value = true;
  fileInput.value.value = null;
  filePreview.value = null;
  emit('change', {
    fileRemove: true,
    fileInput: null,
  });
};

const selectFile = () => {
  fileInput.value.click();
};
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
      <div class="mb-2 w-full">{{ props.label }}</div>
      <input
        ref="fileInput"
        type="file"
        class="hidden"
        :accept="accept"
        @change="changeFileHandler"
      />

      <div class="flex max-w-md items-center">
        <div class="border p-2 grow h-[40px] truncate rounded-s" :title="filePath">{{ filePath }}</div>
        <Button

          class="bg-gray-300 text-gray-800 hover:bg-gray-300/80 rounded-s-none"
          @click.prevent="selectFile"
        >
          {{ t('generics.form.file.upload_file') }}
        </Button>
      </div>
      <div class="text-slate-500 text-sm">Las imágenes no debe superar 5 mb</div class="">
      <Button
        variant="secondary"
        v-if="props.withRemove"
        class="bg-white text-slate-500 border-slate-500 border hover:slate-500/80 mt-4"
        @click.prevent="fileRemoveHandler"
      >
        {{ t('generics.form.file.remove_image') }}
      </Button>
    </div>
  </div>
</template>

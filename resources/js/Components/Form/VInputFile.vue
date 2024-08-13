<script setup>
import { ref, computed } from 'vue';
import InputGroup from 'primevue/inputgroup';

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
  <div class="md:flex md:flex-row gap-x-5">
    <div class="min-h-[150px]" v-if="props.imagePreview">
      <div
        class="w-32 min-h-[150px] border rounded-md"
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

      <div class="md:w-[420px] max-w-full sm:hidden md:block">
        <InputGroup>
          <div class="border p-2 grow truncate rounded-s border-e-0" :title="filePath">{{ filePath }}</div>
          <Button
            severity="secondary"
            class="bg-gray-300 text-gray-800 hover:bg-gray-300/80"
            @click.prevent="selectFile"
            :label="$t('generics.form.file.upload_file')"
          />
        </InputGroup>
      </div>
      <div class="md:w-[420px] max-w-full sm:block md:hidden">
        <InputGroup>
          <div class="border p-2 grow truncate rounded-s border-e-0" :title="filePath">{{ filePath }}</div>
          <Button
            severity="secondary"
            class="bg-gray-300 text-gray-800 hover:bg-gray-300/80"
            @click.prevent="selectFile"
            icon="pi pi-cloud-upload"
          />
        </InputGroup>
      </div>
      <div class="text-slate-500 text-sm">Los archivos no debe superar 5 mb</div class="">
      <Button
        severity="secondary"
        v-if="props.withRemove"
        class="mt-4"
        @click.prevent="fileRemoveHandler"
        :label="$t('generics.form.file.remove_image')"
      />
    </div>
  </div>
</template>

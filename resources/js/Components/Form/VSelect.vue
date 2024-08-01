<script setup>
import { useAttrs, ref, onMounted, watch } from 'vue';

import Select from 'primevue/select';

const model = defineModel();

const attrs = useAttrs();

const props = defineProps({
  classWrapper: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  options: {
    type: Array,
    default: [],
  },
  message: {
    type: String,
  },
  autofocus: {
    type: Boolean,
    default: false,
  },
});

watch(
  () => props.options,
  async (newValue, _) => {
    if (!newValue.find((v) => v.value.toString() === model.value)) {
      model.value = '';
    }
  },
);

const emit = defineEmits(['change', 'blur']);
const input = ref(null);

onMounted(() => {
  if (props.autofocus) {
    input.value.focus();
  }
});
</script>

<template>
  <div :class="props.classWrapper">
    <Label :for="attrs.id" v-if="props.label !== ''">
      {{ props.label }}
    </Label>

    <Select
      class="h-10 mt-1"
      v-bind="attrs"
      v-model="model"
      fluid
      ref="input"
      optionLabel="text"
      :options="options"
    />

    <div v-show="message">
      <p class="text-sm text-red-600">
        {{ message }}
      </p>
    </div>
  </div>
</template>

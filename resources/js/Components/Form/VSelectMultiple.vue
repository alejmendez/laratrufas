<script setup>
import { useAttrs, computed } from 'vue';

import MultiSelect from 'primevue/multiselect';

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
});

const emit = defineEmits(['change', 'blur']);
const isInvalid = computed(() => props.message !== '' && props.message !== undefined);
</script>

<template>
  <div :class="props.classWrapper">
    <Label
      :class="{ 'text-red-600' : isInvalid }"
      :for="attrs.id"
      v-if="props.label !== ''"
    >
      {{ props.label }}
    </Label>

    <MultiSelect
      class="w-full h-10 mt-1"
      v-model="model"
      v-bind="attrs"
      :options="options"
      filter
      optionLabel="text"
      :maxSelectedLabels="3"
      :invalid="isInvalid"
    >
      <template #optiongroup="slotProps">
        <div class="flex items-center">
          <div>{{ slotProps.option.text }}</div>
        </div>
      </template>
    </MultiSelect>

    <div v-show="message">
      <p class="text-sm text-red-600">
        {{ message }}
      </p>
    </div>
  </div>
</template>

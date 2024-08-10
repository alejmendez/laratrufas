<script setup>
import { useAttrs, computed } from 'vue';

import InputText from 'primevue/inputtext';

import Textarea from 'primevue/textarea';
import VInputDate from '@/Components/Form/VInputDate.vue';
import VElementFormWrapper from '@/Components/Form/VElementFormWrapper.vue';

const model = defineModel();

const attrs = useAttrs();

const props = defineProps({
  classWrapper: {
    type: String,
    default: '',
  },
  type: {
    type: String,
    default: 'text',
  },
  label: {
    type: String,
    default: '',
  },
  message: {
    type: String,
  },
  autofocus: {
    type: Boolean,
    default: false,
  },
  renderText: {
    type: Function,
  },
});

const emit = defineEmits(['change', 'input', 'click', 'focus', 'blur', 'keydown']);

const isInvalid = computed(() => props.message !== '' && props.message !== undefined);
</script>

<template>
  <VElementFormWrapper :classWrapper="props.classWrapper" :label="props.label" :message="props.message">
    <template v-if="props.type === 'date'">
      <VInputDate
        v-bind="attrs"
        v-model="model"
        ref="input"
        fluid
        :invalid="isInvalid"
        @change="emit('change', $event)"
        @input="emit('input', $event)"
        @focus="emit('focus', $event)"
        @blur="emit('blur', $event)"
        @keydown="emit('keydown', $event)"
      />
    </template>
    <template v-else-if="props.type === 'textarea'">
      <Textarea
        ref="input"
        v-bind="attrs"
        v-model="model"
        fluid
        rows="5"
        :invalid="isInvalid"
        @update:modelValue="emit('change', $event)"
        @input="emit('input', $event)"
        @click="emit('click', $event)"
        @focus="emit('focus', $event)"
        @blur="emit('blur', $event)"
        @keydown="emit('keydown', $event)"
      />
    </template>
    <template v-else>
      <InputText
        ref="input"
        v-bind="attrs"
        v-model="model"
        fluid
        :type="props.type"
        :invalid="isInvalid"
        @update:modelValue="emit('change', $event)"
        @input="emit('input', $event)"
        @click="emit('click', $event)"
        @focus="emit('focus', $event)"
        @blur="emit('blur', $event)"
        @keydown="emit('keydown', $event)"
      />
    </template>
  </VElementFormWrapper>
</template>

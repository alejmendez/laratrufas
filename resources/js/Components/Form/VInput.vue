<script setup>
import { useAttrs, ref, onMounted } from 'vue';

import InputText from 'primevue/inputtext';

import Textarea from 'primevue/textarea';
import VInputDate from './VInputDate.vue';

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

    <template v-if="props.type === 'date'">
      <VInputDate
        v-bind="attrs"
        v-model="model"
        ref="input"
        fluid
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
      />
    </template>
    <template v-else-if="props.type === 'textarea'">
      <Textarea
        class="mt-1"
        ref="input"
        v-bind="attrs"
        v-model="model"
        fluid
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
        rows="5"
      />
    </template>
    <template v-else>
      <InputText
        class="h-10 mt-1"
        ref="input"
        v-bind="attrs"
        v-model="model"
        :type="props.type"
        fluid
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
      />
    </template>

    <div v-show="message">
      <p class="text-sm text-red-600">
        {{ message }}
      </p>
    </div>
  </div>
</template>

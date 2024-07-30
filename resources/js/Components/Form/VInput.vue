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
  disabled: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
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
  maxDate: {
    type: Object,
  },
  minDate: {
    type: Object,
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
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
        v-model="model"
        ref="input"
        :placeholder="props.placeholder"
        :renderText="props.renderText"
        :minDate="props.minDate"
        :maxDate="props.maxDate"
      />
    </template>
    <template v-else-if="props.type === 'textarea'">
      <Textarea
        class="w-full mt-1"
        ref="input"
        v-bind="attrs"
        v-model="model"
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
        rows="5"
      />
    </template>
    <template v-else>
      <InputText
        class="h-10 w-full mt-1"
        ref="input"
        v-bind="attrs"
        v-model="model"
        :type="props.type"
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

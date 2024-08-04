<script setup>
import { useAttrs, ref, onMounted, computed } from 'vue';

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

const emit = defineEmits(['change', 'input', 'click', 'focus', 'blur', 'keydown']);

const input = ref(null);

const isInvalid = computed(() => props.message !== '' && props.message !== undefined)

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
        class="mt-1"
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
        class="h-10 mt-1"
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

    <div v-show="props.message">
      <p class="text-sm text-red-600">
        {{ props.message }}
      </p>
    </div>
  </div>
</template>

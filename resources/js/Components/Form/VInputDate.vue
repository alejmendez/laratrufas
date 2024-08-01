<script setup>
import { useAttrs } from 'vue';
import { format } from 'date-fns';

import DatePicker from 'primevue/datepicker';

const model = defineModel();
const attrs = useAttrs();

const props = defineProps({
  renderText: {
    type: Function,
    default: (m) => format(m, 'dd/MM/yyyy'),
  },
});

const emit = defineEmits(['change', 'input', 'focus', 'blur', 'keydown']);
</script>

<template>
  <DatePicker
    class="h-10 mt-1"
    v-bind="attrs"
    v-model="model"
    :dateFormat="props.dateFormat"
    :showIcon="true"
    @update:modelValue="emit('change', $event)"
    @input="emit('input', $event)"
    @focus="emit('focus', $event)"
    @blur="emit('blur', $event)"
    @keydown="emit('keydown', $event)"
  />
</template>

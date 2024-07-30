<script setup>
import { useAttrs, watch } from 'vue';
import { format } from 'date-fns';

import DatePicker from 'primevue/datepicker';

const model = defineModel();
const attrs = useAttrs();

const props = defineProps({
  placeholder: {
    type: String,
  },
  maxDate: {
    type: Object,
  },
  minDate: {
    type: Object,
  },
  renderText: {
    type: Function,
    default: (m) => format(m, 'dd/MM/yyyy'),
  },
});

const emit = defineEmits(['change', 'blur']);

watch(model, async (newValue, _) => {
  emit('change', newValue);
});
</script>

<template>
  <DatePicker
    class="w-full h-10 mt-1"
    v-bind="attrs"
    v-model="model"
    dateFormat="dd/mm/yy"
    :showIcon="true"
  />
</template>

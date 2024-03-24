<script setup>
import { useAttrs } from 'vue';
import VInput from '@/Components/form/VInput.vue';

const model = defineModel();

const attrs = useAttrs();

const dniMask = {
  mask: '##.###.###-K',
  tokens: {
    '#': { pattern: /\d/ },
    K: {
      pattern: /[0-9kK]/,
      transform: (v) => v.toLocaleUpperCase(),
    },
  },
};
</script>

<template>
  <VInput
    v-bind="attrs"
    v-model="model"
    v-mask="dniMask"
  />
</template>

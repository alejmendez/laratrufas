<script setup>
import { useAttrs } from 'vue';

import Checkbox from 'primevue/checkbox';
const attrs = useAttrs();
</script>

<template>
  <Checkbox v-bind="attrs" :binary="true" />
</template>

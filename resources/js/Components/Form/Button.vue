<script setup>
import { useAttrs } from 'vue';
import ButtonPrime from 'primevue/button';

const attrs = useAttrs();
</script>

<template>
  <ButtonPrime
    v-bind="attrs"
  />
</template>

<script setup>
import { useAttrs, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import ButtonPrime from 'primevue/button';

const attrOriginal = useAttrs();
const attrs = computed(() => {
  const { href, onClick, ...rest } = attrOriginal;
  return rest;
});

if (attrOriginal.href && !attrOriginal.onClick) {
  attrs.value.onClick = () => {
    router.visit(attrOriginal.href);
  };
}
</script>

<template>
  <ButtonPrime v-bind="attrs" />
</template>

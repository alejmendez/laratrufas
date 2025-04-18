<script setup>
import { useAttrs } from 'vue';
import ButtonPrime from 'primevue/button';
import { Link } from '@inertiajs/vue3';

const attrs = useAttrs();
</script>

<template>
  <template v-if="attrs.as === 'Link'">
    <ButtonPrime v-bind="attrs">
      <Link :href="attrs.href">
        {{ attrs.label }}
      </Link>
    </ButtonPrime>
  </template>
  <template v-else>
    <ButtonPrime v-bind="attrs" />
  </template>
</template>

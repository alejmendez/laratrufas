<script setup>
import { useAttrs } from 'vue';
import ButtonPrime from 'primevue/button';
import { Link } from '@inertiajs/vue3';

const attrs = useAttrs();
</script>

<template>
  <template v-if="attrs.as === 'Link'">
    <ButtonPrime asChild v-slot="slotProps">
      <Link :href="attrs.href" v-bind="slotProps">
        {{ attrs.label }}
      </Link>
    </ButtonPrime>
  </template>
  <template v-else>
    <ButtonPrime v-bind="attrs" />
  </template>
</template>

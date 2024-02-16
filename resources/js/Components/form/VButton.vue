<script setup>
import { useAttrs } from 'vue'

const attrs = useAttrs()

const props = defineProps({
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['click'])
</script>

<template>
  <button
    v-bind="attrs"
    class="btn-primary"
    @click="emit('click', $event)"
    :disabled="props.disabled"
  >
    <slot />
  </button>
</template>

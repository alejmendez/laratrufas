<script setup>
import { useAttrs } from 'vue'

const model = defineModel({ default: false })

const attrs = useAttrs()

const props = defineProps({
  classWrapper: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  },
  label: {
    type: String,
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['click'])
</script>

<template>
  <div :class="props.classWrapper">
    <template v-if="props.label === ''">
      <input
        v-bind="attrs"
        class="checkbox"
        type="checkbox"
        :disabled="props.disabled"
        @click="emit('click', $event)"
        v-model="model"
      />
    </template>
    <template v-else>
      <label class="text-sm text-gray-800">
        <input
          v-bind="attrs"
          type="checkbox"
          class="checkbox"
          :disabled="props.disabled"
          @click="emit('click', $event)"
          v-model="model"
        />
        {{ props.label }}
      </label>
    </template>
  </div>
</template>

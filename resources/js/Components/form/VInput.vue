<script setup>
import { useAttrs } from 'vue'

const model = defineModel()

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

const emit = defineEmits(['change', 'blur'])
</script>

<template>
  <div :class="props.classWrapper">
    <template v-if="props.label === ''">
      <input
        v-bind="attrs"
        class="input"
        :type="props.type"
        :disabled="props.disabled"
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
        v-model="model"
      />
    </template>
    <template v-else>
      <label class="block text-sm text-gray-800">
        {{ props.label }}
        <input
          v-bind="attrs"
          class="input"
          :type="props.type"
          :disabled="props.disabled"
          @change="emit('change', $event)"
          @blur="emit('blur', $event)"
          v-model="model"
        />
      </label>
    </template>
  </div>
</template>

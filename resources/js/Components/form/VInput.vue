<script setup>
import { useAttrs, ref, onMounted } from 'vue'

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
  },
  message: {
    type: String,
  },
})

const emit = defineEmits(['change', 'blur'])
const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
  <div :class="props.classWrapper">
    <label :for="attrs.id" class="input-label" v-if="props.label !== ''">
      {{ props.label }}
    </label>

    <input
      v-bind="attrs"
      class="input"
      :type="props.type"
      :disabled="props.disabled"
      @change="emit('change', $event)"
      @blur="emit('blur', $event)"
      v-model="model"
      ref="input"
    />

    <div v-show="message">
      <p class="text-sm text-red-600">
          {{ message }}
      </p>
    </div>
  </div>
</template>
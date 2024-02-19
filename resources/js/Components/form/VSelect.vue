<script setup>
import { useAttrs, ref, onMounted } from 'vue'

const model = defineModel()

const attrs = useAttrs()

const props = defineProps({
  classWrapper: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: ''
  },
  options: {
    type: Array,
    default: []
  },
  placeholder: {
    type: String
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

    <select
      class="input"
      v-bind="attrs"
      :disabled="props.disabled"
      @change="emit('change', $event)"
      @blur="emit('blur', $event)"
      v-model="model"
      ref="input"
    >
      <option v-if="props.placeholder" value="">{{ props.placeholder }}</option>
      <option
        v-for="option in options"
        :key="option.value"
        :value="option.value"
      >
        {{ option.text }}
      </option>
    </select>

    <div v-show="message">
      <p class="text-sm text-red-600">
        {{ message }}
      </p>
    </div>
  </div>
</template>

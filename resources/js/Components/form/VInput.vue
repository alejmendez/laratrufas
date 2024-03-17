<script setup>
import { useAttrs, ref, onMounted } from 'vue'
import { Input as InputShadcn } from '@/Components/ui/input'
import { Label as LabelShadcn } from '@/Components/ui/label'
import VInputDate from './VInputDate.vue'

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
  autofocus: {
    type: Boolean,
    default: false,
  },
  maxDate: {
    type: Object,
  },
  minDate: {
    type: Object,
  },
})

const emit = defineEmits(['change', 'blur'])
const input = ref(null);

onMounted(() => {
  if (props.autofocus) {
    input.value.focus();
  }
});
</script>

<template>
  <div :class="props.classWrapper">
    <LabelShadcn :for="attrs.id" class="input-label" v-if="props.label !== ''">
      {{ props.label }}
    </LabelShadcn>

    <template v-if="props.type === 'date'">
      <VInputDate
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
        v-model="model"
        ref="input"
        :minDate="props.minDate"
        :maxDate="props.maxDate"
      />
    </template>
    <template v-else>
      <InputShadcn
        v-bind="attrs"
        class="input mt-1"
        :type="props.type"
        :disabled="props.disabled"
        @change="emit('change', $event)"
        @blur="emit('blur', $event)"
        v-model="model"
        ref="input"
      />
    </template>

    <div v-show="message">
      <p class="text-sm text-red-600">
          {{ message }}
      </p>
    </div>
  </div>
</template>

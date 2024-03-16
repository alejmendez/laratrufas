<script setup>
import { useAttrs, ref, onMounted } from 'vue'
import { Input } from '@/Components/ui/input'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/Components/ui/select'

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
  autofocus: {
    type: Boolean,
    default: false,
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
    <Label :for="attrs.id" class="input-label" v-if="props.label !== ''">
      {{ props.label }}
    </Label>

    <Select
      class="input"
      v-bind="attrs"
      :disabled="props.disabled"
      @change="emit('change', $event)"
      @blur="emit('blur', $event)"
      v-model="model"
      ref="input"
    >
      <SelectTrigger class="w-full">
        <SelectValue v-if="props.placeholder" :placeholder="props.placeholder" />
      </SelectTrigger>

      <SelectContent>
        <SelectGroup>
          <SelectItem
            v-for="option in options"
            :key="option.value"
            :value="option.value"
          >
          {{ option.text }}
          </SelectItem>
        </SelectGroup>
      </SelectContent>
    </Select>

    <div v-show="message">
      <p class="text-sm text-red-600">
        {{ message }}
      </p>
    </div>
  </div>
</template>

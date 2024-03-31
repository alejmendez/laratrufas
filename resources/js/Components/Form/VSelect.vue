<script setup>
import { useAttrs, ref, onMounted, watch } from 'vue';
import { Label as LabelShadcn } from '@/Components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/Components/ui/select';

const model = defineModel();

const attrs = useAttrs();

const props = defineProps({
  classWrapper: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  options: {
    type: Array,
    default: [],
  },
  placeholder: {
    type: String,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  message: {
    type: String,
  },
  autofocus: {
    type: Boolean,
    default: false,
  },
});

watch(
  () => props.options,
  async (newValue, _) => {
    if (!newValue.find((v) => v.value.toString() === model.value)) {
      model.value = '';
    }
  },
);

const emit = defineEmits(['change', 'blur']);
const input = ref(null);

const changeHandler = (value) => {
  model.value = value;
  emit('change', value);
};

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

    <Select
      class="input"
      :disabled="props.disabled"
      @update:modelValue="changeHandler"
      v-model="model"
      ref="input"
    >
      <SelectTrigger class="w-full mt-1">
        <SelectValue v-if="props.placeholder" :placeholder="props.placeholder" />
      </SelectTrigger>

      <SelectContent>
        <SelectGroup>
          <SelectItem
            v-for="option in options"
            :key="option.value.toString()"
            :value="option.value.toString()"
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

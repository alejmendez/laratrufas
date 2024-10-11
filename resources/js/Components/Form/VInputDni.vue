<script setup>
import { useAttrs } from 'vue';

const model = defineModel();

const attrs = useAttrs();

const formatRut = (input) => {
  let str = input.toString();

  let formatted = '';

  if (str.length <= 2) {
    return str;
  }

  let dv = str.slice(-1);
  str = str.slice(0, -1);

  for (let i = str.length - 1, j = 1; i >= 0; i--, j++) {
    formatted = str.charAt(i) + formatted;
    if (j % 3 === 0 && i !== 0) {
      formatted = '.' + formatted;
    }
  }

  return formatted.length > 0 ? formatted + '-' + dv : dv;
};

const handlerInput = (e) => {
  const rutValue = e.target.value.replace(/\D/g, '');
  const rutFormated = formatRut(rutValue);
  e.target.value = rutFormated
  model.value = rutFormated;
};
</script>

<template>
  <VInput
    v-bind="attrs"
    v-model="model"
    @input="handlerInput"
  />
</template>

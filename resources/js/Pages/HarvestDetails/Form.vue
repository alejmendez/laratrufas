<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { QrcodeStream } from 'vue-qrcode-reader';

import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import { Button } from '@/Components/ui/button';
import { findByCode } from '@/Services/Plant.js';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  qualities: Array,
  submitHandler: Function,
  submitAndLoadAnother: Function,
});

const form = props.form;

const paused = ref(!!form.plant_code);
const hasError = ref(false);

const onDetect = async (detectedCodes) => {
  paused.value = true;
  form.plant_code = detectedCodes[0].rawValue;
  const plant = await findByCode(form.plant_code);
  if (!plant) {
    hasError.value = true;
  }
};

const resetQr = () => {
  paused.value = false;
  hasError.value = false;
  form.plant_code = null;
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <div class="mb-5">
      <QrcodeStream
        :paused="paused"
        @detect="onDetect"
      >
        <div
          v-if="form.plant_code"
          @click="resetQr"
          class="feedback"
          :class="{ 'text-red-800' : hasError }"
        >
          {{ hasError ? t('harvest.errors.details.plant_code_not_found', { plant_code: form.plant_code }) : form.plant_code }}
          <font-awesome-icon :icon="['fas', 'rotate-right']" class="mt-3" />
        </div>
      </QrcodeStream>
      <div v-show="form.errors.plant_code">
        <p class="text-sm text-red-600">
          {{ form.errors.plant_code }}
        </p>
      </div>
    </div>

    <VSelect
      id="quality"
      v-model="form.quality"
      :placeholder="t('generics.please_select')"
      :options="props.qualities"
      :label="t('harvest.form.details.quality.label')"
      :message="form.errors.quality"
    />

    <VInput
      id="weight"
      v-model="form.weight"
      type="number"
      min="0"
      max="2000"
      step="0.01"
      :label="t('harvest.form.details.weight.label')"
      :message="form.errors.weight"
    />

    <div class="mt-20">
      <Button
        variant="secondary"
        class="w-full text-xl h-16"
        :disabled="form.processing || hasError"
        @click="props.submitAndLoadAnother"
      >
        <font-awesome-icon
          class="animate-spin me-1"
          :icon="['fas', 'circle-notch']"
          v-show="form.processing"
        />
        Guardar y cargar otra
      </Button>

      <Button
        class="w-full mt-3 text-xl h-16"
        :disabled="form.processing || hasError"
        @click="props.submitHandler"
      >
        <font-awesome-icon
          class="animate-spin me-1"
          :icon="['fas', 'circle-notch']"
          v-show="form.processing"
        />
        Guardar
      </Button>
    </div>
  </form>
</template>

<style>
.feedback {
  position: absolute;
  width: 100%;
  height: 100%;

  background-color: rgba(255, 255, 255, 0.9);
  padding: 10px;
  text-align: center;
  font-weight: bold;
  font-size: 1.8rem;

  display: flex;
  flex-flow: column nowrap;
  justify-content: center;
}
</style>

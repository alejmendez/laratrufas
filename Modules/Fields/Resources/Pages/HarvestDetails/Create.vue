<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { QrcodeStream } from 'vue-qrcode-reader';

import InputGroup from 'primevue/inputgroup';
import InputText from 'primevue/inputtext';
import ButtonPrime from 'primevue/button';

import { findByCode } from '@/Services/Plant.js';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { t } = useI18n();

const props = defineProps({
  qualities: Array,
  plant_code: String,
});

const form = useForm({
  plant_code: props.plant_code || null,
  quality: null,
  weight: null,
  keep_plant_code: false,
  height: null,
  crown_diameter: null,
  invasion_radius: null,
  trunk_diameter: null,
  root_diameter: null,
  foliage_sanitation: null,
  foliage_sanitation_photo: null,
  trunk_sanitation: null,
  trunk_sanitation_photo: null,
  soil_sanitation: null,
  soil_sanitation_photo: null,
  irrigation_system: null,
});

const DEFAULT_OPTION_VIEW = 'main';

const optionViews = ['harvest', 'variables', 'logbook', 'location'];

const plantCodeToFind = ref('');
const optionView = ref(props.plant_code === null ? '' : optionViews[0]);

const _submitHandler = (keep_plant_code) => {
  form.keep_plant_code = keep_plant_code;

  if (optionView.value === optionViews[0]) {
    form.post(route('harvests.details.store'), options);
    optionView.value = keep_plant_code ? optionViews[0] : '';
    return;
  }

  if (optionView.value === optionViews[1]) {
    const options = {};
    if ([form.foliage_sanitation_photo, form.trunk_sanitation_photo, form.soil_sanitation_photo].some((d) => d != null)) {
      options.forceFormData = true;
    }
    form.post(route('plant.details.store'), options);
    resetQr();
  }
};

const submitHandler = () => _submitHandler(false);
const submitAndLoadAnother = () => _submitHandler(true);

const paused = ref(!!form.plant_code);
const hasError = ref(false);

const onDetect = async (detectedCodes) => {
  await findPlantByCode(detectedCodes[0].rawValue);
};

const findPlantByCode = async (plant_code) => {
  paused.value = true;
  hasError.value = false;
  form.plant_code = plant_code;
  plantCodeToFind.value = plant_code;
  const { plant, details } = await findByCode(form.plant_code);
  if (!plant) {
    optionView.value = '';
    hasError.value = true;
    return;
  }

  optionView.value = DEFAULT_OPTION_VIEW;
};

const resetQr = () => {
  paused.value = false;
  hasError.value = false;
  form.plant_code = null;
  plantCodeToFind.value = '';
  optionView.value = '';
};
</script>

<template>
  <Head :title="t('harvest.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }]"
    />
    <h3 class="text-2xl mb-3 input-label">
      {{ t('harvest_details.titles.find', { code: form.plant_code }) }}
    </h3>

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
      <div class="py-5 text-center dark:text-gray-100">
        {{ t('harvest_details.form.plant_code_to_find.label') }}
      </div>
      <div>
        <InputGroup>
          <InputText
            class="text-center"
            v-model="plantCodeToFind"
            size="large"
          />
          <ButtonPrime icon="pi pi-search" class="!w-[60px]" @click="findPlantByCode(plantCodeToFind)" />
        </InputGroup>
      </div>
      <div v-show="form.errors.plant_code">
        <p class="text-sm text-red-600">
          {{ form.errors.plant_code }}
        </p>
      </div>
    </div>

    <form @submit.prevent="_submitHandler">
      <div v-show="optionView === DEFAULT_OPTION_VIEW">
        <Button
          v-for="option in optionViews"
          class="w-full mt-3 text-xl h-16"
          :loading="form.processing"
          :disabled="hasError"
          :label="t(`harvest_details.buttons.${option}`)"
          @click="optionView = option"
        />
      </div>

      <div v-show="optionView === optionViews[0]">
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
          :min="0"
          :max="2000"
          :step="0.01"
          :label="t('harvest.form.details.weight.label')"
          :message="form.errors.weight"
        />

        <div class="mt-20 mb-20">
          <Button
            class="w-full text-xl h-16"
            severity="secondary"
            :loading="form.processing"
            :disabled="hasError"
            @click="submitAndLoadAnother"
            label="Guardar y cargar otra"
          />

          <Button
            class="w-full mt-3 text-xl h-16"
            :loading="form.processing"
            :disabled="hasError"
            @click="submitHandler"
            label="Guardar"
          />

          <Button
            class="w-full mt-3 text-xl h-16"
            :loading="form.processing"
            :disabled="hasError"
            severity="danger"
            @click="resetQr"
            label="Cancelar"
          />
        </div>
      </div>

      <div v-show="optionView === optionViews[1]">
        <VInput
          id="height"
          class="mb-2"
          v-model="form.height"
          type="number"
          :min="0"
          :max="2000"
          :step="0.1"
          sufix="mts"
          :label="t('harvest_details.form.height.label')"
          :message="form.errors.height"
        />

        <VInput
          id="crown_diameter"
          class="mb-2"
          v-model="form.crown_diameter"
          type="number"
          :min="0"
          :max="2000"
          :step="0.1"
          sufix="mts"
          :label="t('harvest_details.form.crown_diameter.label')"
          :message="form.errors.crown_diameter"
        />

        <VInput
          id="trunk_diameter"
          class="mb-2"
          v-model="form.trunk_diameter"
          type="number"
          :min="0"
          :max="2000"
          :step="0.1"
          sufix="mm"
          :label="t('harvest_details.form.trunk_diameter.label')"
          :message="form.errors.trunk_diameter"
        />

        <VInput
          id="root_diameter"
          class="mb-2"
          v-model="form.root_diameter"
          type="number"
          :min="0"
          :max="2000"
          :step="0.1"
          sufix="mm"
          :label="t('harvest_details.form.root_diameter.label')"
          :message="form.errors.root_diameter"
        />

        <VInput
          id="invasion_radius"
          class="mb-2"
          v-model="form.invasion_radius"
          type="number"
          :min="0"
          :max="2000"
          :step="0.1"
          sufix="mts"
          :label="t('harvest_details.form.invasion_radius.label')"
          :message="form.errors.invasion_radius"
        />

        <VInput
          id="foliage_sanitation"
          class="mb-2"
          v-model="form.foliage_sanitation"
          :label="t('harvest_details.form.foliage_sanitation.label')"
          :message="form.errors.foliage_sanitation"
        />

        <VInput
          id="trunk_sanitation"
          class="mb-2"
          v-model="form.trunk_sanitation"
          :label="t('harvest_details.form.trunk_sanitation.label')"
          :message="form.errors.trunk_sanitation"
        />

        <VInput
          id="soil_sanitation"
          class="mb-2"
          v-model="form.soil_sanitation"
          :label="t('harvest_details.form.soil_sanitation.label')"
          :message="form.errors.soil_sanitation"
        />

        <VInput
          id="irrigation_system"
          class="mb-2"
          v-model="form.irrigation_system"
          :label="t('harvest_details.form.irrigation_system.label')"
          :message="form.errors.irrigation_system"
        />
        <div class="mt-5 mb-20">
          <Button
            class="w-full mt-3 text-xl h-16"
            :loading="form.processing"
            :disabled="hasError"
            @click="submitHandler"
            label="Guardar"
          />

          <Button
            class="w-full mt-3 text-xl h-16"
            :loading="form.processing"
            :disabled="hasError"
            severity="danger"
            @click="resetQr"
            label="Cancelar"
          />
        </div>
      </div>
    </form>
  </AuthenticatedLayout>
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

<script setup>
import { useI18n } from 'vue-i18n';
import Button from 'primevue/button';

const { t } = useI18n();

const props = defineProps({
  form: {
    type: Object,
    required: true
  },
  hasError: {
    type: Boolean,
    required: true
  }
});

const emit = defineEmits(['submit', 'resetQr']);
</script>

<template>
  <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-x-16 gap-y-4 mb-5">
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
      id="notes_height"
      class="mb-2"
      v-model="form.notes.height"
      :label="t('harvest_details.form.notes.label') + ` (${t('harvest_details.form.height.label')})`"
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
      id="notes_crown_diameter"
      class="mb-2"
      v-model="form.notes.crown_diameter"
      :label="t('harvest_details.form.notes.label') + ` (${t('harvest_details.form.crown_diameter.label')})`"
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
      id="notes_trunk_diameter"
      class="mb-2"
      v-model="form.notes.trunk_diameter"
      :label="t('harvest_details.form.notes.label') + ` (${t('harvest_details.form.trunk_diameter.label')})`"
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
      id="notes_root_diameter"
      class="mb-2"
      v-model="form.notes.root_diameter"
      :label="t('harvest_details.form.notes.label') + ` (${t('harvest_details.form.root_diameter.label')})`"
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
      id="notes_invasion_radius"
      class="mb-2"
      v-model="form.notes.invasion_radius"
      :label="t('harvest_details.form.notes.label') + ` (${t('harvest_details.form.invasion_radius.label')})`"
    />

    <VInput
      id="foliage_sanitation"
      class="mb-2"
      v-model="form.foliage_sanitation"
      :label="t('harvest_details.form.foliage_sanitation.label')"
      :message="form.errors.foliage_sanitation"
    />

    <VInput
      id="notes_foliage_sanitation"
      class="mb-2"
      v-model="form.notes.foliage_sanitation"
      :label="t('harvest_details.form.notes.label') + ` (${t('harvest_details.form.foliage_sanitation.label')})`"
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
  </div>
  <div class="md:w-1/2 md:mx-auto sm:w-full">
    <div class="mt-5 mb-20">
      <Button
        class="w-full mt-3 text-xl h-16"
        :loading="form.processing"
        :disabled="hasError"
        @click="$emit('submit')"
        label="Guardar"
      />

      <Button
        class="w-full mt-3 text-xl h-16"
        :loading="form.processing"
        :disabled="hasError"
        severity="danger"
        @click="$emit('resetQr')"
        label="Cancelar"
      />
    </div>
  </div>
</template>

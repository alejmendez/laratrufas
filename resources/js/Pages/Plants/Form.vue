<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

import VInput from '@/Components/form/VInput.vue';
import VSelect from '@/Components/form/VSelect.vue';
import AddPlantType from '@/Pages/Plants/AddPlantType.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  fields: Array,
  quarters: Array,
  types: Array,
  submitHandler: Function,
});

const form = props.form;

const quartersOptions = computed(() => props.quarters.filter((q) => q.field_id == form.field_id));
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <section
      class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
    >
      <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
        <h3 class="text-base font-semibold leading-6 text-gray-950">
          {{ t('plant.sections.location') }}
        </h3>
      </header>
      <div class="border-t border-gray-200">
        <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
          <VSelect
            id="field_id"
            v-model="form.field_id"
            :placeholder="t('generics.please_select')"
            :options="props.fields"
            :label="t('plant.form.field_id.label')"
            :message="form.errors.field_id"
          />

          <VSelect
            id="quarter_id"
            v-model="form.quarter_id"
            :placeholder="t('generics.please_select')"
            :options="quartersOptions"
            :label="t('plant.form.quarter_id.label')"
            :message="form.errors.quarter_id"
          />

          <VInput
            id="row"
            maxlength="2"
            v-model="form.row"
            v-mask="'AA'"
            :label="t('plant.form.row.label')"
            :message="form.errors.row"
          />
        </div>
      </div>
    </section>
    <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
      <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
        <VInput
          id="code"
          v-model="form.code"
          :label="t('plant.form.code.label')"
          :message="form.errors.code"
        />

        <div class="grid grid-cols-12">
          <VSelect
            id="plant_type_id"
            v-model="form.plant_type_id"
            :classWrapper="'col-span-11'"
            :placeholder="t('generics.please_select')"
            :options="props.types"
            :label="t('plant.form.plant_type_id.label')"
            :message="form.errors.type"
          />
          <div class="ms-2" style="margin-top: 28px;">
            <AddPlantType />
          </div>
        </div>

        <VInput
          id="age"
          type="number"
          min="0"
          max="200"
          step="0.1"
          v-model="form.age"
          :label="t('plant.form.age.label')"
          :message="form.errors.age"
        />

        <VInput
          id="planned_at"
          type="date"
          v-model="form.planned_at"
          :label="t('plant.form.planned_at.label')"
          :message="form.errors.planned_at"
          :max-date="new Date()"
        />

        <VInput
          id="nursery_origin"
          v-model="form.nursery_origin"
          :label="t('plant.form.nursery_origin.label')"
          :message="form.errors.nursery_origin"
        />
      </div>
    </section>
  </form>
</template>

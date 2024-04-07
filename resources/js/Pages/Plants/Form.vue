<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import AddPlantType from '@/Pages/Plants/AddPlantType.vue';
import CardSection from '@/Components/CardSection.vue';

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
    <CardSection :header-text="t('plant.sections.location')">
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
    </CardSection>

    <CardSection>
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
    </CardSection>
  </form>
</template>

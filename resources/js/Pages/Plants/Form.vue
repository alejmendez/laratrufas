<script setup>
import { ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';

import AddPlantType from '@/Pages/Plants/AddPlantType.vue';
import { getDataSelect } from '@/Services/Selects';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  fields: Array,
  quarters: Array,
  types: Array,
  submitHandler: Function,
});

const form = props.form;
const plant_types = ref(props.types);

const quartersOptions = ref(props.quarters);
watch(() => form.field_id, async (field_id) => {
  quartersOptions.value = await getDataSelect('quarter', { field_id });
  form.quarter_id = null;
});

const addPlantTypeCallback = (newType) => {
  plant_types.value = [...plant_types.value, { value: newType.id, text: newType.name }];
};
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
          :options="plant_types"
          :label="t('plant.form.plant_type_id.label')"
          :message="form.errors.type"
        />
        <div class="ms-2" style="margin-top: 28px;">
          <AddPlantType :callback="addPlantTypeCallback" />
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

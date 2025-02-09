<script setup>
import { ref, watch } from 'vue';
import VSelectMultiple from '@/Components/Form/VSelectMultiple.vue';

import { getDataSelect } from '@/Services/Selects';

const props = defineProps({
  t: Function,
  form: Object,
  fields: Array,
  quarters: Array,
  plants: Array,
  responsibles: Array,
});

const t = props.t;
const form = props.form;

const quarters = ref(props.quarters);
const plants = ref(props.plants);
const rows = generateLetterArray().map((r) => ({ value: r, text: r }));

function generateLetterArray() {
  const letters = [];

  for (let i = 0; i < 26; i++) {
    letters.push(String.fromCharCode(65 + i));
  }

  for (let i = 0; i < 1; i++) {
    for (let j = 0; j < 26; j++) {
      letters.push(String.fromCharCode(65 + i) + String.fromCharCode(65 + j));
    }
  }

  return letters;
}

watch(
  () => form.field_id,
  async (field_id) => {
    quarters.value = await getDataSelect('quarter', { field_id: field_id.value });
    form.quarter_id = null;
  },
);

watch(
  () => form.quarter_id,
  async (quarter_id) => {
    if (quarter_id === null) {
      plants.value = [];
      form.plant_id = null;
      return;
    }

    plants.value = await getDataSelect('plant', { quarter_id: quarter_id.map((a) => a.value), row: form.rows.map((a) => a.value) });
    form.plant_id = null;
  },
);

watch(
  () => form.rows,
  async (row) => {
    plants.value = await getDataSelect('plant', { quarter_id: form.quarter_id.map((a) => a.value), row: row.map((a) => a.value) });
    form.plant_id = null;
  },
);
</script>

<template>
  <CardSection :header-text="t('task.sections.assignment')">
    <VSelect
      id="field_id"
      v-model="form.field_id"
      :placeholder="t('generics.please_select')"
      :options="props.fields"
      :label="t('task.form.field_id.label')"
      :message="form.errors.field_id"
    />

    <VSelectMultiple
      id="quarter_id"
      v-model="form.quarter_id"
      :placeholder="t('generics.please_select')"
      :options="quarters"
      :label="t('task.form.quarter_id.label')"
      :message="form.errors.quarter_id"
    />

    <VSelectMultiple
      id="rows"
      v-model="form.rows"
      :placeholder="t('generics.please_select')"
      :options="rows"
      :virtualScrollerOptions="{ itemSize: 44 }"
      :label="t('task.form.rows.label')"
      :message="form.errors.rows"
    />

    <VSelectMultiple
      id="plant_id"
      v-model="form.plant_id"
      :placeholder="t('generics.please_select')"
      :options="plants"
      :virtualScrollerOptions="{ itemSize: 44 }"
      :label="t('task.form.plant_id.label')"
      :message="form.errors.plant_id"
    />

    <VSelect
      id="responsible_id"
      v-model="form.responsible_id"
      :placeholder="t('generics.please_select')"
      :options="props.responsibles"
      :label="t('task.form.responsible_id.label')"
      :message="form.errors.responsible_id"
    />
  </CardSection>
</template>

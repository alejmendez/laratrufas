<script setup>
import { useI18n } from 'vue-i18n';
import { getWeek } from 'date-fns';
import { stringToDate } from '@/Utils/date';

import VSelectMultiple from '@/Components/Form/VSelectMultiple.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  importers: Array,
  harvests: Array,
  submitHandler: Function,
});

const form = props.form;

const harvests = props.harvests
  .map((h) => {
    const week = getWeek(stringToDate(h.date), { weekStartsOn: 1 });
    return {
      value: h.id,
      text: `Semana ${week} Batch ${h.batch}`,
    };
  })
  .sort((a, b) => a.text - b.text);
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VInput
        id="batch_number"
        v-model="form.batch_number"
        :label="t('batch.form.batch_number.label')"
        :message="form.errors.batch_number"
      />

      <VInput
        id="delivery_date"
        type="date"
        v-model="form.delivery_date"
        :label="t('batch.form.delivery_date.label')"
        :message="form.errors.delivery_date"
        :maxDate="new Date()"
      />

      <VSelect
        id="importer_id"
        v-model="form.importer_id"
        :placeholder="t('generics.please_select')"
        :options="props.importers"
        :label="t('batch.form.importer_id.label')"
        :message="form.errors.importer_id"
      />

      <VSelectMultiple
        id="harvests"
        v-model="form.harvests"
        :placeholder="t('generics.please_select')"
        :options="harvests"
        :label="t('batch.form.harvests.label')"
        :message="form.errors.harvests"
      />
    </CardSection>
  </form>
</template>

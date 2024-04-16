<script setup>
import { useI18n } from 'vue-i18n';
import { getWeek } from 'date-fns';
import { QrcodeStream } from 'vue-qrcode-reader';

import { stringToDate } from '@/Utils/date';

import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import CardSection from '@/Components/CardSection.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  harvests: Array,
  submitHandler: Function,
});

const form = props.form;

const harvests = props.harvests.map(h => {
  const week = getWeek(stringToDate(h.date), { weekStartsOn: 1 });
  return {
    value: h.id,
    text: `Semana ${week} Batch ${h.batch}`,
  }
}).sort((a, b) => a.text - b.text);

const onDetect = (detectedCodes) => {
  form.plant_code = detectedCodes[0].rawValue;
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <div>
        <QrcodeStream @detect="onDetect"></QrcodeStream>
      </div>

      <VSelect
        id="harvest_id"
        v-model="form.harvest_id"
        :placeholder="t('generics.please_select')"
        :options="harvests"
        :label="t('harvest.bulk.form.harvest_id')"
        :message="form.errors.harvest_id"
      />

      <VInput
        id="plant_code"
        v-model="form.plant_code"
        :label="t('harvest.form.details.plant_code.label')"
        :message="form.errors.plant_code"
      />

      <VInput
        id="quality"
        v-model="form.quality"
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
    </CardSection>
  </form>
</template>

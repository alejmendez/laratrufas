<script setup>
import { useI18n } from 'vue-i18n';
import { stringToFormat } from '@/Utils/date';

import CardSection from '@/Components/CardSection.vue';

const { t } = useI18n();

const props = defineProps({
  data: Object,
});

const data = props.data;

const dataFile = [
  [t('plant.show.file.field'), data.field.name],
  [t('plant.show.file.quarter'), data.quarter.name],
  [t('plant.show.file.plant_type'), data.plant_type.name],
  [t('plant.show.file.age'), data.age],
  [t('plant.show.file.planned_at'), stringToFormat(data.planned_at)],
  [t('plant.show.file.responsible'), data.responsible.name],
];
</script>

<template>
  <CardSection
    wrapperClass="p-5 grid grid-cols-2 gap-4"
  >
    <div>
      <img
        :src="data.blueprint"
        class="w-full"
        alt=""
      >
    </div>
    <div>
      <template v-for="block of dataFile">
        <div class="text-gray-400 pb-1">
          {{ block[0] }}
        </div>
        <div class="pb-3 dark:text-gray-50">
          {{ block[1] }}
        </div>
      </template>
    </div>
  </CardSection>
</template>

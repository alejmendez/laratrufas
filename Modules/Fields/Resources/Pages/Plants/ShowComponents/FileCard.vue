<script setup>
import { trans } from 'laravel-vue-i18n';
import { stringToFormat } from '@Core/Utils/date';

import CardSection from '@Core/Components/CardSection.vue';

const props = defineProps({
  data: Object,
});

const data = props.data;

const dataFile = [
  [trans('plant.show.file.field'), data.field.name],
  [trans('plant.show.file.quarter'), data.quarter.name],
  [trans('plant.show.file.plant_type'), data.plant_type.name],
  [trans('plant.show.file.age'), data.age],
  [trans('plant.show.file.planned_at'), stringToFormat(data.planned_at)],
  [trans('plant.show.file.responsible'), data.responsible.name],
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

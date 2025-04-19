<script setup>
import { useI18n } from 'vue-i18n';

import CardSection from '@Core/Components/CardSection.vue';

const props = defineProps({
  quarter: Object,
});

const quarter = props.quarter;

const { t } = useI18n();

const dataFile = [
  [t('quarter.show.file.field'), quarter.field.name],
  [t('quarter.show.file.area'), quarter.area],
  [t('quarter.show.file.plants_count'), quarter.plants_count],
  [t('quarter.show.file.responsible'), quarter.responsible.name],
];
</script>

<template>
  <CardSection
    wrapperClass="p-5 grid grid-cols-2 gap-4"
  >
    <div>
      <img
        :src="quarter.blueprint"
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

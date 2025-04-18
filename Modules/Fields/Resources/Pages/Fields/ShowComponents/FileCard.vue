<script setup>
import { useI18n } from 'vue-i18n';

import CardSection from '@/Components/CardSection.vue';

const props = defineProps({
  field: Object,
});

const field = props.field;

const { t } = useI18n();

const fieldFile = [
  [t('field.show.file.location'), field.location],
  [t('field.show.file.size'), field.size],
  [t('field.show.file.plants_count'), field.plants_count],
  [t('field.show.file.quarters_count'), field.quarters_count],
];
</script>

<template>
  <CardSection
    wrapperClass="p-5 grid grid-cols-2 gap-4"
  >
    <div>
      <img
        :src="field.blueprint"
        class="w-full"
        alt=""
      >
    </div>
    <div>
      <template v-for="block of fieldFile">
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

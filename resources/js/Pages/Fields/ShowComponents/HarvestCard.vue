<script setup>
import { useI18n } from 'vue-i18n';
import HarvestTable from '@/Pages/Harvests/Components/HarvestTable.vue';

const props = defineProps({});

const { t } = useI18n();

const count_details = 0;
let total_weight = 0;

const fieldFile = [
  [t('field.show.file.location'), field.location],
  [t('field.show.file.size'), field.size],
  [t('field.show.file.plants_count'), field.plants_count],
  [t('field.show.file.quarters_count'), field.quarters_count],
];
</script>

<template>
  <div class="flex ">

    <div class="w-1/4 mr-4">
      <CardSection
        :header-text="t('field.show.file.title', { name: field.name })"
        wrapperClass="p-5"
      >
        <template v-for="block of fieldFile">
          <div class="text-gray-400 pb-1">
            {{ block[0] }}
          </div>
          <div class="pb-3">
            {{ block[1] }}
          </div>
        </template>
      </CardSection>
    </div>

    <div class="w-3/4">
      <div class="flex space-x-4 mb-4">
        <div class="flex-1">
          <CardSection wrapperClass="p-5">
            <div class="text-gray-400 pb-1">Cosecha</div>
            <div class="pb-3 text-3xl font-bold">{{ harvests_count }}</div>
          </CardSection>
        </div>

        <div class="flex-1">
          <CardSection wrapperClass="p-5">
            <div class="text-gray-400 pb-1">Unidades</div>
            <div class="pb-3 text-3xl font-bold">{{ count_details }}</div>
          </CardSection>
        </div>

        <div class="flex-1">
          <CardSection wrapperClass="p-5">
            <div class="text-gray-400 pb-1">Peso Total</div>
            <div class="pb-3 text-3xl font-bold">{{ total_weight }} Kgs</div>
          </CardSection>
        </div>
      </div>
      <HarvestTable
        :show_filters="false"
        :show_actions="false"
      />
    </div>
  </div>
</template>

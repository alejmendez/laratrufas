<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';

import StatisticsCard from '@/Pages/Quarters/ShowComponents/StatisticsCard.vue';
import HarvestCard from '@/Pages/Quarters/ShowComponents/HarvestCard.vue';
import LogbookCard from '@/Pages/Quarters/ShowComponents/LogbookCard.vue';

const { t } = useI18n();

const props = defineProps({
  data: Object,
});

const { data: quarter } = props.data;

const tabs = ['file', 'logbook', 'harvest', 'statistics'];

const currentTab = ref(tabs[0]);

const dataFile = [
  [t('quarter.show.file.field'), quarter.field.name],
  [t('quarter.show.file.area'), quarter.area],
  [t('quarter.show.file.plants_count'), quarter.plants_count],
  [t('quarter.show.file.responsible'), quarter.responsible.name],
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('quarters.destroy', id));
  });
};
</script>

<template>
  <Head :title="t('quarter.titles.show', {name: quarter.name})" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('quarter.titles.show', {name: quarter.name})"
      :breadcrumbs="[{ to: 'quarters.index', text: t('quarter.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
    >
      <Button
        severity="secondary"
        @click="deleteHandler(quarter.id)"
        :label="$t('generics.actions.delete')"
      />
      <Button
        as="Link"
        :href="route('quarters.edit', quarter.id)"
        :label="$t('generics.actions.edit')"
      />
    </HeaderCrud>

    <div class="flex place-content-center">
      <nav class="flex mb-1 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 px-4 py-1">
        <span
          v-for="tab of tabs"
          class="px-4 py-2 cursor-default font-semibold"
          :class="currentTab === tab ? 'text-[--p-primary-500]' : 'hover:text-[--p-primary-300] dark:hover:text-[--p-primary-600] text-gray-400'"
          @click="currentTab = tab"
        >
          {{ $t('quarter.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <CardSection
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="currentTab === tabs[0]"
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

    <LogbookCard
      :quarter_id="quarter.field.id"
      v-show="currentTab === tabs[1]"
    />

    <HarvestCard
      :quarter_id="quarter.id"
      v-show="currentTab === tabs[2]"
    />

    <StatisticsCard
      :quarter="quarter"
      v-show="currentTab === tabs[3]"
    />
  </AuthenticatedLayout>
</template>

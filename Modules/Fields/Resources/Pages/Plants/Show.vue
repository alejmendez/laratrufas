<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';

import FileCard from '@Fields/Pages/Plants/ShowComponents/FileCard.vue';
import LogsCard from '@Fields/Pages/Plants/ShowComponents/LogsCard.vue';
import StatisticsCard from '@Fields/Pages/Plants/ShowComponents/StatisticsCard.vue';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  details: Object,
});

const { data } = props.data;

const tabs = [
  'file',
  'logs',
  'statistics',
];

const urlParams = new URLSearchParams(window.location.search);
const tabSelected = urlParams.get('tab');

const currentTab = ref(tabs.includes(tabSelected) ? tabSelected : tabs[0]);

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('plants.destroy', id));
  });
};
</script>

<template>
  <Head :title="t('plant.titles.show', {name: data.code})" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('plant.titles.show', {name: data.code})"
      :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
    >
      <Button
        severity="secondary"
        @click="deleteHandler(data.id)"
        :label="$t('generics.actions.delete')"
      />
      <Button
        as="Link"
        :href="route('plants.edit', data.id)"
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
          {{ $t('plant.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <FileCard :data="data" v-show="currentTab === tabs[0]" />
    <LogsCard :plant_id="data.id" :show_harvests="true" v-show="currentTab === tabs[1]" />
    <StatisticsCard :plant="data" v-show="currentTab === tabs[2]" />
  </AuthenticatedLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useConfirm } from 'primevue/useconfirm';
import { deleteRowTable } from '@/Utils/table';
import { can } from '@/Services/Auth';

import StatisticsCard from '@Fields/Pages/Quarters/ShowComponents/StatisticsCard.vue';
import HarvestCard from '@Fields/Pages/Quarters/ShowComponents/HarvestCard.vue';
import LogbookCard from '@Fields/Pages/Quarters/ShowComponents/LogbookCard.vue';

const { t } = useI18n();
const confirm = useConfirm();

const props = defineProps({
  data: Object,
});

const { data: quarter } = props.data;

const canDestroy = can('quarters.destroy');
const canEdit = can('quarters.edit');

const FILE_TAB = 'file';
const LOGBOOK_TAB = 'logbook';
const HARVEST_TAB = 'harvest';
const STATISTICS_TAB = 'statistics';

const tabs = [FILE_TAB, LOGBOOK_TAB, HARVEST_TAB, STATISTICS_TAB];

const currentTab = ref(FILE_TAB);

const isFileTab = computed(() => currentTab.value === FILE_TAB);
const isLogbookTab = computed(() => currentTab.value === LOGBOOK_TAB);
const isHarvestTab = computed(() => currentTab.value === HARVEST_TAB);
const isStatisticsTab = computed(() => currentTab.value === STATISTICS_TAB);

const dataFile = [
  [t('quarter.show.file.field'), quarter.field.name],
  [t('quarter.show.file.area'), quarter.area],
  [t('quarter.show.file.plants_count'), quarter.plants_count],
  [t('quarter.show.file.responsible'), quarter.responsible.name],
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, confirm, () => {
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
        v-if="canDestroy"
        v-show="isFileTab"
      />
      <Button
        as="Link"
        :href="route('quarters.edit', quarter.id)"
        :label="$t('generics.actions.edit')"
        v-if="canEdit"
        v-show="isFileTab"
      />
    </HeaderCrud>

    <div class="flex place-content-center">
      <nav class="flex mb-1 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 px-4 py-1">
        <span
          v-for="tab of tabs"
          class="px-4 py-2 cursor-default font-semibold"
          :class="currentTab === tab ? 'text-(--p-primary-500)' : 'hover:text-(--p-primary-300) dark:hover:text-(--p-primary-600) text-gray-400'"
          @click="currentTab = tab"
        >
          {{ t('quarter.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <CardSection
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="isFileTab"
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
      :quarter_id="quarter.id"
      v-show="isLogbookTab"
    />

    <HarvestCard
      :quarter_id="quarter.id"
      v-show="isHarvestTab"
    />

    <StatisticsCard
      :quarter="quarter"
      v-show="isStatisticsTab"
    />
  </AuthenticatedLayout>
</template>

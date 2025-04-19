<script setup>
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@Core/Utils/table';
import { useConfirm } from 'primevue/useconfirm';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FileCard from '@Fields/Pages/Fields/ShowComponents/FileCard.vue';
import LogbookCard from '@Fields/Pages/Fields/ShowComponents/LogbookCard.vue';
import HarvestCard from '@Fields/Pages/Fields/ShowComponents/HarvestCard.vue';
import StatisticsCard from '@Fields/Pages/Fields/ShowComponents/StatisticsCard.vue';
import DocumentationCard from '@Fields/Pages/Fields/ShowComponents/DocumentationCard.vue';

import Button from '@Core/Components/Form/Button.vue';

import { can } from '@/Services/Auth';

const { t } = useI18n();

const props = defineProps({
  field: Object,
  harvests: Object,
  order: String,
  search: String,
  current_tab: String,
});

const field = props.field.data;
const confirm = useConfirm();

const current_tab = ref(props.current_tab);

const FILE_TAB = 'file';
const LOGBOOK_TAB = 'logbook';
const HARVEST_TAB = 'harvest';
const STATISTICS_TAB = 'statistics';
const DOCUMENTATION_TAB = 'documentation';

const tabs = [FILE_TAB, LOGBOOK_TAB, HARVEST_TAB, STATISTICS_TAB, DOCUMENTATION_TAB];

const canEdit = can('fields.edit');
const canDestroy = can('fields.destroy');

const selectTab = (tab) => {
  current_tab.value = tab;
  const url = new URL(window.location.href);
  url.searchParams.set('current_tab', tab);
  window.history.pushState({}, '', url);
};

const isFileTab = computed(() => current_tab.value === FILE_TAB);
const isLogbookTab = computed(() => current_tab.value === LOGBOOK_TAB);
const isHarvestTab = computed(() => current_tab.value === HARVEST_TAB);
const isStatisticsTab = computed(() => current_tab.value === STATISTICS_TAB);
const isDocumentationTab = computed(() => current_tab.value === DOCUMENTATION_TAB);

const deleteHandler = async (id) => {
  await deleteRowTable(t, confirm, () => {
    router.delete(route('fields.destroy', id));
  });
};
</script>

<template>
  <AuthenticatedLayout :title="t('field.titles.show', { name: field.name })">
    <HeaderCrud
      :title="t('field.titles.show', { name: field.name })"
      :breadcrumbs="[{ to: 'fields.index', text: t('field.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
    >
      <Button
        severity="secondary"
        @click="deleteHandler(field.id)"
        :label="$t('generics.actions.delete')"
        v-if="canDestroy"
        v-show="isFileTab"
      />
      <Button
        as="Link"
        :href="route('fields.edit', field.id)"
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
          :class="current_tab === tab ? 'text-(--p-primary-500)' : 'hover:text-(--p-primary-300) dark:hover:text-(--p-primary-600) text-gray-400'"
          @click="selectTab(tab)"
        >
          {{ t('field.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <FileCard
      :field="field"
      v-show="isFileTab"
    />

    <LogbookCard
      :field_id="field.id"
      v-show="isLogbookTab"
    />

    <HarvestCard
      :field_id="field.id"
      v-show="isHarvestTab"
    />

    <StatisticsCard
      :field="field"
      v-show="isStatisticsTab"
    />

    <DocumentationCard
      :field="field"
      v-show="isDocumentationTab"
    />
  </AuthenticatedLayout>
</template>

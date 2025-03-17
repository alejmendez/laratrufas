<script setup>
import { computed, ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useConfirm } from 'primevue/useconfirm';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import { deleteRowTable } from '@/Utils/table';
import { can } from '@/Services/Auth';

import VariablesView from '@Fields/Pages/HarvestDetails/Views/VariablesView.vue';

import FileCard from '@Fields/Pages/Plants/ShowComponents/FileCard.vue';
import LogsCard from '@Fields/Pages/Plants/ShowComponents/LogsCard.vue';
import StatisticsCard from '@Fields/Pages/Plants/ShowComponents/StatisticsCard.vue';

const { t } = useI18n();
const confirm = useConfirm();
const props = defineProps({
  data: Object,
  details: Object,
  current_tab: String,
});

const { data } = props.data;

const logsCard = ref(null);

const showModalNote = ref(false);

const properties = {
  quality: null,
  weight: null,
  height: null,
  crown_diameter: null,
  invasion_radius: null,
  trunk_diameter: null,
  root_diameter: null,
  foliage_sanitation: null,
  foliage_sanitation_photo: null,
  trunk_sanitation: null,
  trunk_sanitation_photo: null,
  soil_sanitation: null,
  soil_sanitation_photo: null,
  irrigation_system: null,
};

const form = useForm({
  plant_id: data.id,
  plant_code: data.code,
  ...properties,
  notes: {
    ...properties,
  },
});

const hasError = ref(false);
const canDestroy = can('plants.destroy');
const canEdit = can('plants.edit');

const FILE_TAB = 'file';
const LOGS_TAB = 'logs';
const STATISTICS_TAB = 'statistics';

const tabs = [
  FILE_TAB,
  LOGS_TAB,
  STATISTICS_TAB,
];

const currentTab = ref(props.current_tab || FILE_TAB);

const isFileTab = computed(() => currentTab.value === FILE_TAB);
const isLogsTab = computed(() => currentTab.value === LOGS_TAB);
const isStatisticsTab = computed(() => currentTab.value === STATISTICS_TAB);

const selectTab = (tab) => {
  currentTab.value = tab;
  const url = new URL(window.location.href);
  url.searchParams.set('current_tab', tab);
  window.history.pushState({}, '', url);
};

const deleteHandler = async (id) => {
  await deleteRowTable(t, confirm, () => {
    router.delete(route('plants.destroy', id));
  });
};

const resetVariables = () => {
  form.value = {
    plant_id: data.id,
    plant_code: data.code,
    ...properties,
    notes: {
      ...properties,
    },
  };

  logsCard.value.filter();
  showModalNote.value = false;
};

const submitHandler = () => {
  const options = {};
  if ([form.foliage_sanitation_photo, form.trunk_sanitation_photo, form.soil_sanitation_photo].some((d) => d != null)) {
    options.forceFormData = true;
  }
  form.post(route('plants.details.store'), options);
  resetVariables();
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
        v-if="canDestroy"
        v-show="isFileTab"
      />
      <Button
        as="Link"
        :href="route('plants.edit', data.id)"
        :label="$t('generics.actions.edit')"
        v-if="canEdit"
        v-show="isFileTab"
      />

      <Button
        :label="t('plant.titles.add_variables')"
        v-show="isLogsTab"
        @click="showModalNote = true"
      />
    </HeaderCrud>

    <div class="flex place-content-center">
      <nav class="flex mb-1 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 px-4 py-1">
        <span
          v-for="tab of tabs"
          class="px-4 py-2 cursor-default font-semibold"
          :class="currentTab === tab ? 'text-[--p-primary-500]' : 'hover:text-[--p-primary-300] dark:hover:text-[--p-primary-600] text-gray-400'"
          @click="selectTab(tab)"
        >
          {{ t('plant.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <FileCard :data="data" v-show="isFileTab" />
    <LogsCard ref="logsCard" :plant_id="data.id" v-show="isLogsTab" />
    <StatisticsCard :plant="data" v-show="isStatisticsTab" />

    <Dialog v-model:visible="showModalNote" :header="t('plant.titles.add_variables')" modal :style="{ width: '75rem' }">
      <VariablesView
        :form="form"
        :has-error="hasError"
        @submit="submitHandler"
        @cancel="resetVariables"
      />
    </Dialog>
  </AuthenticatedLayout>
</template>

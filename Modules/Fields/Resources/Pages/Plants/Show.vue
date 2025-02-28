<script setup>
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useConfirm } from 'primevue/useconfirm';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { useToast } from 'primevue/usetoast';
import { deleteRowTable } from '@/Utils/table';
import { can } from '@/Services/Auth';

import VTextarea from '@/Components/Form/VTextarea.vue';

import FileCard from '@Fields/Pages/Plants/ShowComponents/FileCard.vue';
import LogsCard from '@Fields/Pages/Plants/ShowComponents/LogsCard.vue';
import StatisticsCard from '@Fields/Pages/Plants/ShowComponents/StatisticsCard.vue';

import plantService from '@Fields/Services/PlantService';

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
const form = ref({
  plant_id: data.id,
  note: '',
  errors: {},
});

const loading = ref(false);
const toast = useToast();
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

const showSuccessToast = () => {
  toast.add({
    severity: 'success',
    summary: t('plant.titles.entity_breadcrumb'),
    detail: t('generics.messages.saved_successfully'),
    life: 5000,
  });

  form.note = null;
  form.errors = {};
};

const showErrorToast = () => {
  toast.add({
    severity: 'danger',
    summary: t('plant.titles.entity_breadcrumb'),
    detail: t('generics.errors.trying_to_save'),
    life: 5000,
  });
};

const createNote = async () => {
  loading.value = true;
  form.errors = {};

  try {
    await plantService.createNote(form.value);
    showModalNote.value = false;
    showSuccessToast();
  } catch (error) {
    const errors = error.response?.data?.errors;
    if (errors) {
      Object.keys(errors).forEach(key => {
        form.errors[key] = errors[key].join(', ');
      });
    }
    showErrorToast();
  } finally {
    logsCard.value.filter();
    loading.value = false;
  }
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
        label="Agregar Nota"
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

    <Dialog v-model:visible="showModalNote" :header="t('plant.titles.add_note')" modal :style="{ width: '25rem' }">
      <VTextarea
        id="note"
        v-model="form.note"
        :label="t('plant.form.note.label')"
        :message="form.errors.note"
      />

      <div class="flex justify-end gap-2 mt-4">
        <Button
          type="button"
          :label="$t('generics.buttons.cancel')"
          severity="secondary"
          @click="showModalNote = false"
          :loading="loading"
        />
        <Button
          type="button"
          :label="$t('generics.buttons.create')"
          @click="createNote()"
          :loading="loading"
        />
      </div>
    </Dialog>
  </AuthenticatedLayout>
</template>

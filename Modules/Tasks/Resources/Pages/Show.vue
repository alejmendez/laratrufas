<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useConfirm } from 'primevue/useconfirm';

import { can } from '@/Services/Auth';
import { deleteRowTable } from '@/Utils/table';
import { stringToFormat } from '@/Utils/date';

import FormComments from '@Tasks/Components/Comments.vue';

const { t } = useI18n();
const confirm = useConfirm();
const props = defineProps({
  data: Object,
  fields: Array,
  responsibles: Array,
  quarters: Array,
  plants: Array,
  tools: Array,
  security_equipments: Array,
  machineries: Array,
  current_tab: String,
});

const { data } = props.data;

let supplies = data.supplies.map((a) => {
  a.unit = { value: a.unit, text: t('task.form.supplies.unit.options.' + a.unit) };
  return a;
});

if (supplies.length === 0) {
  supplies = [
    {
      name: null,
      brand: null,
      quantity: null,
      unit: '',
    },
  ];
}

const canDestroy = can('tasks.destroy');
const canEdit = can('tasks.edit');

const headerLinks = [];
if (canDestroy) {
  headerLinks.push({ to: () => deleteHandler(data.id), variant: 'secondary', text: t('generics.actions.delete') });
}
if (canEdit) {
  headerLinks.push({ to: route('tasks.edit', data.id), text: t('generics.actions.edit') });
}

const FILE_TAB = 'detail';
const TRACKING_TAB = 'tracking';
const LOGBOOK_TAB = 'logbook';
const STATISTICS_TAB = 'statistics';

const tabs = [FILE_TAB, TRACKING_TAB, LOGBOOK_TAB, STATISTICS_TAB];

const currentTab = ref(props.current_tab || FILE_TAB);

const isFileTab = computed(() => currentTab.value === FILE_TAB);
const isTrackingTab = computed(() => currentTab.value === TRACKING_TAB);
const isLogbookTab = computed(() => currentTab.value === LOGBOOK_TAB);
const isStatisticsTab = computed(() => currentTab.value === STATISTICS_TAB);

const selectTab = (tab) => {
  currentTab.value = tab;
  const url = new URL(window.location.href);
  url.searchParams.set('current_tab', tab);
  window.history.pushState({}, '', url);
};

const deleteHandler = async (id) => {
  await deleteRowTable(t, confirm, () => {
    router.delete(route('tasks.destroy', id));
  });
};
</script>

<template>
  <Head :title="t('task.titles.show')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('task.titles.show')"
      :breadcrumbs="[{ to: 'tasks.index', text: t('task.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
      :links="headerLinks"
    />

    <div class="flex place-content-center mt-5">
      <nav class="flex mb-1 rounded-lg bg-white dark:bg-(--p-surface-950) dark:border-(--p-surface-700) border border-gray-200 px-4 py-1">
        <span
          v-for="tab of tabs"
          class="px-4 py-2 cursor-default font-semibold"
          :class="currentTab === tab ? 'text-(--p-primary-500)' : 'hover:text-(--p-primary-300) dark:hover:text-(--p-primary-600) text-gray-400'"
          @click="selectTab(tab)"
        >
          {{ t('task.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <div class="grid grid-cols-5 gap-4" v-show="isFileTab">
      <CardSection
        :header-text="data.name"
        wrapperClass="p-5"
      >
        <div class="text-gray-400 mb-1">
          {{ t('task.show.detail.priority.label') }}
        </div>
        <div class="mb-4">
          <span class="inline-flex items-center rounded-md bg-gray-200 px-2 py-1 me-2 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
            {{ t('task.show.detail.priority.options.' + data.priority) }}
          </span>
        </div>

        <div class="text-gray-400 mb-1">
          {{ t('task.show.detail.status.label') }}
        </div>
        <div class="mb-4">
          {{ t('task.show.detail.status.options.' + data.status) }}
        </div>
        <div class="text-gray-400 mb-1">
          {{ t('task.show.detail.start_date.label') }}
        </div>
        <div class="mb-4">
          {{ stringToFormat(data.start_date) }}
        </div>
        <div class="text-gray-400 mb-1">
          {{ t('task.show.detail.end_date.label') }}
        </div>
        <div class="mb-4">
          {{ stringToFormat(data.end_date) }}
        </div>
        <div class="text-gray-400 mb-1">
          {{ t('task.show.detail.responsible.label') }}
        </div>
        <div class="mb-4">
          {{ data.responsible_name }}
        </div>
      </CardSection>
      <div class="col-span-4">
        <CardSection
          :header-text="t('task.show.detail.sections.resources')"
          wrapperClass="p-5"
        >
          <div class="mb-1 font-semibold">
            {{ t('task.show.detail.tools.label') }}
          </div>
          <div class="mb-4">
            <div class="py-3 ps-3 min-h-10 border border-gray-200 rounded-md bg-gray-50 dark:bg-(--p-surface-950) dark:border-(--p-surface-700) ring-1 ring-gray-950/5">
              <span
                class="inline-flex items-center rounded-md bg-gray-200 px-2 py-1 me-2 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10"
                v-for="tool of data.tools"
              >
                {{ tool.text }}
              </span>
            </div>
          </div>
          <div class="mb-1 font-semibold">
            {{ t('task.show.detail.machineries.label') }}
          </div>
          <div class="mb-4">
            <div class="py-3 ps-3 min-h-10 border border-gray-200 rounded-md bg-gray-50 dark:bg-(--p-surface-950) dark:border-(--p-surface-700) ring-1 ring-gray-950/5">
              <span
                class="inline-flex items-center rounded-md bg-gray-200 px-2 py-1 me-2 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10"
                v-for="machinery of data.machineries"
              >
                {{ machinery.text }}
              </span>
            </div>
          </div>

          <div class="mb-1 font-semibold">
            {{ t('task.show.detail.security_equipments.label') }}
          </div>
          <div class="mb-4">
            <div class="py-3 ps-3 min-h-10 border border-gray-200 rounded-md bg-gray-50 dark:bg-(--p-surface-950) dark:border-(--p-surface-700) ring-1 ring-gray-950/5">
              <span
                class="inline-flex items-center rounded-md bg-gray-200 px-2 py-1 me-2 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10"
                v-for="security_equipment of data.security_equipments"
              >
                {{ security_equipment.text }}
              </span>
            </div>
          </div>

          <table class="w-full">
            <thead>
              <tr>
                <th class="text-gray-400 font-normal text-left">{{ t('task.show.detail.supplies.name.label') }}</th>
                <th class="text-gray-400 font-normal text-left">{{ t('task.show.detail.supplies.brand.label') }}</th>
                <th class="text-gray-400 font-normal text-left">{{ t('task.show.detail.supplies.quantity.label') }}</th>
                <th class="text-gray-400 font-normal text-left">{{ t('task.show.detail.supplies.unit.label') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="supply of data.supplies">
                <td>{{ supply.name }}</td>
                <td>{{ supply.brand }}</td>
                <td>{{ supply.quantity }}</td>
                <td>{{ t('task.show.detail.supplies.unit.options.' + supply.unit.value) }}</td>
              </tr>
            </tbody>
          </table>
        </CardSection>

        <FormComments :form="data" :t="t" :responsibles="props.responsibles" />
      </div>
    </div>

    <CardSection
      :header-text="t('task.show.tracking.title')"
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="isTrackingTab"
    >
    </CardSection>
    <CardSection
      :header-text="t('task.show.logbook.title')"
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="isLogbookTab"
    >
    </CardSection>
    <CardSection
      :header-text="t('task.show.statistics.title')"
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="isStatisticsTab"
    >
    </CardSection>
  </AuthenticatedLayout>
</template>

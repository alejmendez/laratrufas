<script setup>
import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import Tag from 'primevue/tag';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

import { useI18n } from 'vue-i18n';

import Datatable from '@/Components/Table/Datatable.vue';
import TaskService from '@/Services/TaskService.js';
import { dateToString } from '@/Utils/date.js';
import { getDataSelects } from '@/Services/Selects';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const datatable = ref(null);
const filter_responsible_options = ref([]);

if (props.toast) {
  toast.add({ severity: 'success', detail: t('generics.messages.saved_successfully'), life: 3000 });
}

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  'name': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  'status': { value: null, matchMode: FilterMatchMode.EQUALS },
  'priority': { value: null, matchMode: FilterMatchMode.EQUALS },
  'updated_at': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  'responsible_id': { value: null, matchMode: FilterMatchMode.EQUALS },
};

const statesValues = ['to_begin', 'started', 'stopped', 'finished'];
const filter_states_options = statesValues.map((s) => ({ value: s, text: t('task.form.status.options.' + s) }));
const statesSeverities = {
  'to_begin': 'warn',
  'started': 'info',
  'stopped': 'danger',
  'finished': 'success',
}

const priorities = ['when_possible', 'routine', 'important', 'urgent']
const filter_priorities_options = priorities.map((p) => ({
  value: p,
  text: t('task.form.priority.options.' + p),
}));
const prioritiesSeverities = {
  'when_possible': 'success',
  'routine': 'info',
  'important': 'warn',
  'urgent': 'danger',
}

const fetchHandler = async (params) => {
  return await TaskService.list(params);
}

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await TaskService.del(record.id);
    if (result) {
      datatable.value.loadLazyData();
      return toast.add({ severity: 'success', summary: t('generics.messages.deleted_successfully_summary'), detail: t('generics.messages.deleted_successfully'), life: 3000 });
    }
    toast.add({ severity: 'danger', summary: t('generics.tables.errors.could_not_delete_the_record_summary'), detail: t('generics.tables.errors.could_not_delete_the_record'), life: 3000 })
  });
};

onMounted(async () => {
  if (props.toast) {
    toast.add({ severity: 'success', summary: t('task.titles.entity_breadcrumb'), detail: t('generics.messages.saved_successfully'), life: 5000 });
  }

  const data = await getDataSelects({
    responsible: {},
  });

  filter_responsible_options.value = data.responsible;
});
</script>

<template>
  <Head :title="t('task.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('task.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'tasks.index', text: t('task.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
      :links="[{ to: 'tasks.create', text: t('generics.new') }]"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="name"
      :sortOrder="1"
    >
      <Column field="name" filterField="name" :header="$t('task.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
      </Column>
      <Column field="status" filterField="status" :showFilterMatchModes="false" :header="$t('task.table.status')" sortable style="min-width: 200px">
        <template #body="{ data }">
          <Tag :severity="statesSeverities[data.status]" :value="t('task.form.status.options.' + data.status)"></Tag>
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_states_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>
      <Column field="priority" filterField="priority" :showFilterMatchModes="false" :header="$t('task.table.priority')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ t('task.form.priority.options.' + data.priority) }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_priorities_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>
      <Column field="updated_at" filterField="updated_at" :header="$t('task.table.updated_at')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ dateToString(data.updated_at) }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por fecha de actualización" />
        </template>
      </Column>
      <Column field="responsible.name" filterField="responsible_id" :showFilterMatchModes="false" :header="$t('plant.table.manager')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.responsible.name }} {{ data.responsible.last_name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_responsible_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('tasks.show', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
          </Link>
          <Link :href="route('tasks.edit', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
              @click="deleteHandler(slotProps.data)" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

import { useI18n } from 'vue-i18n';

import Datatable from '@/Components/Table/Datatable.vue';
import PlantService from '@/Services/PlantService.js';
import { deleteRowTable } from '@/Utils/table.js';
import { getDataSelects } from '@/Services/Selects';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const datatable = ref(null);
const filter_field_options = ref([]);
const filter_quarter_options = ref([]);
const filter_plant_type_options = ref([]);
const filter_responsible_options = ref([]);

if (props.toast) {
  toast.add({ severity: 'success', detail: t('generics.messages.saved_successfully'), life: 3000 });
}

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  code: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  quarter_id: { value: null, matchMode: FilterMatchMode.EQUALS },
  'quarter.field_id': { value: null, matchMode: FilterMatchMode.EQUALS },
  plant_type_id: { value: null, matchMode: FilterMatchMode.EQUALS },
  age: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  'quarter.responsible_id': { value: null, matchMode: FilterMatchMode.EQUALS },
};

const fetchHandler = async (params) => {
  return await PlantService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await PlantService.del(record.id);
    if (result) {
      datatable.value.loadLazyData();
      return toast.add({
        severity: 'success',
        summary: t('generics.messages.deleted_successfully_summary'),
        detail: t('generics.messages.deleted_successfully'),
        life: 3000,
      });
    }
    toast.add({
      severity: 'danger',
      summary: t('generics.tables.errors.could_not_delete_the_record_summary'),
      detail: t('generics.tables.errors.could_not_delete_the_record'),
      life: 3000,
    });
  });
};

onMounted(async () => {
  if (props.toast) {
    toast.add({
      severity: 'success',
      summary: t('plant.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }

  const data = await getDataSelects({
    field: {},
    quarter: {},
    plant_type: {},
    responsible: {},
  });

  filter_field_options.value = data.field;
  filter_quarter_options.value = data.quarter;
  filter_plant_type_options.value = data.plant_type;
  filter_responsible_options.value = data.responsible;
});
</script>

<template>
  <Head :title="t('plant.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('plant.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
      :links="[{ to: 'plants.create', text: t('generics.new') }]"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="plants.code"
      :sortOrder="1"
    >
      <Column field="code" filterField="plants.name" :header="$t('plant.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.code }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Codigo" />
        </template>
      </Column>
      <Column field="quarter_name" filterField="quarter_id" :showFilterMatchModes="false" :header="$t('plant.table.quarter_id')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.quarter.name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_quarter_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>
      <Column field="field_name" filterField="quarter.field_id" :showFilterMatchModes="false" :header="$t('plant.table.field_id')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.quarter.field.name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_field_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>
      <Column field="plant_type_name" filterField="plant_type_id" :showFilterMatchModes="false" :header="$t('plant.table.type')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.plant_type.name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_plant_type_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>
      <Column field="age" :header="$t('plant.table.age')" sortable style="min-width: 100px">
        <template #body="{ data }">
          {{ data.age }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por edad" />
        </template>
      </Column>
      <Column field="quarter.responsible.name" filterField="quarter.responsible_id" :showFilterMatchModes="false" :header="$t('plant.table.manager')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.quarter.responsible.name }} {{ data.quarter.responsible.last_name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_responsible_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('plants.show', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
          </Link>
          <Link :href="route('plants.edit', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
              @click="deleteHandler(slotProps.data)" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

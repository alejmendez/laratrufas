<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

import { useI18n } from 'vue-i18n';

import Datatable from '@/Components/Table/Datatable.vue';
import HarvestService from '@/Services/HarvestService.js';

import { getWeek } from 'date-fns';

import { stringToDate } from '@/Utils/date';
import { getDataSelect, getDataSelects } from '@/Services/Selects';

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const props = defineProps({
  show_filters: {
    type: Boolean,
    default: true,
  },
  show_actions: {
    type: Boolean,
    default: true,
  },
});

const datatableComponent = ref(null);

const filter_year_options = ref([]);
const filter_field_options = ref([]);
const filter_quarter_options = ref([]);
const filter_user_options = ref([]);

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  batch: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  'quarters.field_id': { value: null, matchMode: FilterMatchMode.EQUALS },
  'quarters.quarter_id': { value: null, matchMode: FilterMatchMode.EQUALS },
  'farmer.id': { value: null, matchMode: FilterMatchMode.EQUALS },
};

const form = reactive({
  year: [],
  field: [],
  last_field: [],
  quarter: [],
});

const fetchHandler = async (params) => await HarvestService.list(params);

const filterHandler = async () => {
  if (form.last_field != form.field) {
    form.last_field = form.field;
    const data = await getDataSelect('quarter', {
      field_id: form.field,
    });

    filter_quarter_options.value = data;
  }
};

const deleteHandler = async (record) => {
  confirm.require({
    message: 'Do you want to delete this record?',
    header: 'Danger Zone',
    icon: 'pi pi-info-circle',
    rejectLabel: 'Cancel',
    rejectProps: {
      label: 'Cancel',
      severity: 'secondary',
      outlined: true
    },
    acceptProps: {
      label: 'Delete',
      severity: 'danger'
    },
    accept: async () => {
      const result = await FieldService.del(record.id);
      if (result) {
        return toast.add({ severity: 'success', summary: 'Successful', detail: t('generics.messages.deleted_successfully'), life: 3000 });
      }
      toast.add({ severity: 'danger', summary: 'Successful', detail: t('generics.messages.deleted_successfully'), life: 3000 })
    },
    reject: () => {}
  });
};

onMounted(async () => {
  const data = await getDataSelects({
    harvest_available_years: {},
    field: {},
    quarter: {},
    user: {},
  });

  filter_year_options.value = data.harvest_available_years;
  filter_field_options.value = data.field;
  filter_quarter_options.value = data.quarter;
  filter_user_options.value = data.user;
});
</script>

<template>
  <ConfirmDialog></ConfirmDialog>
  <Toast />

  <template v-if="props.show_filters">
    <div class="p-6 grid md:grid-cols-3 gap-x-16 gap-y-4 sm:grid-cols-1">
      <VSelect
        id="field"
        v-model="form.field"
        :placeholder="t('generics.please_select')"
        :options="filter_field_options"
        :label="t('harvest.table_filters.field')"
        @change="filterHandler"
      />
      <VSelect
        id="quarter"
        v-model="form.quarter"
        :placeholder="t('generics.please_select')"
        :options="filter_quarter_options"
        :label="t('harvest.table_filters.quarter')"
        @change="filterHandler"
      />
      <VSelect
        id="year"
        v-model="form.year"
        :placeholder="t('generics.please_select')"
        :options="filter_year_options"
        :label="t('harvest.table_filters.year')"
        @change="filterHandler"
      />
    </div>
  </template>

  <Datatable
    ref="datatableComponent"
    :filters="filters"
    :fetchHandler="fetchHandler"
    :deleteHandler="deleteHandler"
    sortField="date"
    :sortOrder="1"
  >
    <Column field="date" :header="$t('harvest.table.date')" sortable frozen style="min-width: 200px">
      <template #body="{ data }">
        {{ $t('harvest.table_data.date', { week: getWeek(stringToDate(data.date), { weekStartsOn: 1 }) }) }}
      </template>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="Buscar por date" />
      </template>
    </Column>

    <Column field="batch" :header="$t('harvest.table.batch')" sortable style="min-width: 200px">
      <template #body="{ data }">
        {{ data.batch }}
      </template>
      <template #filter="{ filterModel }">
        <InputText v-model="filterModel.value" type="text" placeholder="Buscar por batch" />
      </template>
    </Column>

    <Column field="field_names" filterField="quarters.field_id" :showFilterMatchModes="false" :header="$t('harvest.table.field')" sortable style="min-width: 200px">
      <template #body="{ data }">
        {{ data.field_names }}
      </template>
      <template #filter="{ filterModel }">
        <Select v-model="filterModel.value" :options="filter_field_options" optionLabel="text" placeholder="Todos" />
      </template>
    </Column>

    <Column field="quarter_names" filterField="quarters.quarter_id" :showFilterMatchModes="false" :header="$t('harvest.table.quarter')" sortable style="min-width: 200px">
      <template #body="{ data }">
        {{ data.quarter_names }}
      </template>
      <template #filter="{ filterModel }">
        <Select v-model="filterModel.value" :options="filter_quarter_options" optionLabel="text" placeholder="Todos" />
      </template>
    </Column>

    <Column field="total_weight" :header="$t('harvest.table.weight')" sortable style="min-width: 200px">
      <template #body="{ data }">
        {{ data.total_weight / 1000 }} Kgs
      </template>
    </Column>

    <Column field="unit_count" :header="$t('harvest.table.count_details')" sortable style="min-width: 200px">
      <template #body="{ data }">
        {{ data.unit_count }}
      </template>
    </Column>

    <Column field="farmer_name" filterField="farmer.id" :showFilterMatchModes="false" :header="$t('harvest.table.responsible')" sortable style="min-width: 200px">
      <template #body="{ data }">
        {{ data.farmer_name }}
      </template>
      <template #filter="{ filterModel }">
        <Select v-model="filterModel.value" :options="filter_user_options" optionLabel="text" placeholder="Todos" />
      </template>
    </Column>

    <Column :exportable="false" style="min-width: 130px" v-if="props.show_actions">
      <template #body="slotProps">
        <Link :href="route('harvests.edit', slotProps.data.id)">
          <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
        </Link>
        <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
          @click="deleteHandler(slotProps.data)" />
      </template>
    </Column>
  </Datatable>
</template>

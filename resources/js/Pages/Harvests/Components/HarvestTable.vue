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
import DatePicker from 'primevue/datepicker';

import { useI18n } from 'vue-i18n';

import Datatable from '@/Components/Table/Datatable.vue';
import HarvestService from '@/Services/HarvestService.js';
import { deleteRowTable } from '@/Utils/table.js';

import { stringToDate } from '@/Utils/date';
import { getDataSelects } from '@/Services/Selects';

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

const datatable = ref(null);

const filter_year_options = ref([]);
const harvest_available_weeks = ref([]);
const filter_field_options = ref([]);
const filter_quarter_options = ref([]);
const filter_user_options = ref([]);

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  year: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
  week: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
  batch: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  'details.plant.quarter.field_id': { value: null, matchMode: FilterMatchMode.EQUALS },
  'details.plant.quarter_id': { value: null, matchMode: FilterMatchMode.EQUALS },
  'farmer.id': { value: null, matchMode: FilterMatchMode.EQUALS },
};

const form = reactive({
  year: [],
  field: [],
  last_field: [],
  quarter: [],
});

const fetchHandler = async (params) => {
  const year = form.year.value;
  if (year) {
    if (params.filters?.year) {
      params = JSON.parse(JSON.stringify(params));
      params.filters.year.constraints.push({ value: year, matchMode: FilterMatchMode.EQUALS });
    } else {
      params.filters = {
        year: {
          operator: FilterOperator.AND,
          constraints: [{ value: year, matchMode: FilterMatchMode.EQUALS }],
        },
      };
    }
  }
  return await HarvestService.list({ ...params });
};

const filterHandler = async () => {
  datatable.value.loadLazyData();
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await HarvestService.del(record.id);
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
  const data = await getDataSelects({
    harvest_available_years: {},
    harvest_available_weeks: {},
    field: {},
    quarter: {},
    user: {},
  });

  const year_value_default = { value: null, text: 'Todos' };
  filter_year_options.value = [year_value_default, ...data.harvest_available_years];
  form.year = year_value_default;

  harvest_available_weeks.value = data.harvest_available_weeks;
  filter_field_options.value = data.field;
  filter_quarter_options.value = data.quarter;
  filter_user_options.value = data.user;
});
</script>

<template>
  <ConfirmDialog></ConfirmDialog>
  <Toast />

  <template v-if="props.show_filters">
    <CardSection wrapperClass="p-6 grid md:grid-cols-3 gap-x-16 gap-y-4 sm:grid-cols-1">
      <VSelect
        id="year"
        v-model="form.year"
        :placeholder="t('generics.please_select')"
        :options="filter_year_options"
        :label="t('harvest.table_filters.year')"
        @change="filterHandler"
      />
    </CardSection>
  </template>

  <Datatable
    ref="datatable"
    :filters="filters"
    :fetchHandler="fetchHandler"
    sortField="date"
    :sortOrder="1"
  >
    <Column field="week" :header="$t('harvest.table.date')" :showFilterMatchModes="false" sortable frozen style="min-width: 200px">
      <template #body="{ data }">
        {{ $t('harvest.table_data.date', { week: data.week }) }}
      </template>
      <template #filter="{ filterModel }">
        <Select v-model="filterModel.value" :options="harvest_available_weeks" optionLabel="text" placeholder="Todos" />
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

    <Column field="field_names" filterField="details.plant.quarter.field_id" :showFilterMatchModes="false" :header="$t('harvest.table.field')" sortable style="min-width: 200px">
      <template #body="{ data }">
        {{ data.field_names }}
      </template>
      <template #filter="{ filterModel }">
        <Select v-model="filterModel.value" :options="filter_field_options" optionLabel="text" placeholder="Todos" />
      </template>
    </Column>

    <Column field="quarter_names" filterField="details.plant.quarter_id" :showFilterMatchModes="false" :header="$t('harvest.table.quarter')" sortable style="min-width: 200px">
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

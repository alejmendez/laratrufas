<script setup>
import { ref, reactive, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';

import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import CardSection from '@Core/Components/CardSection.vue';
import Datatable from '@Core/Components/Table/Datatable.vue';
import VSelect from '@Core/Components/Form/VSelect.vue';

import LiquidationService from '@/Services/LiquidationService.js';
import { stringToFormat } from '@/Utils/date';
import { deleteRowTable } from '@/Utils/table.js';
import { getDataSelects } from '@/Services/Selects';
import { can } from '@/Services/Auth';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const datatable = ref(null);
const filter_importer_options = ref([]);
const filter_year_options = ref([]);

const form = reactive({
  year: [],
});

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  year: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
  liquidation_number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  delivery_date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  importer_id: { value: null, matchMode: FilterMatchMode.EQUALS },
};

const canShow = can('liquidations.show');
const canEdit = can('liquidations.edit');
const canDestroy = can('liquidations.destroy');
const canCreate = can('liquidations.create');

const headerLinks = [];
if (canCreate) {
  headerLinks.push({ to: 'liquidations.create', text: t('generics.new') });
}

const fetchHandler = async (params) => {
  if (!params.rows) {
    params.rows = 25;
  }

  const year = form.year.value;
  if (year) {
    params.filters = {
      ...params.filters,
      year: {
        operator: FilterOperator.AND,
        constraints: [{ value: year, matchMode: FilterMatchMode.EQUALS }],
      },
    };
  } else if (params.filters?.year) {
    delete params.filters.year;
  }
  return await LiquidationService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await LiquidationService.del(record.id);
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

const filterHandler = async () => {
  datatable.value.loadLazyData();
};

onMounted(async () => {
  if (props.toast) {
    toast.add({
      severity: 'success',
      summary: t('liquidation.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }

  const data = await getDataSelects({
    importer: {},
    liquidation_available_years: {},
  });

  filter_importer_options.value = data.importer;
  const year_value_default = { value: null, text: 'Todos' };
  filter_year_options.value = [year_value_default, ...data.liquidation_available_years];
  form.year = year_value_default;
});
</script>

<template>
  <AuthenticatedLayout :title="$t('liquidation.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('liquidation.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'liquidations.index', text: $t('liquidation.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="headerLinks"
    />

    <CardSection wrapperClass="p-6 mb-5 grid md:grid-cols-3 gap-x-16 gap-y-4 sm:grid-cols-1">
      <div>
        <div class="text-gray-400 pb-1">{{ t('harvest.table_filters.year') }}</div>
        <VSelect
          id="year"
          v-model="form.year"
          :placeholder="t('generics.please_select')"
          :options="filter_year_options"
          @change="filterHandler"
        />
      </div>
    </CardSection>

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      :sortOrder="1"
      scrollHeight="800px"
      sortField="week"
    >
      <Column field="week" :header="$t('liquidation.table.week')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.week }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por semana" />
        </template>
      </Column>

      <Column field="delivery_date" :header="$t('liquidation.table.delivery_date')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ stringToFormat(data.delivery_date) }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Fecha de Entrega" />
        </template>
      </Column>

      <Column field="importer_id" :header="$t('liquidation.table.importer_id')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.importer.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Exportador" />
        </template>
      </Column>

      <Column field="total_commercial" :header="$t('liquidation.table.total_commercial')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.total_commercial }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Exportador" />
        </template>
      </Column>

      <Column field="total_not_commercial" :header="$t('liquidation.table.total_not_commercial')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.total_not_commercial }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Exportador" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('liquidations.show', slotProps.data.id)" v-if="canShow">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-gray-600" />
          </Link>
          <Link :href="route('liquidations.edit', slotProps.data.id)" v-if="canEdit">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
            @click="deleteHandler(slotProps.data)" v-if="canDestroy" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

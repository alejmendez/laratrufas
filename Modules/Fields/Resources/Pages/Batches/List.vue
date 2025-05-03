<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';

import { trans } from 'laravel-vue-i18n';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import Datatable from '@Core/Components/Table/Datatable.vue';
import BatchService from '@Fields/Services/BatchService.js';
import { stringToFormat } from '@Core/Utils/date';
import { deleteRowTable } from '@Core/Utils/table.js';
import { getDataSelects } from '@Core/Services/Selects';
import { can } from '@Auth/Services/Auth';

const props = defineProps({
  toast: Object,
});

const toast = useToast();
const confirm = useConfirm();

const datatable = ref(null);
const filter_importer_options = ref([]);

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  batch_number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  delivery_date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  importer_id: { value: null, matchMode: FilterMatchMode.EQUALS },
};

const canEdit = can('batches.edit');
const canDestroy = can('batches.destroy');

const headerLinks = [];
if (can('batches.create')) {
  headerLinks.push({ to: 'batches.create', text: 'generics.new' });
}

const fetchHandler = async (params) => {
  return await BatchService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(confirm, async () => {
    const result = await BatchService.del(record.id);
    if (result) {
      datatable.value.loadLazyData();
      return toast.add({
        severity: 'success',
        summary: trans('generics.messages.deleted_successfully_summary'),
        detail: trans('generics.messages.deleted_successfully'),
        life: 3000,
      });
    }
    toast.add({
      severity: 'error',
      summary: trans('generics.tables.errors.could_not_delete_the_record_summary'),
      detail: trans('generics.tables.errors.could_not_delete_the_record'),
      life: 3000,
    });
  });
};

onMounted(async () => {
  if (props.toast) {
    toast.add(props.toast);
  }

  const data = await getDataSelects({
    importer: {},
  });

  filter_importer_options.value = data.importer;
});
</script>

<template>
  <AuthenticatedLayout :title="__('batch.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="__('batch.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'batches.index', text: __('batch.titles.entity_breadcrumb') }, { text: __('generics.list') }]"
      :links="headerLinks"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="batch_number"
      :sortOrder="1"
    >
      <Column field="batch_number" :header="__('batch.table.batch_number')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.batch_number }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por número" />
        </template>
      </Column>

      <Column field="delivery_date" :header="__('batch.table.delivery_date')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ stringToFormat(data.delivery_date) }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Fecha de Entrega" />
        </template>
      </Column>

      <Column field="importer_id" :header="__('batch.table.importer_id')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.importer.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Exportador" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('batches.edit', slotProps.data.id)" v-if="canEdit">
            <span class="material-symbols-rounded cursor-pointer transition-all text-slate-500 hover:text-emerald-600">edit</span>
          </Link>
          <span
            class="material-symbols-rounded cursor-pointer transition-all text-slate-500 hover:text-pink-600"
            @click="deleteHandler(slotProps.data)"
            v-if="canDestroy"
          >
            delete
          </span>
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

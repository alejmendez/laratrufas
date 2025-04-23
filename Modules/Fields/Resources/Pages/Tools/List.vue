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
import ToolService from '@Fields/Services/ToolService.js';
import { stringToFormat } from '@Core/Utils/date';
import { deleteRowTable } from '@Core/Utils/table.js';
import { can } from '@Auth/Services/Auth';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();

const datatable = ref(null);

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  purchase_date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  last_maintenance: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  purchase_location: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  contact: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const canEdit = can('tools.edit');
const canDestroy = can('tools.destroy');
const canCreate = can('tools.create');

const headerLinks = [];
if (canCreate) {
  headerLinks.push({ to: 'tools.create', text: trans('generics.new') });
}

const fetchHandler = async (params) => {
  return await ToolService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(trans, confirm, async () => {
    const result = await ToolService.del(record.id);
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
      severity: 'danger',
      summary: trans('generics.tables.errors.could_not_delete_the_record_summary'),
      detail: trans('generics.tables.errors.could_not_delete_the_record'),
      life: 3000,
    });
  });
};

onMounted(() => {
  if (props.toast) {
    toast.add({
      severity: 'success',
      summary: trans('tool.titles.entity_breadcrumb'),
      detail: trans('generics.messages.saved_successfully'),
      life: 5000,
    });
  }
});
</script>

<template>
  <AuthenticatedLayout :title="__('tool.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="__('tool.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'tools.index', text: __('tool.titles.entity_breadcrumb') }, { text: __('generics.list') }]"
      :links="headerLinks"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="name"
      :sortOrder="1"
    >
      <Column field="name" :header="__('tool.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
      </Column>

      <Column field="purchase_date" :header="__('tool.table.purchase_date')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ stringToFormat(data.purchase_date) }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Fecha de Compra" />
        </template>
      </Column>

      <Column field="last_maintenance" :header="__('tool.table.last_maintenance')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.last_maintenance ? stringToFormat(data.last_maintenance) : 's/i' }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por última Mantención" />
        </template>
      </Column>

      <Column field="purchase_location" :header="__('tool.table.purchase_location')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.purchase_location }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Lugar de Compra" />
        </template>
      </Column>

      <Column field="contact" :header="__('tool.table.contact')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.contact }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Contacto" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('tools.edit', slotProps.data.id)" v-if="canEdit">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
            @click="deleteHandler(slotProps.data)" v-if="canDestroy" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

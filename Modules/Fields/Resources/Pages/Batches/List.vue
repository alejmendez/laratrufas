<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';

import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import Datatable from '@Core/Components/Table/Datatable.vue';
import BatchService from '@Fields/Services/BatchService.js';
import { stringToFormat } from '@Core/Utils/date';
import { deleteRowTable } from '@Core/Utils/table.js';
import { getDataSelects } from '@Core/Services/Selects';
import { can } from '@Auth/Services/Auth';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

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
  headerLinks.push({ to: 'batches.create', text: t('generics.new') });
}

const fetchHandler = async (params) => {
  return await BatchService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await BatchService.del(record.id);
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
      summary: t('batch.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }

  const data = await getDataSelects({
    importer: {},
  });

  filter_importer_options.value = data.importer;
});
</script>

<template>
  <AuthenticatedLayout :title="$t('batch.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('batch.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'batches.index', text: $t('batch.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="headerLinks"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="batch_number"
      :sortOrder="1"
    >
      <Column field="batch_number" :header="$t('batch.table.batch_number')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.batch_number }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por número" />
        </template>
      </Column>

      <Column field="delivery_date" :header="$t('batch.table.delivery_date')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ stringToFormat(data.delivery_date) }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Fecha de Entrega" />
        </template>
      </Column>

      <Column field="importer_id" :header="$t('batch.table.importer_id')" sortable style="min-width: 200px">
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
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
              @click="deleteHandler(slotProps.data)" v-if="canDestroy" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

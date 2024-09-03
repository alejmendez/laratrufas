<script setup>
import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';

import { useI18n } from 'vue-i18n';

import Datatable from '@/Components/Table/Datatable.vue';
import BatchService from '@/Services/BatchService.js';
import { stringToFormat } from '@/Utils/date';
import { deleteRowTable } from '@/Utils/table.js';
import { getDataSelects } from '@/Services/Selects';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const datatable = ref(null);
const filter_importer_options = ref([]);

if (props.toast) {
  toast.add({ severity: 'success', detail: t('generics.messages.saved_successfully'), life: 3000 });
}

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  batch_number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  delivery_date: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  importer_id: { value: null, matchMode: FilterMatchMode.EQUALS },
};

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
  <Head :title="$t('batch.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="$t('batch.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'batches.index', text: $t('batch.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="[{ to: 'batches.create', text: $t('generics.new') }]"
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
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Importador" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('batches.edit', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
              @click="deleteHandler(slotProps.data)" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

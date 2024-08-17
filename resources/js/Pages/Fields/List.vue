<script setup>
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';

import { useI18n } from 'vue-i18n';

import Datatable from '@/Components/Table/Datatable.vue';
import FieldService from '@/Services/FieldService.js';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

if (props.toast) {
  toast.add({ severity: 'success', detail: t('generics.messages.saved_successfully'), life: 3000 });
}

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  location: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  size: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const fetchHandler = async (params) => {
  return await FieldService.list(params);
}

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
</script>

<template>
  <Head :title="$t('field.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="$t('field.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'fields.index', text: $t('field.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="[{ to: 'fields.create', text: $t('generics.new') }]"
    />

    <ConfirmDialog></ConfirmDialog>
    <Toast />

    <Datatable
      :filters="filters"
      :fetchHandler="fetchHandler"
      :deleteHandler="deleteHandler"
      sortField="name"
      :sortOrder="1"
    >
      <Column field="name" :header="$t('field.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
      </Column>
      <Column field="location" :header="$t('field.table.location')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.location }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por ubicacion" />
        </template>
      </Column>
      <Column field="size" :header="$t('field.table.size')" sortable style="min-width: 100px">
        <template #body="{ data }">
          {{ data.size }} ha
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por tamaño" />
        </template>
      </Column>
      <Column field="plants_count" :header="$t('field.table.plants_count')" sortable style="min-width: 100px">
        <template #body="{ data }">
          {{ data.plants_count }}
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('fields.show', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
          </Link>
          <Link :href="route('fields.edit', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
              @click="deleteHandler(slotProps.data)" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

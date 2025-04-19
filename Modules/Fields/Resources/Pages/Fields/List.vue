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
import FieldService from '@/Services/FieldService.js';
import { deleteRowTable } from '@/Utils/table.js';
import { can } from '@/Services/Auth';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const datatable = ref(null);

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  location: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  size: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const canShow = can('fields.show');
const canEdit = can('fields.edit');
const canDestroy = can('fields.destroy');
const canCreate = can('fields.create');

const headerLinks = [];
if (canCreate) {
  headerLinks.push({ to: 'fields.create', text: t('generics.new') });
}

const fetchHandler = async (params) => {
  return await FieldService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await FieldService.del(record.id);
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

onMounted(() => {
  if (props.toast) {
    toast.add({
      severity: 'success',
      summary: t('field.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }
});
</script>

<template>
  <AuthenticatedLayout :title="$t('field.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('field.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'fields.index', text: $t('field.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="headerLinks"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
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
          <Link :href="route('fields.show', slotProps.data.id)" v-if="canShow">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-gray-600" />
          </Link>
          <Link :href="route('fields.edit', slotProps.data.id)" v-if="canEdit">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
            @click="deleteHandler(slotProps.data)" v-if="canDestroy" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

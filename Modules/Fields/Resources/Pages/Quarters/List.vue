<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import Datatable from '@/Components/Table/Datatable.vue';
import QuarterService from '@/Services/QuarterService.js';
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
const filter_field_options = ref([]);

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  'quarters.name': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  field_id: { value: null, matchMode: FilterMatchMode.EQUALS },
  area: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const canShow = can('quarters.show');
const canEdit = can('quarters.edit');
const canDestroy = can('quarters.destroy');
const canCreate = can('quarters.create');

const headerLinks = [];
if (canCreate) {
  headerLinks.push({ to: 'quarters.create', text: t('generics.new') });
}

const fetchHandler = async (params) => {
  return await QuarterService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await QuarterService.del(record.id);
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
      summary: t('quarter.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }

  const data = await getDataSelects({
    field: {},
  });

  filter_field_options.value = data.field;
});
</script>

<template>
  <AuthenticatedLayout :title="t('quarter.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="t('quarter.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'quarters.index', text: t('quarter.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
      :links="headerLinks"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="name"
      :sortOrder="1"
    >
      <Column field="name" filterField="quarters.name" :header="$t('quarter.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
      </Column>
      <Column field="field_name" filterField="field_id" :showFilterMatchModes="false" :header="$t('quarter.table.field_id')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.field_name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_field_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>
      <Column field="area" :header="$t('quarter.table.area')" sortable style="min-width: 100px">
        <template #body="{ data }">
          {{ data.area }} ha
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por area" />
        </template>
      </Column>
      <Column field="plants_count" :header="$t('quarter.table.plants_count')" sortable style="min-width: 100px">
        <template #body="{ data }">
          {{ data.plants_count }}
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('quarters.show', slotProps.data.id)" v-if="canShow">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-gray-600" />
          </Link>
          <Link :href="route('quarters.edit', slotProps.data.id)" v-if="canEdit">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
            @click="deleteHandler(slotProps.data)" v-if="canDestroy" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

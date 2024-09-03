<script setup>
import { ref, onMounted } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

import { useI18n } from 'vue-i18n';
import slugify from '@/Utils/slugify';

import Datatable from '@/Components/Table/Datatable.vue';
import UserService from '@/Services/UserService.js';
import { deleteRowTable } from '@/Utils/table.js';
import { getDataSelects } from '@/Services/Selects';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const datatable = ref(null);
const filter_role_options = ref([]);

if (props.toast) {
  toast.add({ severity: 'success', detail: t('generics.messages.saved_successfully'), life: 3000 });
}

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  dni: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  phone: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  'roles.name': { value: null, matchMode: FilterMatchMode.EQUALS },
  email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const fetchHandler = async (params) => {
  return await UserService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await UserService.del(record.id);
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
      summary: t('user.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }

  const data = await getDataSelects({
    role: {},
  });

  filter_role_options.value = data.role;
});
</script>

<template>
  <Head :title="$t('user.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="$t('user.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'users.index', text: $t('user.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="[{ to: 'users.create', text: $t('generics.new') }]"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="name"
      :sortOrder="1"
    >
      <Column field="name" :header="$t('user.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
      </Column>

      <Column field="dni" :header="$t('user.table.dni')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.dni }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Dni" />
        </template>
      </Column>

      <Column field="phone" :header="$t('user.table.phone')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.phone }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Telefono" />
        </template>
      </Column>

      <Column field="roles.name" :header="$t('user.table.role')" :showFilterMatchModes="false" style="min-width: 200px">
        <template #body="{ data }">
          <span
            v-for="role in data.roles"
            class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none border rounded-full role"
            :class="slugify(role.name)"
          >
            {{ role.name }}
          </span>
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_role_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>

      <Column field="email" :header="$t('user.table.email')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.email }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Email" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('users.show', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
          </Link>
          <Link :href="route('users.edit', slotProps.data.id)">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
              @click="deleteHandler(slotProps.data)" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

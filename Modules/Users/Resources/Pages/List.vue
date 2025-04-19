<script setup>
import { ref, onMounted } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

import { useI18n } from 'vue-i18n';
import slugify from '@/Utils/slugify';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import Datatable from '@Core/Components/Table/Datatable.vue';
import UserService from '@/Services/UserService.js';
import { deleteRowDatatable } from '@/Utils/table.js';
import { getDataSelects } from '@/Services/Selects';
import { can } from '@/Services/Auth';

const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const page = usePage();
const current_user_id = page.props.auth.user.id;

const datatable = ref(null);
const filter_role_options = ref([]);

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  dni: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  phone: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  'roles.name': { value: null, matchMode: FilterMatchMode.EQUALS },
  email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const canShow = can('users.show');
const canEdit = can('users.edit');
const canDestroy = can('users.destroy');

const headerLinks = [];
if (can('users.create')) {
  headerLinks.push({ to: 'users.create', text: t('generics.new') });
}

const fetchHandler = async (params) => {
  return await UserService.list(params);
};

const deleteHandler = async (record) => {
  const options = {
    datatable,
    confirm,
    toast,
    t,
    entity: t('user.titles.entity_breadcrumb'),
    handler: () => UserService.del(record.id),
  };

  deleteRowDatatable(options);
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
  <AuthenticatedLayout :title="$t('user.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('user.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'users.index', text: $t('user.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="headerLinks"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="full_name"
      :sortOrder="1"
    >
      <Column field="full_name" :header="$t('user.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.full_name }}
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
          <Link :href="route('users.show', slotProps.data.id)" v-if="canShow">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-gray-600" />
          </Link>
          <Link :href="route('users.edit', slotProps.data.id)" v-if="canEdit">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600" />
          </Link>
          <font-awesome-icon
            :icon="['fas', 'trash-can']"
            class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
            @click="deleteHandler(slotProps.data)"
            v-if="canDestroy && slotProps.data.id !== current_user_id"
          />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

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
import { getAge } from '@/Utils/date';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import Datatable from '@Core/Components/Table/Datatable.vue';
import DogService from '@/Services/DogService.js';
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
const filter_quarter_options = ref([]);
const filter_couple_options = ref([]);
const filter_gender_options = ref([
  { value: 'M', text: t('dog.form.gender.options.male') },
  { value: 'F', text: t('dog.form.gender.options.female') },
]);

const genders = {
  M: t('dog.form.gender.options.male'),
  F: t('dog.form.gender.options.female'),
};

const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  quarter_id: { value: null, matchMode: FilterMatchMode.EQUALS },
  gender: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  breed: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  veterinary: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  couple_id: { value: null, matchMode: FilterMatchMode.EQUALS },
};

const canShow = can('dogs.show');
const canEdit = can('dogs.edit');
const canDestroy = can('dogs.destroy');
const canCreate = can('dogs.create');

const headerLinks = [];
if (canCreate) {
  headerLinks.push({ to: 'dogs.create', text: t('generics.new') });
}

const fetchHandler = async (params) => {
  return await DogService.list(params);
};

const deleteHandler = (record) => {
  deleteRowTable(t, confirm, async () => {
    const result = await DogService.del(record.id);
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
      summary: t('dog.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }

  const data = await getDataSelects({
    quarter: {},
    couple: {},
  });

  filter_quarter_options.value = data.quarter;
  filter_couple_options.value = data.couple;
});
</script>

<template>
  <AuthenticatedLayout :title="$t('dog.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('dog.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'dogs.index', text: $t('dog.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="headerLinks"
    />

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="name"
      :sortOrder="1"
    >
      <Column field="name" :header="$t('dog.table.name')" sortable frozen style="min-width: 200px">
        <template #body="{ data }">
          {{ data.name }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
      </Column>

      <Column field="quarter.name" :header="$t('dog.table.quarter')" :showFilterMatchModes="false" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.quarter.name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_quarter_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>

      <Column field="gender" :header="$t('dog.table.gender')" :showFilterMatchModes="false" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ genders[data.gender] }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_gender_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>

      <Column field="breed" :header="$t('dog.table.breed')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.breed }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" :placeholder="'Buscar por ' + $t('dog.table.breed')" />
        </template>
      </Column>

      <Column field="age" :header="$t('dog.table.age')" style="min-width: 100px">
        <template #body="{ data }">
          {{ getAge(data.birthdate) }}
        </template>
      </Column>

      <Column field="veterinary" :header="$t('dog.table.veterinary')" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.veterinary }}
        </template>
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Veterinario" />
        </template>
      </Column>

      <Column field="couple.name" :header="$t('dog.table.couple')" :showFilterMatchModes="false" sortable style="min-width: 200px">
        <template #body="{ data }">
          {{ data.couple?.full_name }}
        </template>
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="filter_couple_options" optionLabel="text" placeholder="Todos" />
        </template>
      </Column>

      <Column :exportable="false" style="min-width: 130px">
        <template #body="slotProps">
          <Link :href="route('dogs.show', slotProps.data.id)" v-if="canShow">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-gray-600" />
          </Link>
          <Link :href="route('dogs.edit', slotProps.data.id)" v-if="canEdit">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
            @click="deleteHandler(slotProps.data)" v-if="canDestroy" />
        </template>
      </Column>
    </Datatable>
  </AuthenticatedLayout>
</template>

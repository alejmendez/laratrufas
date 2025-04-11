<script setup>
import { ref, reactive } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { useI18n } from 'vue-i18n';

import VInput from '@/Components/Form/VInput.vue';
import VInputDni from '@/Components/Form/VInputDni.vue';
import Datatable from '@/Components/Table/Datatable.vue';
import ownerService from '@/Services/OwnerService.js';
import { deleteRowDatatable } from '@/Utils/table.js';
import { can } from '@/Services/Auth';
const props = defineProps({
  toast: String,
});

const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const showModal = ref(false);

const datatable = ref(null);
const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  dni: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const loading = ref(false);
const form = reactive({
  id: null,
  name: null,
  dni: null,
  errors: {},
});

const canCreate = can('owners.create');
const canEdit = can('owners.edit');
const canDestroy = can('owners.destroy');

const showSuccessToast = () => {
  toast.add({
    severity: 'success',
    summary: t('owner.titles.entity_breadcrumb'),
    detail: t('generics.messages.saved_successfully'),
    life: 5000,
  });

  form.id = null;
  form.name = null;
  form.dni = null;
  form.errors = {};
};

const showErrorToast = () => {
  toast.add({
    severity: 'danger',
    summary: t('owner.titles.entity_breadcrumb'),
    detail: t('generics.errors.trying_to_save'),
    life: 5000,
  });
};

const fetchHandler = async (params) => {
  return await ownerService.list(params);
};

const deleteHandler = async (record) => {
  const options = {
    datatable,
    confirm,
    toast,
    t,
    entity: t('owner.titles.entity_breadcrumb'),
    handler: () => ownerService.del(record.id),
  };

  deleteRowDatatable(options);
};

const handleSave = async (saveAction) => {
  loading.value = true;
  form.errors = {};

  try {
    await saveAction();
    showModal.value = false;
    showSuccessToast();
  } catch (error) {
    const errors = error.response?.data?.errors;
    if (errors) {
      Object.keys(errors).forEach((key) => {
        form.errors[key] = errors[key].join(', ');
      });
    }
    showErrorToast();
  } finally {
    datatable.value.loadLazyData();
    loading.value = false;
  }
};

const createHandler = () => {
  const saveAction = () =>
    ownerService.create({
      name: form.name,
      dni: form.dni,
    });

  handleSave(saveAction);
};

const editHandler = (record) => {
  form.id = record.id;
  form.name = record.name;
  form.dni = record.dni;
  showModal.value = true;
};

const updateHandler = () => {
  const saveAction = () =>
    ownerService.update(form.id, {
      name: form.name,
      dni: form.dni,
    });

  handleSave(saveAction);
};
</script>

<template>
  <Head :title="$t('owner.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="$t('owner.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'owners.index', text: $t('owner.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
    >
      <Button
        :label="$t('generics.new')"
        @click="showModal = true"
        v-if="canCreate"
      />
    </HeaderCrud>

    <Datatable
      ref="datatable"
      :filters="filters"
      :fetchHandler="fetchHandler"
      sortField="name"
      :sortOrder="1"
    >
      <Column field="name" :header="$t('owner.table.name')" sortable frozen style="min-width: 200px">
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
        <template #body="{ data }">
          {{ data.name }}
        </template>
      </Column>

      <Column field="dni" :header="$t('owner.table.dni')" sortable style="min-width: 200px">
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Dni" />
        </template>
        <template #body="{ data }">
          {{ data.dni }}
        </template>
      </Column>

      <Column :exportable="false" style="width: 130px">
        <template #body="slotProps">
          <font-awesome-icon
            :icon="['fas', 'pencil']"
            class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-lime-600"
            @click="editHandler(slotProps.data)"
            v-if="canEdit"
          />
          <font-awesome-icon
            :icon="['fas', 'trash-can']"
            class="mr-4 cursor-pointer transition-all text-slate-500 hover:text-red-600"
            @click="deleteHandler(slotProps.data)"
            v-if="canDestroy"
          />
        </template>
      </Column>
    </Datatable>

    <Dialog v-model:visible="showModal" modal :header="form.id ? $t('owner.titles.edit') : $t('owner.titles.create')" :style="{ width: '25rem' }">
      <VInput
        id="name"
        v-model="form.name"
        :label="t('owner.form.name.label')"
        :message="form.errors.name"
      />

      <VInputDni
        id="dni"
        v-model="form.dni"
        :label="t('owner.form.dni.label')"
        :message="form.errors.dni"
      />

      <div class="flex justify-end gap-2 mt-4">
        <Button
          type="button"
          :label="$t('generics.buttons.cancel')"
          severity="secondary"
          @click="showModal = false"
          :loading="loading"
        />
        <Button
          type="button"
          :label="form.id ? $t('generics.buttons.save_edit') : $t('generics.buttons.create')"
          @click="form.id ? updateHandler() : createHandler()"
          :loading="loading"
        />
      </div>
    </Dialog>
  </AuthenticatedLayout>
</template>

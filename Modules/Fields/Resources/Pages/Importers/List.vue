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

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';

import VInput from '@Core/Components/Form/VInput.vue';
import Datatable from '@Core/Components/Table/Datatable.vue';
import importerService from '@Fields/Services/ImporterService.js';
import { deleteRowDatatable } from '@Core/Utils/table.js';
import { can } from '@Auth/Services/Auth';
const toast = useToast();
const confirm = useConfirm();
const { t } = useI18n();

const showModal = ref(false);

const datatable = ref(null);
const filters = {
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
  slug: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const loading = ref(false);
const form = reactive({
  id: null,
  name: null,
  errors: {},
});

const canCreate = can('importers.create');
const canEdit = can('importers.edit');
const canDestroy = can('importers.destroy');

const showSuccessToast = () => {
  toast.add({
    severity: 'success',
    summary: t('importer.titles.entity_breadcrumb'),
    detail: t('generics.messages.saved_successfully'),
    life: 5000,
  });

  form.id = null;
  form.name = null;
  form.errors = {};
};

const showErrorToast = () => {
  toast.add({
    severity: 'danger',
    summary: t('importer.titles.entity_breadcrumb'),
    detail: t('generics.errors.trying_to_save'),
    life: 5000,
  });
};

const fetchHandler = async (params) => {
  return await importerService.list(params);
};

const deleteHandler = async (record) => {
  const options = {
    datatable,
    confirm,
    toast,
    t,
    entity: t('importer.titles.entity_breadcrumb'),
    handler: () => importerService.del(record.id),
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
    importerService.create({
      name: form.name,
    });

  handleSave(saveAction);
};

const editHandler = (record) => {
  form.id = record.id;
  form.name = record.name;
  showModal.value = true;
};

const updateHandler = () => {
  const saveAction = () =>
    importerService.update(form.id, {
      name: form.name,
    });

  handleSave(saveAction);
};
</script>

<template>
  <AuthenticatedLayout :title="$t('importer.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('importer.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'importers.index', text: $t('importer.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
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
      <Column field="name" :header="$t('importer.table.name')" sortable frozen style="min-width: 200px">
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
        <template #body="{ data }">
          {{ data.name }}
        </template>
      </Column>

      <Column field="slug" :header="$t('importer.table.slug')" sortable style="min-width: 200px">
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por Codigo" />
        </template>
        <template #body="{ data }">
          {{ data.slug }}
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

    <Dialog v-model:visible="showModal" modal :header="form.id ? $t('importer.titles.edit') : $t('importer.titles.create')" :style="{ width: '25rem' }">
      <VInput
        id="name"
        v-model="form.name"
        :label="t('importer.form.name.label')"
        :message="form.errors.name"
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

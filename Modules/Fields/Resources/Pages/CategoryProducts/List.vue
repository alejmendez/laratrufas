<script setup>
import { ref, reactive } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { FilterMatchMode, FilterOperator } from '@primevue/core/api';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { useI18n } from 'vue-i18n';

import VInput from '@/Components/Form/VInput.vue';
import VCheckbox from '@/Components/Form/VCheckbox.vue';
import Datatable from '@/Components/Table/Datatable.vue';
import categoryProductService from '@/Services/CategoryProductService.js';
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
  is_commercial: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
};

const loading = ref(false);
const form = reactive({
  id: null,
  name: null,
  is_commercial: false,
  errors: {},
});

const isCommercialOptions = ref([
  { label: t('generics.all'), value: null },
  { label: t('generics.yes'), value: true },
  { label: t('generics.no'), value: false },
]);

const canEdit = can('category_products.edit');
const canDestroy = can('category_products.destroy');
const canCreate = can('category_products.create');

const showSuccessToast = () => {
  toast.add({
    severity: 'success',
    summary: t('category_product.titles.entity_breadcrumb'),
    detail: t('generics.messages.saved_successfully'),
    life: 5000,
  });

  form.id = null;
  form.name = null;
  form.is_commercial = false;
  form.errors = {};
};

const showErrorToast = () => {
  toast.add({
    severity: 'danger',
    summary: t('category_product.titles.entity_breadcrumb'),
    detail: t('generics.errors.trying_to_save'),
    life: 5000,
  });
};

const fetchHandler = async (params) => {
  return await categoryProductService.list(params);
};

const deleteHandler = async (record) => {
  const options = {
    datatable,
    confirm,
    toast,
    t,
    entity: t('category_product.titles.entity_breadcrumb'),
    handler: () => categoryProductService.del(record.id),
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
    categoryProductService.create({
      name: form.name,
      is_commercial: form.is_commercial,
    });

  handleSave(saveAction);
};

const editHandler = (record) => {
  form.id = record.id;
  form.name = record.name;
  form.is_commercial = record.is_commercial;
  showModal.value = true;
};

const updateHandler = () => {
  const saveAction = () =>
    categoryProductService.update(form.id, {
      name: form.name,
      is_commercial: form.is_commercial,
    });

  handleSave(saveAction);
};
</script>

<template>
  <Head :title="$t('category_product.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="$t('category_product.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'category_products.index', text: $t('category_product.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
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
      <Column field="name" :header="$t('category_product.table.name')" sortable frozen style="min-width: 200px">
        <template #filter="{ filterModel }">
          <InputText v-model="filterModel.value" type="text" placeholder="Buscar por nombre" />
        </template>
        <template #body="{ data }">
          {{ data.name }}
        </template>
      </Column>

      <Column field="is_commercial" :header="$t('category_product.table.is_commercial')" sortable style="min-width: 200px">
        <template #filter="{ filterModel }">
          <Select v-model="filterModel.value" :options="isCommercialOptions" placeholder="Buscar por es comercial" />
        </template>
        <template #body="{ data }">
          <span
            class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none border rounded-full"
            :class="data.is_commercial ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
          >
            {{ data.is_commercial ? t('generics.yes') : t('generics.no') }}
          </span>
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

    <Dialog v-model:visible="showModal" modal :header="form.id ? $t('category_product.titles.edit') : $t('category_product.titles.create')" :style="{ width: '25rem' }">
      <VInput
        id="name"
        v-model="form.name"
        :label="t('category_product.form.name.label')"
        :message="form.errors.name"
      />

      <VCheckbox
        id="is_commercial"
        v-model="form.is_commercial"
        classWrapper="my-3"
        :label="t('category_product.form.is_commercial.label')"
        :message="form.errors.is_commercial"
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

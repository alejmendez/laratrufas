<script setup>
import { ref, onMounted, useAttrs } from 'vue';

import DataTable from 'primevue/datatable';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';

const props = defineProps({
  filters: Object,
  fetchHandler: Function,
});

const attrs = useAttrs();

const filters = ref({ ...props.filters });

const loading = ref(true);

const initLazyParams = {};
if (attrs.sortField) {
  initLazyParams.sortField = attrs.sortField;
}

if (attrs.sortOrder) {
  initLazyParams.sortOrder = attrs.sortOrder;
}

const lazyParams = ref(initLazyParams);
const records = ref([]);
const metadata = ref({
  total: 1,
  from: 1,
  to: 1,
  current_page: 1,
  last_page: 1,
  per_page: 10,
});

const loadLazyData = async () => {
  loading.value = true;
  lazyParams.value = { ...lazyParams.value };

  const response = await props.fetchHandler(lazyParams.value);

  records.value = response.data;
  metadata.value = response;
  loading.value = false;
};

defineExpose({ loadLazyData });

const onPage = (event) => {
  lazyParams.value = event;
  loadLazyData();
};

const onSort = (event) => {
  lazyParams.value = event;
  loadLazyData();
};

const onFilter = () => {
  lazyParams.value.filters = filters.value;
  loadLazyData();
};

const clearFilter = () => {
  lazyParams.value.filters = {};
  loadLazyData();
};

onMounted(() => {
  loadLazyData();
});
</script>

<template>
  <div class="overflow-x-auto sm:w-[calc(100vw-65px)] md:w-[calc(100vw-65px)] lg:w-full">
    <DataTable
      class="w-full"
      lazy
      dataKey="id"
      filterDisplay="menu"
      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
      v-model:filters="filters"
      scrollable
      scrollHeight="500px"
      tableStyle="min-width: 100px"
      v-bind="attrs"
      :value="records"
      :totalRecords="metadata.total"
      :first="metadata.from"
      :last="metadata.to"
      :currentPage="metadata.current_page"
      :totalPages="metadata.last_page"
      :rows="metadata.per_page"
      :paginator="true"
      :filters="filters"
      :rowsPerPageOptions="[5, 10, 25, 50, 100]"
      :loading="loading"
      :currentPageReportTemplate="$t('generics.tables.pagination.template', metadata)"
      @page="onPage($event)"
      @sort="onSort($event)"
      @filter="onFilter($event)"
    >
      <template #header>
        <div class="flex justify-between">
          <div class="sm:hidden md:block">
            <Button
              type="button"
              icon="pi pi-filter-slash"
              label="Limpiar"
              outlined
              @click="clearFilter"
            />
          </div>
          <IconField>
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText v-model="filters['global'].value" :placeholder="$t('generics.tables.search') + '...'" @keyup.enter="onFilter" />
          </IconField>
        </div>
      </template>

      <template #empty> {{ $t('generics.tables.empty') }} </template>

      <slot></slot>
    </DataTable>
  </div>
</template>

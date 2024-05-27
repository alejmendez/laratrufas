<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import { getWeek } from 'date-fns';
import { stringToDate } from '@/Utils/date';

import { deleteRowTable } from '@/Utils/table';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import TableList from '@/Components/Table/TableList.vue';

const { t } = useI18n();
const toast = useToast();

const props = defineProps({
  order: String,
  search: String,
  data: Object,
  toast: String,
});

if (props.toast) {
  toast.success(t('generics.messages.saved_successfully'));
}

const columns = [
  { text: t('harvest.table.date'), data: 'date' },
  { text: t('harvest.table.batch'), data: 'batch' },
  { text: t('harvest.table.weight'), data: 'weight' },
  { text: t('harvest.table.plant'), data: 'plant' },
  { text: t('harvest.table.quarter'), data: 'quarter' },
  { text: t('harvest.table.responsible'), data: 'responsible' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('harvests.destroy', id));
  });
};
</script>

<template>
  <Head :title="t('harvest.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('harvest.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
      :links="[{ to: 'harvests.create', text: t('generics.new') }]"
    />

    <TableList
      :columns="columns"
      :meta="props.data.meta"
      :search="props.search"
      :order="props.order"
    >
      <tr
          class="border-b hover:bg-neutral-100"
          v-for="harvest of data.data"
          :key="harvest.id"
      >
        <td>Semana {{ getWeek(stringToDate(harvest.date), { weekStartsOn: 1 }) }}</td>
        <td>{{ harvest.batch }}</td>
        <td>{{ harvest.detail?.reduce((total, d) => total + (d.weight * d.number), 0) }}</td>
        <td>{{ harvest.detail?.map(d => d.plant.code).join(', ') }}</td>
        <td>{{ harvest.quarters?.map(d => d.name).join(', ') }}</td>
        <td>{{ harvest.farmer.name }}</td>
        <td>
          <Link :href="route('harvests.show', harvest.id)">
            <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
          </Link>
          <Link :href="route('harvests.edit', harvest.id)">
            <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
          </Link>
          <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
            @click="deleteHandler(harvest.id)" />
        </td>
      </tr>
      <tr v-if="data.data.length === 0" class="border-b hover:bg-neutral-100">
        <td :colspan="columns.length + 1" class="text-center">
          {{ t('generics.tables.empty') }}
        </td>
      </tr>
    </TableList>
  </AuthenticatedLayout>
</template>

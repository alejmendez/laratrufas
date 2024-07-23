<script setup>
import { reactive } from 'vue';
import { useI18n } from 'vue-i18n';
import { router } from '@inertiajs/vue3';
import { getWeek } from 'date-fns';

import { stringToDate } from '@/Utils/date';
import { deleteRowTable } from '@/Utils/table';

const props = defineProps({
  order: String,
  search: String,
  show_filters: Boolean,
  show_actions: {
    type: Boolean,
    default: true,
  },
  filter_year: String,
  filter_year_options: Array,
  data: Object,
});

const { t } = useI18n();

const form = reactive({
  year: props.filter_year,
});

const columns = [
  { text: t('harvest.table.date'), data: 'date' },
  { text: t('harvest.table.batch'), data: 'batch' },
  { text: t('harvest.table.field'), data: 'field_names' },
  { text: t('harvest.table.quarter'), data: 'quarter_names' },
  { text: t('harvest.table.weight'), data: 'total_weight' },
  { text: t('harvest.table.count_details'), data: 'count_details' },
  { text: t('harvest.table.responsible'), data: 'farmer_name' },
];

const filterHandler = () => {
  const url = new URL(window.location.href);

  url.searchParams.set('filter_year', form.year);
  router.get(url);
}

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('harvests.destroy', id));
  });
};
</script>

<template>
  <TableList
    :columns="columns"
    :meta="props.data"
    :search="props.search"
    :order="props.order"
    :show_actions="props.show_actions"
  >
    <template v-slot:header v-if="props.show_filters">
      <div class="p-6 grid md:grid-cols-3 gap-x-16 gap-y-4 sm:grid-cols-1">
        <VSelect
          id="year"
          v-model="form.year"
          :placeholder="t('generics.please_select')"
          :options="props.filter_year_options"
          :label="t('harvest.table_filters.year')"
          @change="filterHandler"
        />
      </div>
    </template>
    <tr
        class="border-b hover:bg-neutral-100"
        v-for="harvest of data.data"
        :key="harvest.id"
    >
      <td>{{ $t('harvest.table_data.date', { week: getWeek(stringToDate(harvest.date), { weekStartsOn: 1 }) }) }}</td>
      <td>{{ harvest.batch }}</td>
      <td class="max-w-[200px] text-balance">{{ harvest.field_names }}</td>
      <td class="max-w-[200px] text-balance">{{ harvest.quarter_names }}</td>
      <td>{{ harvest.total_weight / 1000 }} Kgs</td>
      <td class="max-w-[200px] text-balance">
        {{ harvest.count_details }}
      </td>
      <td>{{ harvest.farmer_name }}</td>
      <td v-if="props.show_actions">
        <Link :href="route('harvests.edit', harvest.id)">
          <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
        </Link>
        <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
          @click="deleteHandler(harvest.id)" />
      </td>
    </tr>
    <tr v-if="data.data.length === 0" class="border-b hover:bg-neutral-100">
      <td :colspan="columns.length + 1" class="text-center">
        {{ $t('generics.tables.empty') }}
      </td>
    </tr>
  </TableList>
</template>

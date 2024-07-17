<script setup>
import PaginationTable from '@/Components/Table/PaginationTable.vue';
import SearchInput from '@/Components/Table/SearchInput.vue';

const props = defineProps({
  columns: Array,
  data: Array,
  meta: Object,
  search: String,
  order: String,
});

const orderUrl = (col) => {
  const url = new URL(window.location.href);
  url.searchParams.set('order', (col === props.order ? '-' : '') + col);
  return url.href;
};
</script>

<template>
  <div class="tableContainer">
    <slot name="header"></slot>

    <!-- Table responsive wrapper -->
    <div class="overflow-x-auto bg-white">
      <SearchInput :q="props.search" />

      <!-- Table -->
      <table>
        <!-- Table head -->
        <thead class="uppercase tracking-wider border-b-2">
          <tr>
            <th
              v-for="column of props.columns"
              :key="column.data"
              scope="col"
            >
              <Link :href="orderUrl(column.data)">
                {{ column.text }}
                <font-awesome-icon class="text-[#7B849C]" icon="sort-down" v-if="props.order === column.data" />
                <font-awesome-icon class="text-[#7B849C]" icon="sort-up" v-else-if="props.order[0] === '-' && props.order.substring(1) === column.data" />
                <font-awesome-icon class="text-[#7B849C]" icon="sort" v-else />
              </Link>
            </th>
            <th scope="col" class="w-[140px]">{{ $t('generics.tables.actions') }}</th>
          </tr>
        </thead>

        <!-- Table body -->
        <tbody>
          <slot />
        </tbody>
      </table>

      <PaginationTable :meta="props.meta" />
    </div>
  </div>
</template>

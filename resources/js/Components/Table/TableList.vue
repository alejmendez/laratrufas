<script setup>
import { useI18n } from 'vue-i18n'
import { Link } from '@inertiajs/vue3'
import PaginationTable from '@/Components/Table/PaginationTable.vue'
import SearchInput from '@/Components/Table/SearchInput.vue'

const { t } = useI18n()

const props = defineProps({
  columns: Array,
  data: Array,
  meta: Object,
  search: String,
  order: String,
})

const orderUrl = (col) => {
    const url = new URL(window.location.href)
    url.searchParams.set('order', (col === props.order ? '-' : '') + col)
    return url
}
</script>

<template>
    <div class="tableContainer">
        <!-- Table responsive wrapper -->
        <div class="overflow-x-auto bg-white">
            <SearchInput :q="props.search" />

            <!-- Table -->
            <table class="min-w-full text-left text-sm whitespace-nowrap border-t-2">
                <!-- Table head -->
                <thead class="uppercase tracking-wider border-b-2">
                    <tr>
                        <th
                            v-for="column of props.columns"
                            :key="column.data"
                            scope="col"
                            class="px-6 py-3 cursor-default"
                        >
                            <Link :href="orderUrl(column.data)">
                                {{ column.text }}
                                props.order
                                <font-awesome-icon :icon="['fa', 'sort']" />
                            </Link>
                        </th>
                        <th scope="col" class="px-6 py-3 w-[140px]">{{ t('generics.tables.actions') }}</th>
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

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useToast } from 'vue-toastification'
import { useI18n } from 'vue-i18n'
import Swal from 'sweetalert2'

import PaginationTable from './PaginationTable.vue'

const { t } = useI18n()

const props = defineProps({
  columns: Array,
  listHandler: {
    type: Function
  },
  deleteHandler: {
    type: Function
  }
})

const toast = useToast()
const order = reactive({
  column: '',
  order: ''
})
const loading = ref(false)
const search = ref('')
const current_page = ref(1)

const data = reactive({
  links: {},
  meta: {
    current_page: 1,
    from: 1,
    last_page: 1,
    path: '',
    per_page: 15,
    to: 4,
    total: 4
  },
  data: []
})

const listData = async () => {
  try {
    loading.value = true
    const orderParams = `${order.order}${order.column}`
    const list = await props.listHandler({
      order: orderParams,
      search: search.value,
      page: current_page.value
    })
    data.links = list.links
    data.meta = list.meta
    data.data = list.data
  } catch (error) {
    toast.error(t('generics.tables.errors.searching_for_information'))
  } finally {
    loading.value = false
  }
}

const orderHandler = (field) => {
  if (order.column === field) {
    order.order = order.order === '' ? '-' : ''
  } else {
    order.order = ''
  }

  order.column = field
  listData()
}

const searchHandler = (e) => {
  search.value = e.target.value
  listData()
}

const deleteHandler = async (id) => {
  try {
    const result = await Swal.fire({
      title: t('generics.tables.confirm.delete'),
      showDenyButton: true,
      confirmButtonText: t('generics.tables.confirm.confirmButton'),
      denyButtonText: t('generics.tables.confirm.denyButton'),
      confirmButtonColor: "#111827",
      cancelButtonColor: "#ffffff",
    })

    if (!result.isConfirmed) {
      return
    }

    await props.deleteHandler(id)
    toast.success(t('generics.messages.deleted_successfully'))
    listData()
  } catch (error) {
    Swal.fire({
      icon: "error",
      text: t('generics.tables.errors.could_not_delete_the_record'),
    });
  }
}

const changePage = (pageNumber) => {

  if (current_page.value === pageNumber) {
    return
  }
  current_page.value = pageNumber
  listData()
}

onMounted(listData)
</script>

<template>
    <div class="tableContainer">
        <!-- Table responsive wrapper -->
        <div class="overflow-x-auto bg-white dark:bg-neutral-700">
            <!-- Search input -->
            <div class="flex justify-end px-4 py-3 sm:px-6">
                <div class="relative">
                    <label for="inputSearch" class="sr-only">Buscar </label>
                    <input
                        id="inputSearch"
                        class="inputSearch"
                        type="text"
                        placeholder="Buscar..."
                        @keyup.enter="searchHandler"
                    />
                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 transform">
                        <font-awesome-icon :icon="['fas', 'magnifying-glass']" />
                    </span>
                </div>
            </div>

            <!-- Table -->
            <table class="min-w-full text-left text-sm whitespace-nowrap border-t-2">
                <!-- Table head -->
                <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600">
                <tr>
                    <th
                    v-for="column of props.columns"
                    :key="column.data"
                    scope="col"
                    class="px-6 py-3 cursor-default"
                    @click="orderHandler(column.data)"
                    >
                    {{ column.text }}
                    <font-awesome-icon
                        :icon="[
                        'fa',
                        order.column === column.data
                            ? order.order === '-'
                            ? 'sort-up'
                            : 'sort-down'
                            : 'sort'
                        ]"
                    />
                    </th>
                    <th scope="col" class="px-6 py-3 w-[140px]">{{ t('generics.tables.actions') }}</th>
                </tr>
                </thead>

                <!-- Table body -->
                <tbody>
                <template v-if="loading && !data.data.length">
                    <tr
                    class="border-b dark:border-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-600 animate-pulse "
                    >
                    <td
                        v-for="index in (props.columns.length + 1)"
                        :key="index"
                        class="px-6 py-3"
                    >
                        <div class="h-2 bg-slate-700 rounded"></div>
                    </td>
                    </tr>
                </template>
                <template v-else>
                    <tr
                    class="border-b dark:border-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-600"
                    v-for="item of data.data"
                    :key="item.id"
                    >
                    <slot :item="item" :deleteEvent="deleteHandler" />
                    </tr>

                    <tr
                    class="border-b dark:border-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-600"
                    v-if="data.data.length === 0"
                    >
                    <td
                        class="px-6 py-3 text-center"
                        :colspan="props.columns.length + 1"
                    >
                        {{ t('generics.tables.empty') }}
                    </td>
                    </tr>
                </template>
                </tbody>
            </table>

            <PaginationTable
                :from="data.meta.from"
                :to="data.meta.to"
                :total="data.meta.total"
                :current_page="current_page"
                :last_page="data.meta.last_page"
                @changePage="changePage"
            />
        </div>
    </div>
</template>

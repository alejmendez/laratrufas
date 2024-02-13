<script setup>
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import { useI18n } from 'vue-i18n'
import Swal from 'sweetalert2'

import PaginationTable from './PaginationTable.vue'
import SearchInput from './SearchInput.vue'

const { t } = useI18n()

const props = defineProps({
  columns: Array,
  data: Array,
  meta: Object,
  listHandler: {
    type: Function
  },
  deleteHandler: {
    type: Function
  }
})

const toast = useToast()

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
  } catch (error) {
    Swal.fire({
      icon: "error",
      text: t('generics.tables.errors.could_not_delete_the_record'),
    });
  }
}
</script>

<template>
    <div class="tableContainer">
        <!-- Table responsive wrapper -->
        <div class="overflow-x-auto bg-white">
            <SearchInput />

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
                            @click="orderHandler(column.data)"
                        >
                            {{ column.text }}
                            <font-awesome-icon :icon="['fa', 'sort']" />
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

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import { format } from 'date-fns';

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
  { text: t('machinery.table.name'), data: 'name' },
  { text: t('machinery.table.purchase_date'), data: 'purchase_date' },
  { text: t('machinery.table.last_maintenance'), data: 'last_maintenance' },
  { text: t('machinery.table.purchase_location'), data: 'purchase_location' },
  { text: t('machinery.table.contact'), data: 'contact' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('machineries.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('machinery.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('machinery.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'machineries.index', text: t('machinery.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'machineries.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="data"
            :search="search"
            :order="order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="machinery of data.data"
                :key="machinery.id"
            >
                <td>{{ machinery.name }}</td>
                <td>{{ format(stringToDate(machinery.purchase_date), 'dd/MM/yyyy') }}</td>
                <td>{{ format(stringToDate(machinery.last_maintenance), 'dd/MM/yyyy') }}</td>
                <td>{{ machinery.purchase_location }}</td>
                <td>{{ machinery.contact }}</td>
                <td>
                  <Link :href="route('machineries.show', machinery.id)">
                    <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
                  </Link>
                  <Link :href="route('machineries.edit', machinery.id)">
                    <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
                  </Link>
                  <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
                    @click="deleteHandler(machinery.id)" />
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

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';

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
  { text: t('equipment.table.name'), data: 'name' },
  { text: t('equipment.table.purchase_date'), data: 'purchase_date' },
  { text: t('equipment.table.last_maintenance'), data: 'last_maintenance' },
  { text: t('equipment.table.purchase_location'), data: 'purchase_location' },
  { text: t('equipment.table.contact'), data: 'contact' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('equipments.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('equipment.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('equipment.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'equipments.index', text: t('equipment.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'equipments.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="props.data.meta"
            :search="props.search"
            :order="props.order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="equipment of data.data"
                :key="equipment.id"
            >
                <td>{{ equipment.name }}</td>
                <td>{{ equipment.purchase_date }}</td>
                <td>{{ equipment.last_maintenance }}</td>
                <td>{{ equipment.purchase_location }}</td>
                <td>{{ equipment.contact }}</td>
                <td>
                  <Link :href="route('equipments.show', equipment.id)">
                    <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
                  </Link>
                  <Link :href="route('equipments.edit', equipment.id)">
                    <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
                  </Link>
                  <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
                    @click="deleteHandler(equipment.id)" />
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

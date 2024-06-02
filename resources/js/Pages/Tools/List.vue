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
  { text: t('tool.table.name'), data: 'name' },
  { text: t('tool.table.purchase_date'), data: 'purchase_date' },
  { text: t('tool.table.last_maintenance'), data: 'last_maintenance' },
  { text: t('tool.table.purchase_location'), data: 'purchase_location' },
  { text: t('tool.table.contact'), data: 'contact' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('tools.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('tool.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('tool.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'tools.index', text: t('tool.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'tools.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="props.data.meta"
            :search="props.search"
            :order="props.order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="tool of data.data"
                :key="tool.id"
            >
                <td>{{ tool.name }}</td>
                <td>{{ tool.purchase_date }}</td>
                <td>{{ tool.last_maintenance }}</td>
                <td>{{ tool.purchase_location }}</td>
                <td>{{ tool.contact }}</td>
                <td>
                  <Link :href="route('tools.show', tool.id)">
                    <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
                  </Link>
                  <Link :href="route('tools.edit', tool.id)">
                    <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
                  </Link>
                  <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
                    @click="deleteHandler(tool.id)" />
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

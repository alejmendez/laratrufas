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
  { text: t('quarter.table.name'), data: 'quarters.name' },
  { text: t('quarter.table.field_id'), data: 'fields.name' },
  { text: t('quarter.table.area'), data: 'area' },
  { text: t('quarter.table.plants_count'), data: 'plants_count' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('quarters.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('quarter.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('quarter.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'quarters.index', text: t('quarter.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'quarters.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="props.data"
            :search="props.search"
            :order="props.order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="quarter of props.data.data"
                :key="quarter.id"
            >
                <td>{{ quarter.name }}</td>
                <td>{{ quarter.field_name }}</td>
                <td>{{ quarter.area }} ha</td>
                <td>{{ quarter.plants_count }}</td>
                <td>
                    <Link :href="route('quarters.show', quarter.id)">
                        <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
                    </Link>
                    <Link :href="route('quarters.edit', quarter.id)">
                        <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
                    </Link>
                    <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
                        @click="deleteHandler(quarter.id)" />
                </td>
            </tr>
            <tr v-if="props.data.data.length === 0" class="border-b hover:bg-neutral-100">
              <td :colspan="columns.length + 1" class="text-center">
                {{ t('generics.tables.empty') }}
              </td>
            </tr>
        </TableList>
    </AuthenticatedLayout>
</template>

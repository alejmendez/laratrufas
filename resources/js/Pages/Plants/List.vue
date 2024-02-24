<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useToast } from 'vue-toastification'

import { deleteRowTable } from '@/Utils/table'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import TableList from '@/Components/Table/TableList.vue'

const { t } = useI18n()
const toast = useToast()

const props = defineProps({
    order: String,
    search: String,
    data: Object,
    toast: String,
})

if (props.toast) {
  toast.success(t('generics.messages.saved_successfully'))
}

const plants = props.data.data.map(p => {
  p.field_name = p.field.name
  p.quarter_name = p.quarter.name
  p.plant_type_name = p.plant_type.name
  p.responsible_name = p.responsible.name
  return p
})

const columns = [
  { text: t('plant.table.name'), data: 'name' },
  { text: t('plant.table.quarter_id'), data: 'quarter_id' },
  { text: t('plant.table.field_id'), data: 'field_id' },
  { text: t('plant.table.type'), data: 'plant_type_id' },
  { text: t('plant.table.age'), data: 'age' },
  { text: t('plant.table.manager'), data: 'manager' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('plants.destroy', id))
  })
}
</script>

<template>
    <Head :title="t('plant.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('plant.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'plants.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="props.data.meta"
            :search="props.search"
            :order="props.order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="plant of plants"
                :key="plant.id"
            >
                <td>{{ plant.name }}</td>
                <td>{{ plant.quarter_name }}</td>
                <td>{{ plant.field_name }}</td>
                <td>{{ plant.plant_type_name }}</td>
                <td>{{ plant.age }}</td>
                <td>{{ plant.responsible_name }}</td>
                <td>
                    <Link :href="route('plants.show', plant.id)">
                        <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all hover:text-gray-600" />
                    </Link>
                    <Link :href="route('plants.edit', plant.id)">
                        <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all hover:text-lime-600" />
                    </Link>
                    <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all hover:text-red-600"
                        @click="deleteHandler(plant.id)" />
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

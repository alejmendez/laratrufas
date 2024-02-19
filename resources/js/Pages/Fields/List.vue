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

const columns = [
  { text: t('field.table.name'), data: 'name' },
  { text: t('field.table.location'), data: 'location' },
  { text: t('field.table.size'), data: 'size' },
  { text: t('field.table.number_of_trees'), data: 'number_of_trees' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('fields.destroy', id))
  })
}
</script>

<template>
    <Head :title="t('field.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('field.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'fields.index', text: t('field.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'fields.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="props.data.meta"
            :search="props.search"
            :order="props.order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="field of data.data"
                :key="field.id"
            >
                <td>{{ field.name }}</td>
                <td>{{ field.location }}</td>
                <td>{{ field.size }}</td>
                <td>{{ field.number_of_trees }}</td>
                <td>
                    <Link :href="route('fields.show', field.id)">
                        <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all hover:text-gray-600" />
                    </Link>
                    <Link :href="route('fields.edit', field.id)">
                        <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all hover:text-lime-600" />
                    </Link>
                    <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all hover:text-red-600"
                        @click="deleteHandler(field.id)" />
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

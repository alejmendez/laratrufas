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
  { text: t('user.table.name'), data: 'name' },
  { text: t('user.table.dni'), data: 'dni' },
  { text: t('user.table.phone'), data: 'phone' },
  { text: t('user.table.role'), data: 'role' },
  { text: t('user.table.email'), data: 'email' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('users.destroy', id))
  })
}
</script>

<template>
    <Head :title="t('user.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('user.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'users.index', text: t('user.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'users.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="props.data.meta"
            :search="props.search"
            :order="props.order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="user of data.data"
                :key="user.id"
            >
                <td>{{ user.name }}</td>
                <td>{{ user.dni }}</td>
                <td>{{ user.phone }}</td>
                <td>
                    <span
                        class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none border rounded-full role"
                        :class="user.role.slug"
                    >
                        {{ user.role.name }}
                    </span>
                </td>
                <td>{{ user.email }}</td>
                <td>
                    <Link :href="route('users.show', user.id)">
                        <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all hover:text-gray-600" />
                    </Link>
                    <Link :href="route('users.edit', user.id)">
                        <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all hover:text-lime-600" />
                    </Link>
                    <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all hover:text-red-600"
                        @click="deleteHandler(user.id)" />
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

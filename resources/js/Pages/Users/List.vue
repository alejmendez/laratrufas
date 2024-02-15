<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import { deleteRowTable } from '@/Utils/table'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import TableList from '@/Components/Table/TableList.vue'

const { t } = useI18n()

const props = defineProps({
    order: String,
    search: String,
    data: Object,
})

const columns = [
    { text: 'Nombre', data: 'name' },
    { text: 'Rut', data: 'dni' },
    { text: 'Telefono', data: 'phone' },
    { text: 'Perfil', data: 'role' },
    { text: 'Email', data: 'email' },
];


const deleteHandler = async (id) => {
    await deleteRowTable(t, () => {
        route('users.destroy', id)
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
                <td class="px-6 py-3">{{ user.name }}</td>
                <td class="px-6 py-3">{{ user.dni }}</td>
                <td class="px-6 py-3">{{ user.phone }}</td>
                <td class="px-6 py-3">
                    <span
                        class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none border rounded-full role"
                        :class="user.role.slug"
                    >
                        {{ user.role.name }}
                    </span>
                </td>
                <td class="px-6 py-3">{{ user.email }}</td>
                <td class="px-6 py-3">
                    <Link :href="route('users.show', user.id)">
                        <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all hover:text-gray-600" />
                    </Link>
                    <Link :href="route('users.show', user.id)">
                        <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all hover:text-lime-600" />
                    </Link>
                    <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all hover:text-red-600"
                        @click="deleteHandler(user.id)" />
                </td>
            </tr>
        </TableList>
    </AuthenticatedLayout>
</template>

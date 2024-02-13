<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import TableList from '@/Components/Table/TableList.vue'


const props = defineProps({
  columns: Array,
  user: Array,
})
</script>

<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <HeaderCrud
            title="Usuarios"
            :breadcrumbs="[{ to: 'users.index', text: 'Usuarios' }, { text: 'Listado' }]"
            :links="[{ to: 'users.create', text: 'Ingresar' }]"
        />

        <TableList
            :columns="columns"
            :listHandler="UserService.getList"
            :deleteHandler="UserService.remove"
            v-slot="table"
        >
            <td class="px-6 py-3">{{ table.item.name }}</td>
            <td class="px-6 py-3">{{ table.item.dni }}</td>
            <td class="px-6 py-3">{{ table.item.phone }}</td>
            <td class="px-6 py-3">
            <span
                class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none border rounded-full"
                :class="roleColors[table.item.role.name]"
            >
                {{ table.item.role.name }}
            </span>
            </td>
            <td class="px-6 py-3">{{ table.item.email }}</td>
            <td class="px-6 py-3">
            <router-link :to="{ name: 'user.view', params: { id: table.item.id } }">
                <font-awesome-icon
                :icon="['fas', 'eye']"
                class="mr-4 cursor-pointer transition-all hover:text-gray-600"
                />
            </router-link>
            <router-link :to="{ name: 'user.edit', params: { id: table.item.id } }">
                <font-awesome-icon
                :icon="['fas', 'pencil']"
                class="mr-4 cursor-pointer transition-all hover:text-lime-600"
                />
            </router-link>
            <font-awesome-icon
                :icon="['fas', 'trash-can']"
                class="mr-4 cursor-pointer transition-all hover:text-red-600"
                @click="table.deleteEvent(table.item.id)"
            />
            </td>
        </TableList>
    </AuthenticatedLayout>
</template>

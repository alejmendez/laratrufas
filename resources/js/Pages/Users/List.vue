<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n'
import { useToast } from 'vue-toastification'
import { useI18n } from 'vue-i18n'
import Swal from 'sweetalert2'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import PaginationTable from '@/Components/Table/PaginationTable.vue'
import SearchInput from '@/Components/Table/SearchInput.vue'

const { t } = useI18n()
const toast = useToast()

const props = defineProps({
    order: String,
    search: String,
    data: Array,
})

const columns = [
    { text: 'Nombre', data: 'name' },
    { text: 'Rut', data: 'dni' },
    { text: 'Telefono', data: 'phone' },
    { text: 'Perfil', data: 'role' },
    { text: 'Email', data: 'email' },
];

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
    <Head :title="t('user.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            title="t('user.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'users.index', text: t('user.titles.entity_breadcrumb') }, { text: 'Listado' }]"
            :links="[{ to: 'users.create', text: 'Ingresar' }]"
        />

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
                                v-for="column of columns"
                                :key="column.data"
                                scope="col"
                                class="px-6 py-3 cursor-default"
                            >
                                <Link href="">
                                    {{ column.text }}
                                    <font-awesome-icon :icon="['fa', 'sort']" />
                                </Link>
                            </th>
                            <th scope="col" class="px-6 py-3 w-[140px]">{{ t('generics.tables.actions') }}</th>
                        </tr>
                    </thead>

                    <!-- Table body -->
                    <tbody>
                        <tr
                            class="border-b hover:bg-neutral-100"
                            v-for="user of data"
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
                                    @click="table.deleteEvent(user.id)" />
                            </td>
                        </tr>
                    </tbody>
                </table>

                <PaginationTable :meta="props.data.meta" />
            </div>
        </div>

    </AuthenticatedLayout>
</template>

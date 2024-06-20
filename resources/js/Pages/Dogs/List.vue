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
  { text: t('dog.table.name'), data: 'dogs.name' },
  { text: t('dog.table.quarter'), data: 'quarter_name' },
  { text: t('dog.table.gender'), data: 'gender' },
  { text: t('dog.table.breed'), data: 'breed' },
  { text: t('dog.table.age'), data: 'age' },
  { text: t('dog.table.veterinary'), data: 'veterinary' },
  { text: t('dog.table.couple'), data: 'couple_name' },
];

const genders = {
  M: t('dog.form.gender.options.male'),
  F: t('dog.form.gender.options.female'),
};

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('dogs.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('dog.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('dog.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'dogs.index', text: t('dog.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'dogs.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="data"
            :search="search"
            :order="order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="dog of data.data"
                :key="dog.id"
            >
                <td>{{ dog.name }}</td>
                <td>{{ dog.quarter_name }}</td>
                <td>{{ genders[dog.gender] }}</td>
                <td>{{ dog.breed }}</td>
                <td>{{ dog.age }}</td>
                <td>{{ dog.veterinary }}</td>
                <td>{{ dog.couple_name }}</td>
                <td>
                  <Link :href="route('dogs.show', dog.id)">
                    <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
                  </Link>
                  <Link :href="route('dogs.edit', dog.id)">
                    <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
                  </Link>
                  <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
                    @click="deleteHandler(dog.id)" />
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

<script setup>
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import { stringToFormat } from '@/Utils/date';

import { deleteRowTable } from '@/Utils/table';

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
  { text: t('task.table.name'), data: 'name' },
  { text: t('task.table.priority'), data: 'priority' },
  { text: t('task.table.note'), data: 'note' },
  { text: t('task.table.updated_at'), data: 'updated_at' },
  { text: t('task.table.responsible'), data: 'responsible_name' },
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('tasks.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('task.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('task.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'tasks.index', text: t('task.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'tasks.create', text: t('generics.new') }]"
        />

        <TableList
            :columns="columns"
            :meta="props.data"
            :search="props.search"
            :order="props.order"
        >
            <tr
                class="border-b hover:bg-neutral-100"
                v-for="task of data.data"
                :key="task.id"
            >
                <td>{{ task.name }}</td>
                <td>{{ $t('task.form.priority.options.' + task.priority) }}</td>
                <td>{{ task.note }}</td>
                <td>{{ stringToFormat(task.updated_at) }}</td>
                <td>{{ task.responsible_name }}</td>
                <td>
                  <Link :href="route('tasks.show', task.id)">
                    <font-awesome-icon :icon="['fas', 'eye']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-gray-600" />
                  </Link>
                  <Link :href="route('tasks.edit', task.id)">
                    <font-awesome-icon :icon="['fas', 'pencil']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-lime-600" />
                  </Link>
                  <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-4 cursor-pointer transition-all text-[#7B849C] hover:text-red-600"
                    @click="deleteHandler(task.id)" />
                </td>
            </tr>
            <tr v-if="data.data.length === 0" class="border-b hover:bg-neutral-100">
              <td :colspan="columns.length + 1" class="text-center">
                {{ $t('generics.tables.empty') }}
              </td>
            </tr>
        </TableList>
    </AuthenticatedLayout>
</template>

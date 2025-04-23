<script setup>
import { onMounted } from 'vue';
import { trans } from 'laravel-vue-i18n';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import HarvestTable from '@Fields/Pages/Harvests/Components/HarvestTable.vue';
import { can } from '@Auth/Services/Auth';

const toast = useToast();

const props = defineProps({
  toast: String,
});

const canCreate = can('harvests.create');

const headerLinks = [];
if (canCreate) {
  headerLinks.push({ to: 'harvests.create', text: trans('generics.new') });
}

onMounted(() => {
  if (props.toast) {
    toast.add({
      severity: 'success',
      summary: trans('harvest.titles.entity_breadcrumb'),
      detail: trans('generics.messages.saved_successfully'),
      life: 5000,
    });
  }
});
</script>

<template>
  <AuthenticatedLayout :title="__('harvest.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="__('harvest.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'harvests.index', text: __('harvest.titles.entity_breadcrumb') }, { text: __('generics.list') }]"
      :links="headerLinks"
    />

    <Toast />

    <HarvestTable />
  </AuthenticatedLayout>
</template>

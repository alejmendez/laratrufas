<script setup>
import { onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import HarvestTable from '@Fields/Pages/Harvests/Components/HarvestTable.vue';
import { can } from '@/Services/Auth';

const toast = useToast();

const { t } = useI18n();

const props = defineProps({
  toast: String,
});

const canCreate = can('harvests.create');

const headerLinks = [];
if (canCreate) {
  headerLinks.push({ to: 'harvests.create', text: t('generics.new') });
}

onMounted(() => {
  if (props.toast) {
    toast.add({
      severity: 'success',
      summary: t('harvest.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }
});
</script>

<template>
  <AuthenticatedLayout :title="$t('harvest.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('harvest.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'harvests.index', text: $t('harvest.titles.entity_breadcrumb') }, { text: $t('generics.list') }]"
      :links="headerLinks"
    />

    <Toast />

    <HarvestTable />
  </AuthenticatedLayout>
</template>

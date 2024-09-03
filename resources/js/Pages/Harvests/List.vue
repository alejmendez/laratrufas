<script setup>
import { onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

import HarvestTable from '@/Pages/Harvests/Components/HarvestTable.vue';

const toast = useToast();

const { t } = useI18n();

const props = defineProps({
  toast: String,
});

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
  <Head :title="t('harvest.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('harvest.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
      :links="[{ to: 'harvests.create', text: t('generics.new') }]"
    />

    <Toast />

    <HarvestTable />
  </AuthenticatedLayout>
</template>

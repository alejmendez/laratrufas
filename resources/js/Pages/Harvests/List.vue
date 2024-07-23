<script setup>
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';

import HarvestTable from '@/Pages/Harvests/Components/HarvestTable.vue';

const toast = useToast();

const { t } = useI18n();

const props = defineProps({
  order: String,
  search: String,
  filter_year: String,
  filter_year_options: Array,
  filter_field: String,
  filter_field_options: Array,
  filter_quarter: String,
  filter_quarter_options: Array,
  data: Object,
  toast: String,
});

if (props.toast) {
  toast.success(t('generics.messages.saved_successfully'));
}
</script>

<template>
  <Head :title="t('harvest.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('harvest.titles.entity_breadcrumb')"
      :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
      :links="[{ to: 'harvests.create', text: t('generics.new') }]"
    />

    <HarvestTable
      :show_filters="true"
      :order="props.order"
      :search="props.search"
      :filter_year="props.filter_year"
      :filter_year_options="props.filter_year_options"
      :filter_field="props.filter_field"
      :filter_field_options="props.filter_field_options"
      :filter_quarter="props.filter_quarter"
      :filter_quarter_options="props.filter_quarter_options"
      :data="props.data"
    />
  </AuthenticatedLayout>
</template>

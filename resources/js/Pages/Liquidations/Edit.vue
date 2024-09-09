<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormLiquidation from '@/Pages/Liquidations/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';
import { stringToDate } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  importers: Array,
  category_products: Array,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  date: stringToDate(data.date),
  delivery_date: stringToDate(data.delivery_date),
  reception_date: stringToDate(data.reception_date),
  importer_id: data.importer_id,
  weight_with_earth: data.weight_with_earth,
  weight_washed: data.weight_washed,
  dollar_value: data.dollar_value,
  products: data.products,
});

const submitHandler = generateSubmitHandler(form, route('liquidations.update', data.id));
</script>

<template>
    <Head :title="t('liquidation.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('liquidation.titles.edit')"
        :breadcrumbs="[{ to: 'liquidations.index', text: t('liquidation.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('liquidations.index') }"
      />
      <FormLiquidation
        :form="form"
        :importers="importers"
        :category_products="category_products"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

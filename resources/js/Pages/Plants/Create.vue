<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormPlant from '@/Pages/Plants/Form.vue';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  quarters: Array,
  types: Array,
});

const form = useForm({
  name: null,
  plant_type_id: '',
  age: 0,
  planned_at: null,
  nursery_origin: null,
  code: null,
  field_id: '',
  quarter_id: '',
  row: '',
});

const submitHandler = () => {
  form
    .transform((data) => ({
      ...data,
      planned_at: format(data.planned_at, 'yyyy-MM-dd'),
    }))
    .post(route('plants.store'), {
      forceFormData: true,
    });
};
</script>

<template>
  <Head :title="t('plant.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('plant.titles.create')"
      :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('plants.index') }"
    />
    <FormPlant
      :form="form"
      :fields="props.fields"
      :quarters="props.quarters"
      :types="props.types"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

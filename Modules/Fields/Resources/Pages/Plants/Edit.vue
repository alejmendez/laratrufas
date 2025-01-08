<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormPlant from '@Fields/Pages/Plants/Form.vue';
import { stringToDate } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  fields: Array,
  quarters: Array,
  types: Array,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  plant_type_id: props.types.find((a) => a.value == data.plant_type.id),
  age: data.age,
  planned_at: stringToDate(data.planned_at),
  nursery_origin: data.nursery_origin,
  code: data.code,
  field_id: props.fields.find((a) => a.value == data.field.id),
  quarter_id: props.quarters.find((a) => a.value == data.quarter.id),
  row: data.row,
});

const submitHandler = () => form.post(route('plants.update', data.id));
</script>

<template>
  <Head :title="t('plant.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('plant.titles.edit')"
      :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
      :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('plants.index') }"
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

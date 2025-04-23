<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FormBatch from '@Fields/Pages/Batches/Form.vue';

import { stringToDate } from '@Core/Utils/date';

const props = defineProps({
  data: Object,
  importers: Array,
  harvests: Array,
});

const { data } = props.data;

const harvest_options = props.harvests
  .map((h) => {
    return {
      value: h.id,
      text: `Semana ${h.week} Batch ${h.batch}`,
    };
  })
  .sort((a, b) => a.text - b.text);

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  batch_number: data.batch_number,
  delivery_date: stringToDate(data.delivery_date),
  importer_id: data.importer_id,
  harvests: harvest_options.filter((a) => data.harvests.includes(a.value)),
});

const submitHandler = () => form.post(route('batches.update', data.id));
</script>

<template>
  <AuthenticatedLayout :title="__('batch.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="__('batch.titles.edit')"
      :breadcrumbs="[{ to: 'batches.index', text: __('batch.titles.entity_breadcrumb') }, { text: __('generics.actions.edit') }]"
      :form="{ instance: form, submitHandler, submitText: __('generics.buttons.save_edit'), hrefCancel: route('batches.index') }"
    />
    <FormBatch
      :form="form"
      :importers="importers"
      :harvests="harvests"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

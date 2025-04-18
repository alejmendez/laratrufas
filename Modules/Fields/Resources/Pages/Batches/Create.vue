<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FormBatch from '@Fields/Pages/Batches/Form.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';

const props = defineProps({
  importers: Array,
  harvests: Array,
});

const form = useForm({
  batch_number: null,
  delivery_date: null,
  importer_id: [],
  harvests: [],
});

const submitHandler = () => form.post(route('batches.store'));
</script>

<template>
  <AuthenticatedLayout :title="$t('batch.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('batch.titles.create')"
      :breadcrumbs="[{ to: 'batches.index', text: $t('batch.titles.entity_breadcrumb') }, { text: $t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.create'), hrefCancel: route('batches.index') }"
    />
    <FormBatch
      :form="form"
      :importers="importers"
      :harvests="harvests"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

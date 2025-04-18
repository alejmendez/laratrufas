<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormTool from '@Fields/Pages/Tools/Form.vue';

const form = useForm({
  name: null,
  purchase_date: null,
  last_maintenance: null,
  purchase_location: null,
  type: null,
  contact: null,
  note: null,
});

const submitHandler = () => form.post(route('tools.store'));
</script>

<template>
  <AuthenticatedLayout :title="$t('tool.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('tool.titles.create')"
      :breadcrumbs="[{ to: 'tools.index', text: $t('tool.titles.entity_breadcrumb') }, { text: $t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.create'), hrefCancel: route('tools.index') }"
    />
    <FormTool
      :form="form"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FormField from '@Fields/Pages/Fields/Form.vue';

const form = useForm({
  name: null,
  location: null,
  size: null,
  owner_dni: null,
  owner_name: null,
  blueprint: null,
  documents: [],
  documentsRemove: [],
});

const submitHandler = () => form.post(route('fields.store'), form.blueprint || form.documents ? { forceFormData: true } : {});
</script>

<template>
  <AuthenticatedLayout :title="$t('field.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('field.titles.create')"
      :breadcrumbs="[{ to: 'fields.index', text: $t('field.titles.entity_breadcrumb') }, { text: $t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.create'), hrefCancel: route('fields.index') }"
    />
    <FormField
      :form="form"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

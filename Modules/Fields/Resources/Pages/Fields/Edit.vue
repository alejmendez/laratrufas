<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormField from '@Fields/Pages/Fields/Form.vue';

const { t } = useI18n();

const props = defineProps({
  data: Object,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  location: data.location,
  size: data.size,
  plants_count: data.plants_count,
  owner_dni: data.owner.dni,
  owner_name: data.owner.name,
  documents: data.documents,
  documentsRemove: [],
  blueprint: data.blueprint,
  blueprintRemove: false,
});

const submitHandler = () => form.post(route('fields.update', data.id), form.blueprint || form.documents ? { forceFormData: true } : {});
</script>

<template>
  <Head :title="t('field.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('field.titles.edit')"
      :breadcrumbs="[{ to: 'fields.index', text: t('field.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
      :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('fields.index') }"
    />
    <FormField
      :form="form"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

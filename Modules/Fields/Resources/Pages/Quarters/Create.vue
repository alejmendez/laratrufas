<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormQuarter from '@/Pages/Quarters/Form.vue';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  responsibles: Array,
});

const form = useForm({
  name: null,
  location: null,
  area: null,
  plants_count: 0,
  field_id: null,
  responsible_id: null,
  blueprint: null,
});

const submitHandler = () => form.post(route('quarters.store'), form.blueprint ? { forceFormData: true } : {});
</script>

<template>
  <Head :title="t('quarter.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('quarter.titles.create')"
      :breadcrumbs="[{ to: 'quarters.index', text: t('quarter.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('quarters.index') }"
    />
    <FormQuarter
      :form="form"
      :fields="props.fields"
      :responsibles="props.responsibles"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

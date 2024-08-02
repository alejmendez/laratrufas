<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormField from '@/Pages/Fields/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const form = useForm({
  name: null,
  location: null,
  size: null,
  owner_dni: null,
  owner_name: null,
  blueprint: null,
});

const submitHandler = generateSubmitHandler(form, route('fields.store'));
</script>

<template>
    <Head :title="t('field.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('field.titles.create')"
        :breadcrumbs="[{ to: 'fields.index', text: t('field.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('fields.index') }"
      />
      <FormField
        :form="form"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

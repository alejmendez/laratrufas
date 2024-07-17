<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import FormTool from '@/Pages/Tools/Form.vue';

const { t } = useI18n();

const form = useForm({
  name: null,
  purchase_date: null,
  last_maintenance: null,
  purchase_location: null,
  type: null,
  contact: null,
});

const submitHandler = () => {
  form
    .transform((data) => {
      return {
        ...data,
        purchase_date: format(data.purchase_date, 'yyyy-MM-dd'),
        last_maintenance: format(data.last_maintenance, 'yyyy-MM-dd'),
      };
    })
    .post(route('tools.store'), {
      forceFormData: true,
    });
};
</script>

<template>
    <Head :title="t('tool.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('tool.titles.create')"
        :breadcrumbs="[{ to: 'tools.index', text: t('tool.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('tools.index') }"
      />
      <FormTool
        :form="form"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

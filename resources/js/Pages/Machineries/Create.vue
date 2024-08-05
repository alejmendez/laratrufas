<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import FormMachineries from '@/Pages/Machineries/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const form = useForm({
  name: null,
  purchase_date: null,
  last_maintenance: null,
  purchase_location: null,
  type: null,
  contact: null,
  note: null,
});

const submitHandler = generateSubmitHandler(form, route('machineries.store'));
</script>

<template>
    <Head :title="t('machinery.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('machinery.titles.create')"
        :breadcrumbs="[{ to: 'machineries.index', text: t('machinery.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('machineries.index') }"
      />
      <FormMachineries
        :form="form"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

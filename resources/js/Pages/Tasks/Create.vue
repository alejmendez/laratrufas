<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormTask from '@/Pages/Tasks/Form.vue';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  responsibles: Array,
});

const form = useForm({
  name: null,
  status: null,
  priority: null,
  start_date: null,
  end_date: null,
  field_id: null,
  quarter_id: null,
  plant_id: null,
  responsible_id: null,
  note: null,
  comments: null,
  tools: [],
  equipments: [],
  supplies: [{
    name: null,
    brand: null,
    quantity: null,
    unit: null,
  }],
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
    .post(route('tasks.store'), {
      forceFormData: true,
    });
};
</script>

<template>
    <Head :title="t('task.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('task.titles.create')"
        :breadcrumbs="[{ to: 'tasks.index', text: t('task.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('tasks.index') }"
      />
      <FormTask
        :form="form"
        :fields="props.fields"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

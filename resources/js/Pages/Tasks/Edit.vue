<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormTask from '@/Pages/Tasks/Form.vue';

import { stringToDate } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  fields: Array,
  responsibles: Array,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  status: data.status,
  priority: data.priority,
  start_date: stringToDate(data.start_date),
  end_date: stringToDate(data.end_date),
  field_id: data.field_id,
  quarter_id: data.quarter_id,
  plant_id: data.plant_id,
  responsible_id: data.responsible_id,
  note: data.note,
  comments: data.comments,
  tools: data.tools,
  machineries: data.machineries,
  supplies: data.machineries,
});

const submitHandler = () => {
  form
    .transform((data) => {
      return {
        ...data,
        start_date: format(data.purchase_date, 'yyyy-MM-dd'),
        end_date: format(data.last_maintenance, 'yyyy-MM-dd'),
      };
    })
    .post(route('tasks.update', data.id), {
      forceFormData: true,
    });
};
</script>

<template>
    <Head :title="t('task.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('task.titles.edit')"
        :breadcrumbs="[{ to: 'tasks.index', text: t('task.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('tasks.index') }"
      />
      <FormTask
        :form="form"
        :fields="props.fields"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

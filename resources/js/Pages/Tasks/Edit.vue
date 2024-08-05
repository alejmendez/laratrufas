<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import FormTask from '@/Pages/Tasks/Form.vue';

import { stringToDate } from '@/Utils/date';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  fields: Array,
  responsibles: Array,
  quarters: Array,
  plants: Array,
  tools: Array,
  machineries: Array,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  repeat_number: data.repeat_number,
  repeat_type: data.repeat_type,
  status: data.status,
  priority: data.priority,
  start_date: stringToDate(data.start_date),
  end_date: stringToDate(data.end_date),
  field_id: props.fields.find((a) => a.value == data.field_id),
  quarter_id: props.quarters.find((a) => a.value == data.quarter_id),
  plant_id: props.plants.find((a) => a.value == data.plant_id),
  responsible_id: props.responsibles.find((a) => a.value == data.responsible_id),
  note: data.note,
  comments: data.comments,
  tools: data.tools.map((t) => ({ value: t.id, text: t.name })),
  machineries: data.machineries.map((m) => ({ value: m.id, text: m.name })),
  supplies: data.supplies,
});

const submitHandler = generateSubmitHandler(form, route('tasks.update', data.id));
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
        :responsibles="props.responsibles"
        :tools="props.tools"
        :machineries="props.machineries"
        :quarters="props.quarters"
        :plants="props.plants"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

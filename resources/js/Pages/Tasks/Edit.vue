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
  security_equipments: Array,
  machineries: Array,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  repeat_number: data.repeat_number,
  repeat_type: { value: data.repeat_type, text: t('task.form.repeat_type.options.' + data.repeat_type) },
  status: { value: data.status, text: t('task.form.status.options.' + data.status) },
  priority: { value: data.priority, text: t('task.form.priority.options.' + data.priority) },
  start_date: stringToDate(data.start_date),
  end_date: stringToDate(data.end_date),
  field_id: data.field,
  quarter_id: props.quarters.filter((a) => data.quarters.includes(a.value)),
  rows: data.rows.map((a) => ({ value: a, text: a })),
  plant_id: props.plants.filter((a) => data.plants.includes(a.value)),
  responsible_id: props.responsibles.find((a) => a.value == data.responsible_id),
  note: data.note,
  comments: data.comments,
  tools: data.tools,
  security_equipments: data.security_equipments,
  machineries: data.machineries,
  supplies: data.supplies.map((a) => {
    a.unit = { value: a.unit, text: t('task.form.supplies.unit.options.' + a.unit) };
    return a;
  }),
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
        :quarters="props.quarters"
        :plants="props.plants"
        :responsibles="props.responsibles"
        :tools="props.tools"
        :security_equipments="props.security_equipments"
        :machineries="props.machineries"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

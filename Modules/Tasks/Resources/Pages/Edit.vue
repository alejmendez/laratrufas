<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormTask from '@Tasks/Components/Form.vue';

import { stringToDate } from '@/Utils/date';

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

let supplies = data.supplies.map((a) => {
  a.unit = { value: a.unit, text: t('task.form.supplies.unit.options.' + a.unit) };
  return a;
});

if (supplies.length === 0) {
  supplies = [
    {
      name: null,
      brand: null,
      quantity: null,
      unit: '',
    },
  ];
}

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  repeat_number: data.repeat_number,
  repeat_type: { value: data.repeat_type, text: t(`task.form.repeat_type.options.${data.repeat_type || 'daily'}`) },
  status: { value: data.status, text: t(`task.form.status.options.${data.status || 'to_begin'}`) },
  priority: { value: data.priority, text: t(`task.form.priority.options.${data.priority || 'when_possible'}`) },
  start_date: stringToDate(data.start_date),
  end_date: stringToDate(data.end_date),
  field_id: data.field,
  quarter_id: props.quarters.filter((a) => data.quarters.includes(a.value)),
  rows: data.rows.map((a) => ({ value: a, text: a })),
  plant_id: props.plants.filter((a) => data.plants.includes(a.value)),
  responsible_id: props.responsibles.find((a) => a.value == data.responsible_id),
  note: data.note,
  comment: data.comments[0]?.comment || null,
  comments: data.comments,
  tools: data.tools,
  security_equipments: data.security_equipments,
  machineries: data.machineries,
  supplies,
});

const submitHandler = () => form.post(route('tasks.update', data.id));
</script>

<template>
  <AuthenticatedLayout :title="$t('task.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('task.titles.edit')"
      :breadcrumbs="[{ to: 'tasks.index', text: $t('task.titles.entity_breadcrumb') }, { text: $t('generics.actions.edit') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.save_edit'), hrefCancel: route('tasks.index') }"
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

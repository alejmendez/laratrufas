<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormTask from '@Tasks/Components/Form.vue';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  responsibles: Array,
  tools: Array,
  security_equipments: Array,
  machineries: Array,
});

const form = useForm({
  id: null,
  name: null,
  repeat_number: '1',
  repeat_type: { value: 'daily', text: t('task.form.repeat_type.options.daily') },
  status: { value: 'to_begin', text: t('task.form.status.options.to_begin') },
  priority: { value: 'when_possible', text: t('task.form.priority.options.when_possible') },
  start_date: null,
  end_date: null,
  field_id: [],
  quarter_id: [],
  plant_id: [],
  rows: [],
  responsible_id: [],
  note: null,
  comment: null,
  comments: [
    {
      id: null,
      comment: null,
      user_id: null,
      user_name: null,
      user_avatar: null,
      created_at: null,
    },
  ],
  tools: [],
  security_equipments: [],
  machineries: [],
  supplies: [
    {
      name: null,
      brand: null,
      quantity: null,
      unit: '',
    },
  ],
});

const submitHandler = () => form.post(route('tasks.store'));
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
      :responsibles="props.responsibles"
      :tools="props.tools"
      :security_equipments="props.security_equipments"
      :machineries="props.machineries"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

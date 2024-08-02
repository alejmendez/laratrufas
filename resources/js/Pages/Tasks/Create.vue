<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import FormTask from '@/Pages/Tasks/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  responsibles: Array,
  tools: Array,
  machineries: Array,
});

const form = useForm({
  name: null,
  repeat_number: '1',
  repeat_type: 'diary',
  status: 'to_begin',
  priority: '',
  start_date: null,
  end_date: null,
  field_id: '',
  quarter_id: '',
  plant_id: '',
  responsible_id: '',
  note: null,
  comments: null,
  tools: [],
  machineries: [],
  supplies: [{
    name: null,
    brand: null,
    quantity: null,
    unit: '',
  }],
});

const submitHandler = generateSubmitHandler(form, route('tasks.store'));
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
        :machineries="props.machineries"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

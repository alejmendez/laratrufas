<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FormMachineries from '@Fields/Pages/Machineries/Form.vue';

import { stringToDate } from '@Core/Utils/date';

const props = defineProps({
  data: Object,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  purchase_date: stringToDate(data.purchase_date),
  last_maintenance: stringToDate(data.last_maintenance),
  purchase_location: data.purchase_location,
  type: data.type,
  contact: data.contact,
  note: data.note,
});

const submitHandler = () => form.post(route('machineries.update', data.id));
</script>

<template>
  <AuthenticatedLayout :title="$t('machinery.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('machinery.titles.edit')"
      :breadcrumbs="[{ to: 'machineries.index', text: $t('machinery.titles.entity_breadcrumb') }, { text: $t('generics.actions.edit') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.save_edit'), hrefCancel: route('machineries.index') }"
    />
    <FormMachineries
      :form="form"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

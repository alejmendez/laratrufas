<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormTool from '@/Pages/Tools/Form.vue';

import { stringToDate } from '@/Utils/date';

const { t } = useI18n();

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
    .post(route('equipments.update', data.id), {
      forceFormData: true,
    });
};
</script>

<template>
    <Head :title="t('equipment.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('equipment.titles.edit')"
        :breadcrumbs="[{ to: 'equipments.index', text: t('equipment.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('equipments.index') }"
      />
      <FormTool
        :form="form"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormQuarter from '@/Pages/Quarters/Form.vue';
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
  location: data.location,
  area: data.area,
  planned_at: stringToDate(data.planned_at),
  number_of_trees: data.number_of_trees,
  field_id: data.field.id.toString(),
  responsible_id: data.responsible.id.toString(),
  blueprint: null,
  blueprintRemove: false,
});

const submitHandler = () => {
  form
    .transform((data) => ({
      ...data,
      planned_at: format(data.planned_at, 'yyyy-MM-dd'),
    }))
    .post(route('quarters.update', data.id), {
      forceFormData: true,
    });
};
</script>

<template>
    <Head :title="t('quarter.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('quarter.titles.edit')"
        :breadcrumbs="[{ to: 'quarters.index', text: t('quarter.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('quarters.index') }"
      />
      <FormQuarter
        :form="form"
        :fields="props.fields"
        :responsibles="props.responsibles"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

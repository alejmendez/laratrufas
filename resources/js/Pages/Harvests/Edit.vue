<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormHarvest from '@/Pages/Harvests/Form.vue';

import { stringToDate } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  quarters: Array,
  dogs: Array,
  users: Array,
  plant_codes: Array,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  date: stringToDate(data.date),
  batch: data.batch,
  quarter_ids: data.quarters.map(q => ({ value: q.id, text: q.name})),
  dog_id: data.dog.id + '',
  farmer_id: data.farmer.id + '',
  assistant_id: data.assistant.id + '',
  details: data.details || [{
    plant_code: null,
    quality: null,
    weight: null,
  }],
});

const submitHandler = () => {
  form
    .transform((data) => ({
      ...data,
      date: format(data.date, 'yyyy-MM-dd'),
      quarter_ids: data.quarter_ids.map(q => q.value),
    }))
    .post(route('harvests.update', data.id));
};
</script>

<template>
    <Head :title="t('harvest.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('harvest.titles.edit')"
        :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('harvests.index') }"
      />
      <FormHarvest
        :form="form"
        :quarters="props.quarters"
        :dogs="props.dogs"
        :users="props.users"
        :plant_codes="props.plant_codes"
        :details="true"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

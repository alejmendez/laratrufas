<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';

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
  date: data.date,
  batch: data.batch,
  comments: data.comments,
  quarter_ids: data.quarter_ids,
  dog_id: data.dog_id,
  farmer_id: data.farmer_id,
  assistant_id: data.assistant_id,
  details: data.details,
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
        :details="false"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

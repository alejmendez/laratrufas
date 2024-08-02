<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import FormDog from '@/Pages/Dogs/Form.vue';

import { stringToDate, getAge } from '@/Utils/date';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  fields: Array,
  quarters: Array,
  couples: Array,
});

const { data } = props.data;

const vaccines = data.vaccines.map((v) => {
  v.date = stringToDate(v.date);
  return v;
});

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  breed: data.breed,
  gender: data.gender,
  birthdate: stringToDate(data.birthdate),
  age: getAge(data.birthdate),
  veterinary: data.veterinary,
  couple_id: props.couples.find(a => a.value == data.couple.id),
  avatar: data.avatar,
  avatarRemove: false,
  field_id: props.fields.find(a => a.value == data.field.id),
  quarter_id: props.quarters.find(a => a.value == data.quarter.id),
  vaccines,
});

const submitHandler = generateSubmitHandler(form, route('dogs.update', data.id), (data) => {
  return {
    ...data,
    vaccines: data.vaccines.map((v) => ({
      name: v.name,
      date: format(v.date, 'yyyy-MM-dd'),
      code: v.code,
    })),
  };
});
</script>

<template>
    <Head :title="t('dog.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('dog.titles.edit')"
        :breadcrumbs="[{ to: 'dogs.index', text: t('dog.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('dogs.index') }"
      />
      <FormDog
        :form="form"
        :fields="props.fields"
        :quarters="props.quarters"
        :couples="props.couples"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

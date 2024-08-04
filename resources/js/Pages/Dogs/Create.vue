<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import FormDog from '@/Pages/Dogs/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  quarters: Array,
  couples: Array,
});

const form = useForm({
  name: null,
  breed: null,
  gender: '',
  birthdate: null,
  veterinary: null,
  couple_id: '',
  avatar: null,
  age: null,
  field_id: '',
  quarter_id: '',
  vaccines: [
    {
      name: null,
      date: null,
      code: null,
    },
  ],
});

const submitHandler = generateSubmitHandler(form, route('dogs.store'), (data) => {
  return {
    ...data,
    vaccines: data.vaccines.filter((v) => v.name || v.date || v.code).map((v) => ({
      name: v.name,
      date: v.date,
      code: v.code,
    })),
  };
});
</script>

<template>
    <Head :title="t('dog.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('dog.titles.create')"
        :breadcrumbs="[{ to: 'dogs.index', text: t('dog.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('dogs.index') }"
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

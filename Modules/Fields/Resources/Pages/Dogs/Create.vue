<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormDog from '@/Pages/Dogs/Form.vue';

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

const submitHandler = () => form.post(route('dogs.store'), form.avatar ? { forceFormData: true } : {});
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

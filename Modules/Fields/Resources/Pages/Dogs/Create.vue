<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FormDog from '@Fields/Pages/Dogs/Form.vue';

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
  <AuthenticatedLayout :title="$t('dog.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('dog.titles.create')"
      :breadcrumbs="[{ to: 'dogs.index', text: $t('dog.titles.entity_breadcrumb') }, { text: $t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.create'), hrefCancel: route('dogs.index') }"
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

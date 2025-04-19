<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FormPlant from '@Fields/Pages/Plants/Form.vue';

const props = defineProps({
  fields: Array,
  quarters: Array,
  types: Array,
});

const form = useForm({
  name: null,
  plant_type_id: '',
  age: 0,
  planned_at: null,
  nursery_origin: null,
  code: null,
  field_id: '',
  quarter_id: '',
  row: '',
});

const submitHandler = () => form.post(route('plants.store'));
</script>

<template>
  <AuthenticatedLayout :title="$t('plant.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('plant.titles.create')"
      :breadcrumbs="[{ to: 'plants.index', text: $t('plant.titles.entity_breadcrumb') }, { text: $t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.create'), hrefCancel: route('plants.index') }"
    />
    <FormPlant
      :form="form"
      :fields="props.fields"
      :quarters="props.quarters"
      :types="props.types"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

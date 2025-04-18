<script setup>
import { useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormSecurityEquipment from '@Fields/Pages/SecurityEquipments/Form.vue';

const form = useForm({
  name: null,
  purchase_date: null,
  last_maintenance: null,
  purchase_location: null,
  type: null,
  contact: null,
  note: null,
});

const submitHandler = () => form.post(route('security_equipments.store'));
</script>

<template>
  <AuthenticatedLayout :title="$t('security_equipment.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="$t('security_equipment.titles.create')"
      :breadcrumbs="[{ to: 'security_equipments.index', text: $t('security_equipment.titles.entity_breadcrumb') }, { text: $t('generics.actions.create') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.create'), hrefCancel: route('security_equipments.index') }"
    />
    <FormSecurityEquipment
      :form="form"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

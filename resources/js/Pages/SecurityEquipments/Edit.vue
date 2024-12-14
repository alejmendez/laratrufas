<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormSecurityEquipment from '@/Pages/SecurityEquipments/Form.vue';

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
  note: data.note,
});

const submitHandler = () => form.post(route('security_equipments.update', data.id));
</script>

<template>
  <Head :title="t('security_equipment.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('security_equipment.titles.edit')"
      :breadcrumbs="[{ to: 'security_equipments.index', text: t('security_equipment.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
      :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('security_equipments.index') }"
    />
    <FormSecurityEquipment
      :form="form"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

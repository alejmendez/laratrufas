<script setup>
import { onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useToast } from 'primevue/usetoast';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FormUser from '@Users/Components/Form.vue';

const { t } = useI18n();
const toast = useToast();

const props = defineProps({
  data: Object,
  roles: Array,
  toast: String,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  dni: data.dni,
  name: data.name,
  last_name: data.last_name,
  email: data.email,
  phone: data.phone,
  password: data.password,
  role: data.role.name,
  avatar: data.avatar,
  avatarRemove: false,
});

const submitHandler = () => form.post(route('profile.store'), form.avatar ? { forceFormData: true } : {});

onMounted(async () => {
  if (props.toast) {
    toast.add({
      severity: 'success',
      summary: t('profile.titles.entity_breadcrumb'),
      detail: t('generics.messages.saved_successfully'),
      life: 5000,
    });
  }
});
</script>

<template>
  <AuthenticatedLayout :title="t('profile.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="t('profile.titles.edit')"
      :breadcrumbs="[{ text: t('profile.titles.entity_breadcrumb') }]"
      :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('dashboard') }"
    />
    <FormUser
      :form="form"
      :roles="props.roles"
      :submitHandler="submitHandler"
      :showRole="false"
    />
  </AuthenticatedLayout>
</template>

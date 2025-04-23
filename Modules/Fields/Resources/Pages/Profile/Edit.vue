<script setup>
import { onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { useToast } from 'primevue/usetoast';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import FormUser from '@Users/Components/Form.vue';

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
      summary: trans('profile.titles.entity_breadcrumb'),
      detail: trans('generics.messages.saved_successfully'),
      life: 5000,
    });
  }
});
</script>

<template>
  <AuthenticatedLayout :title="__('profile.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="__('profile.titles.edit')"
      :breadcrumbs="[{ text: __('profile.titles.entity_breadcrumb') }]"
      :form="{ instance: form, submitHandler, submitText: __('generics.buttons.save_edit'), hrefCancel: route('dashboard') }"
    />
    <FormUser
      :form="form"
      :roles="props.roles"
      :submitHandler="submitHandler"
      :showRole="false"
    />
  </AuthenticatedLayout>
</template>

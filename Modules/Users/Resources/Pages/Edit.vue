<script setup>
import { useForm } from '@inertiajs/vue3';

import FormUser from '@Users/Components/Form.vue';

const props = defineProps({
  data: Object,
  roles: Array,
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
  role: props.roles.find((a) => a.value == data.role.name),
  avatar: data.avatar,
  avatarRemove: false,
});

const submitHandler = () => form.post(route('users.update', data.id), form.avatar ? { forceFormData: true } : {});
</script>

<template>
  <Head :title="$t('user.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="$t('user.titles.edit')"
      :breadcrumbs="[{ to: 'users.index', text: $t('user.titles.entity_breadcrumb') }, { text: $t('generics.actions.edit') }]"
      :form="{ instance: form, submitHandler, submitText: $t('generics.buttons.save_edit'), hrefCancel: route('users.index') }"
    />
    <FormUser
      :form="form"
      :roles="props.roles"
      :submitHandler="submitHandler"
    />
  </AuthenticatedLayout>
</template>

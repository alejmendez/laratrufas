<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';

import FormUser from '@/Pages/Users/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();
const toast = useToast();

const props = defineProps({
  data: Object,
  roles: Array,
  toast: String,
});

if (props.toast) {
  toast.success(t('generics.messages.saved_successfully'));
}

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

const submitHandler = generateSubmitHandler(form, route('profile.update', data.id));
</script>

<template>
    <Head :title="t('profile.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
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

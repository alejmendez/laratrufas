<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormUser from '@/Pages/Users/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const props = defineProps({
  roles: Array,
});

const form = useForm({
  dni: null,
  name: null,
  last_name: null,
  email: null,
  phone: null,
  password: null,
  role: '',
  avatar: null,
});

const submitHandler = generateSubmitHandler(form, route('users.store'));
</script>

<template>
    <Head :title="t('user.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('user.titles.create')"
        :breadcrumbs="[{ to: 'users.index', text: t('user.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('users.index') }"
      />
      <FormUser
        :form="form"
        :roles="props.roles"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormHarvestDetails from '@/Pages/HarvestDetails/Form.vue';

const { t } = useI18n();

const props = defineProps({
  harvests: Array,
});

const form = useForm({
  plant_code: null,
  quality: null,
  weight: null,
});

const submitHandler = () => {
  form.post(route('harvests.details.store'));
};
</script>

<template>
    <Head :title="t('harvest.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('harvest.titles.create')"
        :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('harvests.index') }"
      />
      <FormHarvestDetails
        :form="form"
        :harvests="props.harvests"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormBatch from '@/Pages/Batches/Form.vue';

const { t } = useI18n();

const props = defineProps({
  importers: Array,
  harvests: Array,
});

const form = useForm({
  batch_number: null,
  delivery_date: null,
  importer_id: [],
  harvests: [],
});

const submitHandler = () => form.post(route('batches.store'));
</script>

<template>
    <Head :title="t('batch.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('batch.titles.create')"
        :breadcrumbs="[{ to: 'batches.index', text: t('batch.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('batches.index') }"
      />
      <FormBatch
        :form="form"
        :importers="importers"
        :harvests="harvests"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

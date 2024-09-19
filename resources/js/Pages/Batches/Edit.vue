<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import FormBatch from '@/Pages/Batches/Form.vue';

import { stringToDate } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  importers: Array,
  harvests: Array,
});

const { data } = props.data;

const harvest_options = props.harvests
  .map((h) => {
    return {
      value: h.id,
      text: `Semana ${h.week} Batch ${h.batch}`,
    };
  })
  .sort((a, b) => a.text - b.text);

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  batch_number: data.batch_number,
  delivery_date: stringToDate(data.delivery_date),
  importer_id: data.importer_id,
  harvests: harvest_options.filter((a) => data.harvests.includes(a.value)),
});

const submitHandler = () => form.post(route('batches.update', data.id));
</script>

<template>
    <Head :title="t('batch.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('batch.titles.edit')"
        :breadcrumbs="[{ to: 'batches.index', text: t('batch.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.save_edit'), hrefCancel: route('batches.index') }"
      />
      <FormBatch
        :form="form"
        :importers="importers"
        :harvests="harvests"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

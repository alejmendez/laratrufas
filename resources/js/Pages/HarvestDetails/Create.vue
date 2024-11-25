<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FormHarvestDetails from '@/Pages/HarvestDetails/Form.vue';

const { t } = useI18n();

const props = defineProps({
  qualities: Array,
  plant_code: Array,
});

const form = useForm({
  plant_code: props.plant_code || null,
  quality: null,
  weight: null,
  keep_plant_code: false,
});

const submitHandler = () => form.post(route('harvests.details.store'));

const submitAndLoadAnother = () => {
  form.keep_plant_code = true;
  submitHandler();
};
</script>

<template>
    <Head :title="t('harvest.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }]"
      />
      <h3 class="text-2xl mb-3 input-label">
        Planta {{ form.plant_code }}
      </h3>
      <FormHarvestDetails
        :form="form"
        :qualities="props.qualities"
        :submitHandler="submitHandler"
        :submitAndLoadAnother="submitAndLoadAnother"
      />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import HarvestDetailLayout from '@/Layouts/HarvestDetailLayout.vue';
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

const submitAndLoadAnother = () => {
  form.post(route('harvests.details.store'));
};
</script>

<template>
    <Head :title="t('harvest.titles.entity_breadcrumb')" />

    <HarvestDetailLayout>
      <HeaderCrud
        :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }]"
      />
      <h3 class="text-2xl mb-3">
        Planta {{ form.plant_code }}
      </h3>
      <FormHarvestDetails
        :form="form"
        :harvests="props.harvests"
        :submitHandler="submitHandler"
        :submitAndLoadAnother="submitAndLoadAnother"
      />
    </HarvestDetailLayout>
</template>

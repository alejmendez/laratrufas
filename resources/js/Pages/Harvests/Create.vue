<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import FormHarvest from '@/Pages/Harvests/Form.vue';
import { generateSubmitHandler } from '@/Utils/form.js';

const { t } = useI18n();

const props = defineProps({
  quarters: Array,
  dogs: Array,
  users: Array,
  plant_codes: Array,
});

const form = useForm({
  date: null,
  batch: null,
  quarter_ids: [],
  dog_id: '',
  farmer_id: '',
  assistant_id: '',
});

const submitHandler = generateSubmitHandler(form, route('harvests.store'));
</script>

<template>
    <Head :title="t('harvest.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('harvest.titles.create')"
        :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
        :form="{ instance: form, submitHandler, submitText: t('generics.buttons.create'), hrefCancel: route('harvests.index') }"
      />
      <FormHarvest
        :form="form"
        :quarters="props.quarters"
        :dogs="props.dogs"
        :users="props.users"
        :plant_codes="props.plant_codes"
        :details="false"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

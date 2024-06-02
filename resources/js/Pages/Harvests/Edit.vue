<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { format, getWeek } from 'date-fns';
import { Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import FormHarvest from '@/Pages/Harvests/Form.vue';
import { Button } from '@/Components/ui/button';

import { stringToDate } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  quarters: Array,
  dogs: Array,
  users: Array,
  plant_codes: Array,
  qualities: Array,
});

const { data } = props.data;

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  date: stringToDate(data.date),
  batch: data.batch,
  quarter_ids: data.quarters.map((q) => ({ value: q.id, text: q.name })),
  dog_id: data.dog.id + '',
  farmer_id: data.farmer.id + '',
  assistant_id: data.assistant.id + '',
  details: data.details.length
    ? data.details
    : [
        {
          id: null,
          plant_code: null,
          quality: null,
          weight: null,
        },
      ],
});

const submitHandler = () => {
  form
    .transform((data) => ({
      ...data,
      date: data.date ? format(data.date, 'yyyy-MM-dd') : null,
      quarter_ids: data.quarter_ids.map((q) => q.value),
    }))
    .post(route('harvests.update', data.id));
};
</script>

<template>
    <Head :title="t('harvest.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('harvest.titles.edit', { batch: form.batch.toUpperCase(), week: getWeek(form.date, { weekStartsOn: 1 })})"
        :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
      >
        <Button
          :disabled="form.processing"
          @click="submitHandler"
          v-if="submitHandler"
        >
          <font-awesome-icon
            class="animate-spin me-1"
            :icon="['fas', 'circle-notch']"
            v-show="form.processing"
          />
          {{ t('generics.buttons.save_edit') }}
        </Button>

        <Button
          variant="secondary"
          as-child
          :disabled="form.processing"
        >
          <Link :href="route('harvests.index')">
            {{ t('generics.buttons.cancel') }}
          </Link>
        </Button>
      </HeaderCrud>

      <FormHarvest
        :form="form"
        :quarters="props.quarters"
        :dogs="props.dogs"
        :users="props.users"
        :plant_codes="props.plant_codes"
        :qualities="props.qualities"
        :details="true"
        :submitHandler="submitHandler"
      />
    </AuthenticatedLayout>
</template>

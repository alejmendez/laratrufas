<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { getWeek } from 'date-fns';

import FormHarvest from '@/Pages/Harvests/Form.vue';

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
  quarter_ids: data.quarters.map((q) => ({ text: q.name, value: q.id })),
  dog_id: props.dogs.find((a) => a.value == data.dog.id),
  farmer_id: props.users.find((a) => a.value == data.farmer.id),
  assistant_id: props.users.find((a) => a.value == data.assistant.id),
  details: data.details.length
    ? data.details.map((d) => ({ ...d, weight: parseFloat(d.weight), quality: props.qualities.find((q) => q.value == d.quality) }))
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
      details: data.details.map((d) => ({ ...d, quality: d.quality?.value })),
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
        class="btn btn-secondary border-gray-800"
        :loading="form.processing"
        :label="$t('generics.buttons.save_edit')"
        @click="submitHandler"
        v-if="submitHandler"
      />

      <Button
        as="Link"
        severity="secondary"
        :disabled="form.processing"
        :href="route('harvests.index')"
        :label="$t('generics.buttons.cancel')"
      />
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

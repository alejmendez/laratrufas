<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { getWeek } from 'date-fns';
import { stringToDate } from '@/Utils/date';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import VInputFile from '@/Components/Form/VInputFile.vue';
import BulkWrapper from '@/Components/BulkWrapper.vue';

const { t } = useI18n();

const props = defineProps({
  harvests: Array,
  id: Number,
  alert: String,
  errors: String,
});

const harvests = props.harvests
  .map((h) => {
    const week = getWeek(stringToDate(h.date), { weekStartsOn: 1 });
    return {
      value: h.id,
      text: `Semana ${week} Batch ${h.batch}`,
    };
  })
  .sort((a, b) => a.text - b.text);

const form = useForm({
  harvest_id: props.id ?? '',
  bulk_file: null,
});

const submitHandler = () => {
  if (form.harvest_id === '' || form.bulk_file === null) {
    return;
  }
  form.post(route('harvests.store.bulk'), {
    forceFormData: true,
  });
};

const changeFileHandler = (e) => {
  form.bulk_file = e.fileInput;
  submitHandler();
};
</script>

<template>
  <Head :title="t('harvest.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('harvest.titles.bulk')"
      :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.actions.bulk') }]"
      :form="{ instance: form }"
    />
    <form @submit.prevent="submitHandler">
      <BulkWrapper
        :alert="props.alert"
        :errors="props.errors"
        :title="t('generics.bulk.section_title')"
        downloadRoute="harvests.download.bulk.template"
      >
        <div class="px-6 pb-6 grid grid-cols-2 gap-x-16 gap-y-4">
          <VSelect
            id="harvest_id"
            v-model="form.harvest_id"
            :placeholder="t('generics.please_select')"
            :options="harvests"
            :label="t('harvest.bulk.form.harvest_id')"
            :message="form.errors.harvest_id"
            @change="() => submitHandler()"
          />

          <div class="form-text col-span-2 form-text-type">
            <VInputFile
              :label="t('generics.form.file.select_a_file')"
              :withRemove="false"
              :showPathFile="true"
              accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
              @change="changeFileHandler"
            />
          </div>
        </div>
      </BulkWrapper>
    </form>
  </AuthenticatedLayout>
</template>

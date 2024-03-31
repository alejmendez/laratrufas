<script setup>
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import VSelect from '@/Components/form/VSelect.vue';
import VInputFile from '@/Components/form/VInputFile.vue';
import BulkWrapper from '@/Components/BulkWrapper.vue';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  quarters: Array,
  alert: String,
  errors: String,
});

const form = useForm({
  field_id: '',
  quarter_id: '',
  bulk_file: null,
});

const quartersOptions = computed(() => props.quarters.filter((q) => q.field_id == form.field_id));

const submitHandler = () => {
  if (form.field_id === '' || form.quarter_id === '' || form.bulk_file === null) {
    return;
  }
  form.post(route('plants.store.bulk'), {
    forceFormData: true,
  });
};

const changeFileHandler = (e) => {
  form.bulk_file = e.fileInput;
  submitHandler();
};
</script>

<template>
  <Head :title="t('plant.titles.entity_breadcrumb')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('plant.titles.bulk')"
      :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.actions.bulk') }]"
      :form="{ instance: form }"
    />
    <form @submit.prevent="submitHandler">
      <BulkWrapper
        :alert="props.alert"
        :errors="props.errors"
        downloadRoute="plants.download.bulk.template"
      >
        <div class="px-6 pb-6 grid grid-cols-2 gap-x-16 gap-y-4">
          <VSelect
            id="field_id"
            v-model="form.field_id"
            :placeholder="t('generics.please_select')"
            :options="props.fields"
            :label="t('plant.bulk.form.field_id')"
            :message="form.errors.field_id"
            @change="() => submitHandler()"
          />

          <VSelect
            id="quarter_id"
            v-model="form.quarter_id"
            :placeholder="t('generics.please_select')"
            :options="quartersOptions"
            :label="t('plant.bulk.form.quarter_id')"
            :message="form.errors.quarter_id"
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

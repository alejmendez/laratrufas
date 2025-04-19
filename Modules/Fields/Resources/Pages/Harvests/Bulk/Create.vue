<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';
import BulkWrapper from '@Core/Components/BulkWrapper.vue';

import VSelect from '@Core/Components/Form/VSelect.vue';
import VInputFile from '@Core/Components/Form/VInputFile.vue';

const { t } = useI18n();

const props = defineProps({
  harvests: Array,
  id: String,
  message_success: String,
  unprocessed_message: String,
  unprocessed_details: Array,
  error_message: String,
  import_errors: Array,
});

const harvests = props.harvests
  .map((h) => {
    return {
      value: h.id,
      text: `Semana ${h.week} Batch ${h.batch}`,
    };
  })
  .sort((a, b) => a.text - b.text);

const harvest_id = harvests.find((h) => h.value == props.id);

const form = useForm({
  harvest_id: harvest_id,
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
  <AuthenticatedLayout :title="t('harvest.titles.entity_breadcrumb')">
    <HeaderCrud
      :title="t('harvest.titles.bulk')"
      :breadcrumbs="[{ to: 'harvests.index', text: t('harvest.titles.entity_breadcrumb') }, { text: t('generics.actions.bulk') }]"
      :form="{ instance: form }"
    />
    <form @submit.prevent="submitHandler">
      <BulkWrapper
        :message_success="props.message_success"
        :unprocessed_message="props.unprocessed_message"
        :unprocessed_details="props.unprocessed_details"
        :error_message="props.error_message"
        :errors="props.import_errors"
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

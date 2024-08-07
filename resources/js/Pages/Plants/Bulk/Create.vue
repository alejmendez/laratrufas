<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import BulkWrapper from '@/Components/BulkWrapper.vue';
import { getDataSelect } from '@/Services/Selects';

const { t } = useI18n();

const props = defineProps({
  fields: Array,
  quarters: Array,
  message_success: String,
  unprocessed_message: String,
  error_message: String,
  errors: Array,
});

const form = useForm({
  field_id: '',
  quarter_id: '',
  bulk_file: null,
});

const quartersOptions = ref(props.quarters);
watch(
  () => form.field_id,
  async (field_id) => {
    quartersOptions.value = await getDataSelect('quarter', { field_id });
    form.quarter_id = null;
  },
);

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
        :message_success="props.message_success"
        :unprocessed_message="props.unprocessed_message"
        :error_message="props.error_message"
        :errors="props.errors"
        :title="t('generics.bulk.section_title')"
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

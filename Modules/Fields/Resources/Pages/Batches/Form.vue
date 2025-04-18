<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import CardSection from '@/Components/CardSection.vue';
import VInput from '@/Components/Form/VInput.vue';
import VSelectMultiple from '@/Components/Form/VSelectMultiple.vue';
import AddImporter from '@/Components/Form/AddImporter.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  importers: Array,
  harvests: Array,
  submitHandler: Function,
});

const form = props.form;
const importers = ref(props.importers);

const harvests = props.harvests
  .map((h) => {
    return {
      value: h.id,
      text: `Semana ${h.week} Batch ${h.batch}`,
    };
  })
  .sort((a, b) => a.text - b.text);

const addImporterCallback = (newType) => {
  importers.value = [...importers.value, { value: newType.id, text: newType.name }];
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VInput
        id="batch_number"
        v-model="form.batch_number"
        :label="t('batch.form.batch_number.label')"
        :message="form.errors.batch_number"
      />

      <VInput
        id="delivery_date"
        type="date"
        v-model="form.delivery_date"
        :label="t('batch.form.delivery_date.label')"
        :message="form.errors.delivery_date"
        :maxDate="new Date()"
      />

      <div class="grid grid-cols-12">
        <VSelect
          id="importer_id"
          v-model="form.importer_id"
          classWrapper="col-span-11"
          :placeholder="t('generics.please_select')"
          :options="importers"
          :label="t('batch.form.importer_id.label')"
          :message="form.errors.importer_id"
        />
        <div class="ms-2" style="margin-top: 28px;">
          <AddImporter :callback="addImporterCallback" />
        </div>
      </div>

      <VSelectMultiple
        id="harvests"
        v-model="form.harvests"
        :placeholder="t('generics.please_select')"
        :options="harvests"
        :label="t('batch.form.harvests.label')"
        :message="form.errors.harvests"
      />
    </CardSection>
  </form>
</template>

<script setup>
import { ref } from 'vue';

import CardSection from '@Core/Components/CardSection.vue';
import VInput from '@Core/Components/Form/VInput.vue';
import VSelect from '@Core/Components/Form/VSelect.vue';
import VSelectMultiple from '@Core/Components/Form/VSelectMultiple.vue';
import AddImporter from '@Core/Components/Form/AddImporter.vue';

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
        :label="__('batch.form.batch_number.label')"
        :message="form.errors.batch_number"
      />

      <VInput
        id="delivery_date"
        type="date"
        v-model="form.delivery_date"
        :label="__('batch.form.delivery_date.label')"
        :message="form.errors.delivery_date"
        :maxDate="new Date()"
      />

      <div class="grid grid-cols-12">
        <VSelect
          id="importer_id"
          v-model="form.importer_id"
          classWrapper="col-span-11"
          :placeholder="__('generics.please_select')"
          :options="importers"
          :label="__('batch.form.importer_id.label')"
          :message="form.errors.importer_id"
        />
        <div class="ms-2" style="margin-top: 28px;">
          <AddImporter :callback="addImporterCallback" />
        </div>
      </div>

      <VSelectMultiple
        id="harvests"
        v-model="form.harvests"
        :placeholder="__('generics.please_select')"
        :options="harvests"
        :label="__('batch.form.harvests.label')"
        :message="form.errors.harvests"
      />
    </CardSection>
  </form>
</template>

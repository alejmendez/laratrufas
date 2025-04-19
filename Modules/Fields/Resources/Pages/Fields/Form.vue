<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import CardSection from '@Core/Components/CardSection.vue';
import VInput from '@Core/Components/Form/VInput.vue';
import VInputDni from '@Core/Components/Form/VInputDni.vue';
import VInputFile from '@Core/Components/Form/VInputFile.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  submitHandler: Function,
});

const form = props.form;
const documents = [...form.documents];

const blueprintPreview = ref(form.blueprint);

const changeFileHandler = (e) => {
  form.blueprint = e.fileInput;
  form.blueprintRemove = e.fileRemove;
};

const changeDocumentsHandler = (e) => {
  form.documents = e.fileInput;
  form.documentsRemove = e.fileRemove;
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VInput
        id="name"
        v-model="form.name"
        :label="t('field.form.name.label')"
        :message="form.errors.name"
      />

      <VInput
        id="location"
        maxlenmaxlength="100"
        v-model="form.location"
        :label="t('field.form.location.label')"
        :message="form.errors.location"
      />

      <VInput
        id="size"
        type="number"
        :min="0"
        :max="999"
        :step="0.01"
        v-model="form.size"
        :label="t('field.form.size.label')"
        :message="form.errors.size"
      />

      <VInput
        id="plants_count"
        :label="t('quarter.form.plants_count.label')"
        v-model="form.plants_count"
        readonly
        v-if="form.plants_count"
      />
    </CardSection>

    <CardSection>
      <VInputDni
        id="owner_dni"
        v-model="form.owner_dni"
        :label="t('field.form.owner_dni.label')"
        :message="form.errors.owner_dni"
      />

      <VInput
        id="owner_name"
        v-model="form.owner_name"
        :label="t('field.form.owner_name.label')"
        :message="form.errors.owner_name"
      />
    </CardSection>

    <CardSection :header-text="t('field.sections.blueprint')">
      <div class="form-text col-span-2 form-text-type">
        <VInputFile
          :image="blueprintPreview"
          :imagePreview="true"
          :label="t('field.form.blueprint.label')"
          @change="changeFileHandler"
        />
      </div>
    </CardSection>

    <CardSection :header-text="t('field.sections.documents')">
      <div class="form-text col-span-2 form-text-type">
        <VInputFile
          :files="documents"
          :imagePreview="false"
          :multiple="true"
          :label="t('field.form.documents.label')"
          @change="changeDocumentsHandler"
        />
      </div>
    </CardSection>
  </form>
</template>

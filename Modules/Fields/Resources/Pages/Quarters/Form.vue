<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  fields: Array,
  responsibles: Array,
  submitHandler: Function,
});

const form = props.form;

const blueprintPreview = ref(form.blueprint);

const changeFileHandler = (e) => {
  form.blueprint = e.fileInput;
  form.blueprintRemove = e.fileRemove;
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VSelect
        id="field_id"
        v-model="form.field_id"
        :placeholder="t('generics.please_select')"
        :options="props.fields"
        :label="t('quarter.form.field_id.label')"
        :message="form.errors.field_id"
      />
    </CardSection>

    <CardSection>
      <VInput
        id="name"
        v-model="form.name"
        :label="t('quarter.form.name.label')"
        :message="form.errors.name"
      />

      <VInput
        id="area"
        type="number"
        v-model="form.area"
        :min="0"
        :max="999"
        :step="0.01"
        :label="t('quarter.form.area.label')"
        :message="form.errors.area"
      />

      <VSelect
        id="responsible_id"
        v-model="form.responsible_id"
        :placeholder="t('generics.please_select')"
        :options="props.responsibles"
        :label="t('quarter.form.responsible_id.label')"
        :message="form.errors.responsible_id"
      />
    </CardSection>

    <CardSection :header-text="t('quarter.sections.blueprint')">
      <div class="form-text col-span-2 form-text-type">
        <VInputFile
          :image="blueprintPreview"
          :imagePreview="true"
          :label="t('quarter.form.blueprint.label')"
          @change="changeFileHandler"
        />
      </div>
    </CardSection>
  </form>
</template>

<script setup>
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  submitHandler: Function,
});

const form = props.form;
</script>

<style>
textarea.p-textarea.note {
  margin-top: 0;
  border-radius: 0;
  border: none;
}
</style>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection :header-text="t('security_equipment.sections.details')">
      <VInput
        id="name"
        v-model="form.name"
        :label="t('security_equipment.form.name.label')"
        :message="form.errors.name"
      />

      <VInput
        id="purchase_date"
        type="date"
        v-model="form.purchase_date"
        :label="t('security_equipment.form.purchase_date.label')"
        :message="form.errors.purchase_date"
        :maxDate="new Date()"
      />

      <VInput
        id="last_maintenance"
        type="date"
        v-model="form.last_maintenance"
        :label="t('security_equipment.form.last_maintenance.label')"
        :message="form.errors.last_maintenance"
        :maxDate="new Date()"
      />

      <VInput
        id="purchase_location"
        v-model="form.purchase_location"
        :label="t('security_equipment.form.purchase_location.label')"
        :message="form.errors.purchase_location"
      />

      <VInput
        id="type"
        v-model="form.type"
        :label="t('security_equipment.form.type.label')"
        :message="form.errors.type"
      />

      <VInput
        id="contact"
        v-model="form.contact"
        :label="t('security_equipment.form.contact.label')"
        :message="form.errors.contact"
      />
    </CardSection>

    <CardSection :header-text="t('security_equipment.sections.note')" wrapperClass="">
      <VInput
        id="note"
        type="textarea"
        class="min-h-36 note"
        v-model="form.note"
        :placeholder="t('security_equipment.form.note.placeholder')"
        :message="form.errors.note"
      />
    </CardSection>
  </form>
</template>

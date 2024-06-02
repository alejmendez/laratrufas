<script setup>
import { useI18n } from 'vue-i18n';
import VInput from '@/Components/Form/VInput.vue';
import CardSection from '@/Components/CardSection.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  submitHandler: Function,
});

const form = props.form;
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection :header-text="t('tool.sections.details')">
      <VInput
        id="name"
        v-model="form.name"
        :label="t('tool.form.name.label')"
        :message="form.errors.name"
      />

      <VInput
        id="purchase_date"
        type="date"
        v-model="form.purchase_date"
        :label="t('tool.form.purchase_date.label')"
        :message="form.errors.purchase_date"
        :maxDate="new Date()"
      />

      <VInput
        id="last_maintenance"
        type="date"
        v-model="form.last_maintenance"
        :label="t('tool.form.last_maintenance.label')"
        :message="form.errors.last_maintenance"
        :maxDate="new Date()"
      />

      <VInput
        id="purchase_location"
        v-model="form.purchase_location"
        :label="t('tool.form.purchase_location.label')"
        :message="form.errors.purchase_location"
      />

      <VInput
        id="type"
        v-model="form.type"
        :label="t('tool.form.type.label')"
        :message="form.errors.type"
      />

      <VInput
        id="contact"
        v-model="form.contact"
        :label="t('tool.form.contact.label')"
        :message="form.errors.contact"
      />
    </CardSection>
  </form>
</template>

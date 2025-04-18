<script setup>
import CardSection from '@/Components/CardSection.vue';
import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';

const props = defineProps({
  t: Function,
  form: Object,
  states: Array,
});

const t = props.t;
const form = props.form;

const priorities = ['when_possible', 'routine', 'important', 'urgent'].map((p) => ({
  value: p,
  text: t('task.form.priority.options.' + p),
}));
</script>

<template>
  <CardSection>
    <VInput
      id="name"
      v-model="form.name"
      classWrapper="col-span-2"
      :label="t('task.form.name.label')"
      :message="form.errors.name"
    />

    <VSelect
      id="priority"
      v-model="form.priority"
      :placeholder="t('generics.please_select')"
      :options="priorities"
      :label="t('task.form.priority.label')"
      :message="form.errors.priority"
    />

    <VSelect
      id="status"
      v-model="form.status"
      :placeholder="t('generics.please_select')"
      :options="states"
      :label="t('task.form.status.label')"
      :message="form.errors.status"
    />

    <VInput
      id="start_date"
      type="date"
      v-model="form.start_date"
      :label="t('task.form.start_date.label')"
      :message="form.errors.start_date"
    />

    <VInput
      id="end_date"
      type="date"
      v-model="form.end_date"
      :label="t('task.form.end_date.label')"
      :message="form.errors.end_date"
    />
  </CardSection>
</template>

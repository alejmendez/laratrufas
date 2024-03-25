<script setup>
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';

import VInput from '@/Components/form/VInput.vue';
import VSelect from '@/Components/form/VSelect.vue';
import VInputFile from '@/Components/form/VInputFile.vue';

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
    <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
      <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
        <VSelect
          id="field_id"
          v-model="form.field_id"
          :placeholder="t('generics.please_select')"
          :options="props.fields"
          :label="t('quarter.form.field_id.label')"
          :message="form.errors.field_id"
        />
      </div>
    </section>

    <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
      <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
        <VInput
          id="name"
          v-model="form.name"
          :label="t('quarter.form.name.label')"
          :message="form.errors.name"
        />

        <VInput
          id="area"
          type="number"
          min="0"
          max="2000"
          step="0.01"
          v-model="form.area"
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
      </div>
    </section>
    <section
      class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
    >
      <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
        <h3 class="text-base font-semibold leading-6 text-gray-950">
          {{ t('quarter.sections.blueprint') }}
        </h3>
      </header>
      <div class="border-t border-gray-200">
        <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
          <div class="form-text col-span-2 form-text-type">
            <VInputFile
              :image="blueprintPreview"
              :imagePreview="true"
              :label="t('quarter.form.blueprint.label')"
              @change="changeFileHandler"
            />
          </div>
        </div>
      </div>
    </section>
  </form>
</template>

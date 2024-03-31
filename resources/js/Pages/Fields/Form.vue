<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import VInput from '@/Components/form/VInput.vue';
import VInputFile from '@/Components/form/VInputFile.vue';
import VInputDni from '@/Components/form/VInputDni.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
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
      <div class="border-t border-gray-200">
        <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
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
            min="0"
            max="2000"
            step="0.01"
            v-model="form.size"
            :label="t('field.form.size.label')"
            :message="form.errors.size"
          />

          <VInput
            id="number_of_trees"
            :label="t('quarter.form.number_of_trees.label')"
            v-model="form.number_of_trees"
            readonly
            v-if="form.number_of_trees"
          />
        </div>
      </div>
    </section>

    <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
      <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
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
      </div>
    </section>

    <section
      class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
    >
      <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
        <h3 class="text-base font-semibold leading-6 text-gray-950">
          {{ t('field.sections.blueprint') }}
        </h3>
      </header>
      <div class="border-t border-gray-200">
        <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
          <div class="form-text col-span-2 form-text-type">
            <VInputFile
              :image="blueprintPreview"
              :imagePreview="true"
              :label="t('field.form.blueprint.label')"
              @change="changeFileHandler"
            />
          </div>
        </div>
      </div>
    </section>
  </form>
</template>

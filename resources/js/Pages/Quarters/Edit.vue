<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import VInput from '@/Components/form/VInput.vue'
import VInputFile from '@/Components/form/VInputFile.vue'
import VSelect from '@/Components/form/VSelect.vue'

const { t } = useI18n()

const props = defineProps({
  data: Object,
  fields: Array,
})

const { data } = props.data

const blueprintPreview = ref(data.blueprint)

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  location: data.location,
  area: data.area,
  planned_at: data.planned_at,
  field_id: data.field_id,
  blueprint: data.blueprint,
  blueprintRemove: false,
})

const submitHandler = () => {
  form.post(route('quarters.update', data.id), {
    forceFormData: true,
  })
}

const changeFileHandler = (e) => {
  form.blueprint = e.fileInput
  form.blueprintRemove = e.fileRemove
}
</script>

<template>
    <Head :title="t('quarter.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('quarter.titles.create')"
        :breadcrumbs="[{ to: 'quarters.index', text: t('quarter.titles.entity_breadcrumb') }, { text: t('generics.actions.create') }]"
      >
        <template v-slot:header>
          <button
            class="btn btn-primary"
            :disabled="form.processing"
            @click="submitHandler"
          >
            <font-awesome-icon
              class="animate-spin"
              :icon="['fas', 'circle-notch']"
              v-show="form.processing"
            />
            {{ t('generics.buttons.save_edit') }}
          </button>
          <Link
            :href="route('quarters.index')"
            class="btn btn-secondary"
          >
            {{ t('generics.buttons.cancel') }}
          </Link>
        </template>
      </HeaderCrud>
      <form @submit.prevent="submitHandler">
        <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
          <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
            <VInput
              id="name"
              v-model="form.name"
              :label="t('quarter.form.name.label')"
              :message="form.errors.name"
            />

            <VInput
              id="location"
              v-model="form.location"
              :label="t('quarter.form.location.label')"
              :message="form.errors.location"
            />

            <VInput
              id="area"
              v-model="form.area"
              :label="t('quarter.form.area.label')"
              :message="form.errors.area"
            />

            <VInput
              id="planned_at"
              v-model="form.planned_at"
              :label="t('quarter.form.planned_at.label')"
              :message="form.errors.planned_at"
            />

            <div>
              <label class="input-label">
                {{ t('quarter.form.number_of_trees.label') }}
              </label>
              <div class="input">0</div>
            </div>

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
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import VInput from '@/Components/form/VInput.vue'
import VInputFile from '@/Components/form/VInputFile.vue'
import VInputDni from '@/Components/form/VInputDni.vue'

const { t } = useI18n()

const props = defineProps({
  data: Object
})

const { data } = props.data

const blueprintPreview = ref(data.blueprint)

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  location: data.location,
  size: data.size,
  number_of_trees: data.number_of_trees,
  owner_dni: data.owner.dni,
  owner_name: data.owner.name,
  blueprint: data.blueprint,
  blueprintRemove: false,
})

const submitHandler = () => {
  form.post(route('fields.update', data.id), {
    forceFormData: true,
  })
}

const changeFileHandler = (e) => {
  form.blueprint = e.fileInput
  form.blueprintRemove = e.fileRemove
}
</script>

<template>
    <Head :title="t('field.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('field.titles.edit')"
        :breadcrumbs="[{ to: 'fields.index', text: t('field.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, hrefCancel: route('fields.index') }"
      />
      <form @submit.prevent="submitHandler">
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
                v-model="form.location"
                :label="t('field.form.location.label')"
                :message="form.errors.location"
              />

              <VInput
                id="size"
                v-model="form.size"
                :label="t('field.form.size.label')"
                :message="form.errors.size"
              />

              <VInput
                id="number_of_trees"
                :label="t('quarter.form.number_of_trees.label')"
                v-model="form.number_of_trees"
                disabled
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
    </AuthenticatedLayout>
</template>

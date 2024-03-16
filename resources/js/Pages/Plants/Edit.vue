<script setup>
import { computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import VInput from '@/Components/form/VInput.vue'
import VSelect from '@/Components/form/VSelect.vue'

const { t } = useI18n()

const props = defineProps({
  data: Object,
  fields: Array,
  quarters: Array,
  types: Array,
  rows: Array,
})

const { data } = props.data

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  plant_type_id: data.plant_type.id,
  age: data.age,
  planned_at: data.planned_at,
  nursery_origin: data.nursery_origin,
  code: data.code,
  field_id: data.field.id,
  quarter_id: data.quarter.id,
  row: data.row,
})

const quartersOptions = computed(() => props.quarters.filter((q) => q.field_id === form.field_id))

const submitHandler = () => {
  form.post(route('plants.update', data.id), {
    forceFormData: true,
  })
}
</script>

<template>
    <Head :title="t('plant.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('plant.titles.edit')"
        :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, hrefCancel: route('plants.index') }"
      />
      <form @submit.prevent="submitHandler">
        <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
          <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
            <VInput
              id="name"
              v-model="form.name"
              :label="t('plant.form.name.label')"
              :message="form.errors.name"
            />

            <VSelect
              id="plant_type_id"
              v-model="form.plant_type_id"
              :placeholder="t('generics.please_select')"
              :options="props.types"
              :label="t('plant.form.plant_type_id.label')"
              :message="form.errors.type"
            />

            <VInput
              id="age"
              v-model="form.age"
              :label="t('plant.form.age.label')"
              :message="form.errors.age"
            />

            <VInput
              id="planned_at"
              type="date"
              v-model="form.planned_at"
              :label="t('plant.form.planned_at.label')"
              :message="form.errors.planned_at"
            />

            <VInput
              id="nursery_origin"
              v-model="form.nursery_origin"
              :label="t('plant.form.nursery_origin.label')"
              :message="form.errors.nursery_origin"
            />

            <VInput
              id="code"
              v-model="form.code"
              :label="t('plant.form.code.label')"
              :message="form.errors.code"
            />
          </div>
        </section>
        <section
          class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
        >
          <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
            <h3 class="text-base font-semibold leading-6 text-gray-950">
              {{ t('plant.sections.location') }}
            </h3>
          </header>
          <div class="border-t border-gray-200">
            <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
              <VSelect
                id="field_id"
                v-model="form.field_id"
                :placeholder="t('generics.please_select')"
                :options="props.fields"
                :label="t('plant.form.field_id.label')"
                :message="form.errors.field_id"
              />

              <VSelect
                id="quarter_id"
                v-model="form.quarter_id"
                :placeholder="t('generics.please_select')"
                :options="quartersOptions"
                :label="t('plant.form.quarter_id.label')"
                :message="form.errors.quarter_id"
              />

              <VSelect
                id="row"
                v-model="form.row"
                :placeholder="t('generics.please_select')"
                :options="props.rows"
                :label="t('plant.form.row.label')"
                :message="form.errors.row"
              />
            </div>
          </div>
        </section>
      </form>
    </AuthenticatedLayout>
</template>

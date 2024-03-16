<script setup>
import { ref, computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import VInput from '@/Components/form/VInput.vue'
import VInputFile from '@/Components/form/VInputFile.vue'
import VSelect from '@/Components/form/VSelect.vue'

import { getAge } from '@/Utils/date';

const { t } = useI18n()

const props = defineProps({
  data: Object,
  fields: Array,
  quarters: Array,
  couples: Array,
})

const { data } = props.data

const avatarPreview = ref(data.avatar)

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  name: data.name,
  breed: data.breed,
  gender: data.gender,
  birthdate: data.birthdate,
  veterinary: data.veterinary,
  couple_id: data.couple.id,
  avatar: data.avatar,
  avatarRemove: false,
  field_id: data.field.id,
  quarter_id: data.quarter.id,
  vaccines: data.vaccines,
})

const genders = [
  {
    value: 'M',
    text: t('dog.form.gender.options.male'),
  },
  {
    value: 'F',
    text: t('dog.form.gender.options.female'),
  }
]

const age = computed(() => getAge(form.birthdate))

const quartersOptions = computed(() => props.quarters.filter((q) => q.field_id === form.field_id))

const submitHandler = () => {
  form.post(route('dogs.update', data.id), {
    forceFormData: true,
  })
}

const changeFileHandler = (e) => {
  form.avatar = e.fileInput
  form.avatarRemove = e.fileRemove
}

const add_vaccine = () => {
  form.vaccines.push({
    id: null,
    name: null,
    date: null,
    code: null,
  })
}

const remove_vaccine = (index) => {
  form.vaccines.splice(index, 1)
}
</script>

<template>
    <Head :title="t('dog.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('dog.titles.edit')"
        :breadcrumbs="[{ to: 'dogs.index', text: t('dog.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
        :form="{ instance: form, submitHandler, hrefCancel: route('dogs.index') }"
      />
      <form @submit.prevent="submitHandler">
        <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
          <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
            <div class="form-text col-span-2 form-text-type">
              <VInputFile
                :image="avatarPreview"
                :imagePreview="true"
                :label="t('dog.form.avatar.label')"
                @change="changeFileHandler"
              />
            </div>

            <VInput
              id="name"
              v-model="form.name"
              :label="t('dog.form.name.label')"
              :message="form.errors.name"
            />

            <VInput
              id="breed"
              v-model="form.breed"
              :label="t('dog.form.breed.label')"
              :message="form.errors.breed"
            />

            <VSelect
              id="gender"
              v-model="form.gender"
              :placeholder="t('generics.please_select')"
              :options="genders"
              :label="t('dog.form.gender.label')"
              :message="form.errors.gender"
            />

            <VInput
              id="birthdate"
              type="date"
              v-model="form.birthdate"
              :label="t('dog.form.birthdate.label')"
              :message="form.errors.birthdate"
            />

            <div>
              <label class="input-label">
                {{ t('dog.form.age.label') }}
              </label>
              <div class="input">{{ age }}</div>
            </div>

            <VSelect
              id="field_id"
              v-model="form.field_id"
              :placeholder="t('generics.please_select')"
              :options="props.fields"
              :label="t('dog.form.field_id.label')"
              :message="form.errors.field_id"
            />

            <VSelect
              id="quarter_id"
              v-model="form.quarter_id"
              :placeholder="t('generics.please_select')"
              :options="quartersOptions"
              :label="t('dog.form.quarter_id.label')"
              :message="form.errors.quarter_id"
            />

            <VInput
              id="veterinary"
              v-model="form.veterinary"
              :label="t('dog.form.veterinary.label')"
              :message="form.errors.veterinary"
            />

            <VSelect
              id="couple_id"
              v-model="form.couple_id"
              :placeholder="t('generics.please_select')"
              :options="props.couples"
              :label="t('dog.form.couple_id.label')"
              :message="form.errors.couple_id"
            />
          </div>
        </section>

        <section
          class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
        >
          <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
            <h3 class="text-base font-semibold leading-6 text-gray-950">
              {{ t('dog.sections.vaccines') }}
            </h3>
          </header>
          <div class="border-t border-gray-200">
            <div
              class="p-6 grid grid-cols-2 gap-x-16 gap-y-4"
              v-for="(vaccine, index) in form.vaccines"
            >
              <VInput
                :id="`vaccines_name_${index}`"
                v-model="vaccine.name"
                :label="t('dog.form.vaccines.name.label')"
                :message="form.errors.vaccines? form.errors.vaccines[index].name : ''"
              />

              <div class="grid grid-cols-9 gap-x-16 gap-y-4">
                <VInput
                  :id="`vaccines_date_${index}`"
                  type="date"
                  v-model="vaccine.date"
                  class="col-span-4"
                  :label="t('dog.form.vaccines.date.label')"
                  :message="form.errors.vaccines? form.errors.vaccines[index].date : ''"
                />

                <VInput
                  :id="`vaccines_code_${index}`"
                  v-model="vaccine.code"
                  class="col-span-4"
                  :label="t('dog.form.vaccines.code.label')"
                  :message="form.errors.vaccines? form.errors.vaccines[index].code : ''"
                />
                <div class="pt-8 text-black hover:text-red-500" v-if="index !== 0" @click="remove_vaccine(index)">
                  <font-awesome-icon :icon="['fas', 'trash-can']" />
                </div>
              </div>
            </div>

            <div class="p-6">
              <button class="btn btn-secondary border-gray-800" @click.prevent="add_vaccine">{{ t('dog.buttons.add_vaccine') }}</button>
            </div>
          </div>
        </section>
      </form>
    </AuthenticatedLayout>
</template>

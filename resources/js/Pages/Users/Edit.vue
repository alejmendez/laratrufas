<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import VInput from '@/Components/form/VInput.vue'
import VSelect from '@/Components/form/VSelect.vue'
import VInputFile from '@/Components/form/VInputFile.vue'
import VInputDni from '@/Components/form/VInputDni.vue'

const { t } = useI18n()

const props = defineProps({
  data: Object,
  roles: Array,
})

const { data } = props.data

const avatarPreview = ref(data.avatar)

const form = useForm({
  _method: 'PATCH',
  id: data.id,
  dni: data.dni,
  name: data.name,
  last_name: data.last_name,
  email: data.email,
  phone: data.phone,
  password: data.password,
  role: data.role.name,
  avatar: data.avatar,
  avatarRemove: false,
})

const submitHandler = () => {
  form.post(route('users.update', data.id), {
    forceFormData: true,
  })
}

const changeFileHandler = (e) => {
  form.avatar = e.fileInput
  form.avatarRemove = e.fileRemove
}
</script>

<template>
    <Head :title="t('user.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('user.titles.edit')"
        :breadcrumbs="[{ to: 'users.index', text: t('user.titles.entity_breadcrumb') }, { text: t('generics.actions.edit') }]"
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
            :href="route('users.index')"
            class="btn btn-secondary"
          >
            {{ t('generics.buttons.cancel') }}
          </Link>
        </template>
      </HeaderCrud>
      <form @submit.prevent="submitHandler">
        <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
          <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
            <h3 class="text-base font-semibold leading-6 text-gray-950">
              {{ t('user.sections.details') }}
            </h3>
          </header>
          <div class="border-t border-gray-200">
            <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
              <div class="form-text col-span-2 form-text-type">
                <VInputFile
                  :image="avatarPreview"
                  :imagePreview="true"
                  :label="t('generics.form.file.select_a_image')"
                  @change="changeFileHandler"
                />
              </div>

              <VInputDni
                id="dni"
                v-model="form.dni"
                :label="t('user.form.dni.label')"
                :message="form.errors.dni"
              />

              <VInput
                id="name"
                v-model="form.name"
                :label="t('user.form.name.label')"
                :message="form.errors.name"
              />

              <VInput
                id="last_name"
                v-model="form.last_name"
                :label="t('user.form.last_name.label')"
                :message="form.errors.last_name"
              />

              <VInput
                id="email"
                v-model="form.email"
                :label="t('user.form.email.label')"
                :message="form.errors.email"
              />

              <VInput
                id="phone"
                v-model="form.phone"
                v-mask="'(+##) # #### ####'"
                :label="t('user.form.phone.label')"
                :message="form.errors.phone"
              />

              <VInput
                id="password"
                v-model="form.password"
                :label="t('user.form.password.label')"
                :message="form.errors.password"
              />
            </div>
          </div>
        </section>
        <section
          class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
        >
          <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
            <h3 class="text-base font-semibold leading-6 text-gray-950">
              {{ t('user.sections.roles') }}
            </h3>
          </header>
          <div class="border-t border-gray-200">
            <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
              <VSelect
                id="role"
                v-model="form.role"
                :placeholder="t('generics.please_select')"
                :options="props.roles"
                :label="t('user.form.role.label')"
                :message="form.errors.role"
              />
            </div>
          </div>
        </section>
      </form>
    </AuthenticatedLayout>
</template>

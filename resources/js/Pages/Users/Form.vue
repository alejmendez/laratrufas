<script setup>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'

import VInput from '@/Components/form/VInput.vue'
import VSelect from '@/Components/form/VSelect.vue'
import VInputFile from '@/Components/form/VInputFile.vue'
import VInputDni from '@/Components/form/VInputDni.vue'

const { t } = useI18n()

const props = defineProps({
  form: Object,
  roles: Array,
  submitHandler: Function,
  showRole: {
    type: Boolean,
    default: true,
  },
})

const form = props.form

const avatarPreview = ref(form.avatar)

const changeFileHandler = (e) => {
  form.avatar = e.fileInput
  form.avatarRemove = e.fileRemove
}
</script>

<template>
  <form @submit.prevent="props.submitHandler">
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
            type="password"
            v-model="form.password"
            :label="t('user.form.password.label')"
            :message="form.errors.password"
          />
        </div>
      </div>
    </section>
    <section
      class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
      v-if="props.showRole"
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
</template>

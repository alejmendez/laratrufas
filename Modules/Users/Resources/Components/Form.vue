<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import VElementFormWrapper from '@/Components/Form/VElementFormWrapper.vue';
import VInputDni from '@/Components/Form/VInputDni.vue';
import InputMask from 'primevue/inputmask';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  roles: Array,
  submitHandler: Function,
  showRole: {
    type: Boolean,
    default: true,
  },
});

const form = props.form;

const avatarPreview = ref(form.avatar);

const changeFileHandler = (e) => {
  form.avatar = e.fileInput;
  form.avatarRemove = e.fileRemove;
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection :header-text="t('user.sections.details')">
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

      <VElementFormWrapper :classWrapper="props.classWrapper" :label="t('user.form.phone.label')" :message="form.errors.phone">
        <InputMask
          v-model="form.phone"
          mask="(+99) 9 9999 9999"
          fluid
        />
      </VElementFormWrapper>

      <VInput
        id="password"
        type="password"
        v-model="form.password"
        :label="t('user.form.password.label')"
        :message="form.errors.password"
      />
    </CardSection>
    <CardSection :header-text="t('user.sections.roles')" v-if="props.showRole">
      <VSelect
        id="role"
        v-model="form.role"
        :placeholder="t('generics.please_select')"
        :options="props.roles"
        :label="t('user.form.role.label')"
        :message="form.errors.role"
      />
    </CardSection>
  </form>
</template>

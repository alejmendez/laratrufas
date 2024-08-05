<script setup>
import { ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { getDataSelect } from '@/Services/Selects';

import { getAge } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  fields: Array,
  quarters: Array,
  couples: Array,
  submitHandler: Function,
});

const form = props.form;

const avatarPreview = ref(form.avatar);

const genders = [
  {
    value: 'M',
    text: t('dog.form.gender.options.male'),
  },
  {
    value: 'F',
    text: t('dog.form.gender.options.female'),
  },
];

const calculateAge = () => (form.age = getAge(form.birthdate));

const quartersOptions = ref(props.quarters);
watch(
  () => form.field_id,
  async (field_id) => {
    console.log({
      field_id: form.field_id,
    });
    quartersOptions.value = await getDataSelect('quarter', { field_id });
    form.quarter_id = null;
  },
);

const changeFileHandler = (e) => {
  form.avatar = e.fileInput;
  form.avatarRemove = e.fileRemove;
};

const add_vaccine = () => {
  form.vaccines.push({
    id: null,
    name: null,
    date: null,
    code: null,
  });
};

const remove_vaccine = (index) => {
  form.vaccines.splice(index, 1);
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
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
        @change="calculateAge"
        :maxDate="new Date()"
      />

      <VInput
        id="age"
        :label="t('dog.form.age.label')"
        v-model="form.age"
        readonly
        :message="form.errors.age"
      />

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
    </CardSection>

    <CardSection :header-text="t('dog.sections.vaccines')" wrapperClass="">
      <div
        class="p-6 grid grid-cols-2 gap-x-16 gap-y-4"
        v-for="(vaccine, index) in form.vaccines"
      >
        <VInput
          :id="`vaccines_name_${index}`"
          v-model="vaccine.name"
          :label="t('dog.form.vaccines.name.label')"
          :message="form.errors[`vaccines.${index}.name`]"
        />

        <div class="grid grid-cols-9 gap-x-16 gap-y-4">
          <VInput
            :id="`vaccines_date_${index}`"
            type="date"
            v-model="vaccine.date"
            class="col-span-4"
            :label="t('dog.form.vaccines.date.label')"
            :message="form.errors[`vaccines.${index}.date`]"
            :max-date="new Date()"
          />

          <VInput
            :id="`vaccines_code_${index}`"
            v-model="vaccine.code"
            class="col-span-4"
            :label="t('dog.form.vaccines.code.label')"
            :message="form.errors[`vaccines.${index}.code`]"
          />
          <div class="pt-8 text-black hover:text-red-500" v-if="index !== 0" @click="remove_vaccine(index)">
            <font-awesome-icon :icon="['fas', 'trash-can']" />
          </div>
        </div>
      </div>

      <div class="p-6">
        <Button
          class="btn btn-secondary border-gray-800"
          @click.prevent="add_vaccine"
          :label="$t('dog.buttons.add_vaccine')"
        />
      </div>
    </CardSection>
  </form>
</template>

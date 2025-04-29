<script setup>
import { ref, watch } from 'vue';
import { trans } from 'laravel-vue-i18n';

import CardSection from '@Core/Components/CardSection.vue';
import VInput from '@Core/Components/Form/VInput.vue';
import VInputFile from '@Core/Components/Form/VInputFile.vue';
import VSelect from '@Core/Components/Form/VSelect.vue';
import Button from '@Core/Components/Form/Button.vue';

import { getDataSelect } from '@Core/Services/Selects';
import { getAge } from '@Core/Utils/date';

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
    text: trans('dog.form.gender.options.male'),
  },
  {
    value: 'F',
    text: trans('dog.form.gender.options.female'),
  },
];

form.gender = genders.find((a) => a.value == form.gender);

const calculateAge = () => (form.age = getAge(form.birthdate));

const quartersOptions = ref(props.quarters);
watch(
  () => form.field_id,
  async (field_id) => {
    quartersOptions.value = await getDataSelect('quarter', { field_id: field_id.value });
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
          :label="__('dog.form.avatar.label')"
          @change="changeFileHandler"
        />
      </div>

      <VInput
        id="name"
        v-model="form.name"
        :label="__('dog.form.name.label')"
        :message="form.errors.name"
      />

      <VInput
        id="breed"
        v-model="form.breed"
        :label="__('dog.form.breed.label')"
        :message="form.errors.breed"
      />

      <VSelect
        id="gender"
        v-model="form.gender"
        :placeholder="__('generics.please_select')"
        :options="genders"
        :label="__('dog.form.gender.label')"
        :message="form.errors.gender"
      />

      <VInput
        id="birthdate"
        type="date"
        v-model="form.birthdate"
        :label="__('dog.form.birthdate.label')"
        :message="form.errors.birthdate"
        @change="calculateAge"
        :maxDate="new Date()"
      />

      <VInput
        id="age"
        :label="__('dog.form.age.label')"
        v-model="form.age"
        readonly
        :message="form.errors.age"
      />

      <VSelect
        id="field_id"
        v-model="form.field_id"
        :placeholder="__('generics.please_select')"
        :options="props.fields"
        :label="__('dog.form.field_id.label')"
        :message="form.errors.field_id"
      />

      <VSelect
        id="quarter_id"
        v-model="form.quarter_id"
        :placeholder="__('generics.please_select')"
        :options="quartersOptions"
        :label="__('dog.form.quarter_id.label')"
        :message="form.errors.quarter_id"
      />

      <VInput
        id="veterinary"
        v-model="form.veterinary"
        :label="__('dog.form.veterinary.label')"
        :message="form.errors.veterinary"
      />

      <VSelect
        id="couple_id"
        v-model="form.couple_id"
        :placeholder="__('generics.please_select')"
        :options="props.couples"
        :label="__('dog.form.couple_id.label')"
        :message="form.errors.couple_id"
      />
    </CardSection>

    <CardSection :header-text="__('dog.sections.vaccines')" wrapperClass="">
      <div
        class="p-6 grid grid-cols-2 gap-x-16 gap-y-4"
        v-for="(vaccine, index) in form.vaccines"
      >
        <VInput
          :id="`vaccines_name_${index}`"
          v-model="vaccine.name"
          :label="__('dog.form.vaccines.name.label')"
          :message="form.errors[`vaccines.${index}.name`]"
        />

        <div class="grid grid-cols-9 gap-x-16 gap-y-4">
          <VInput
            :id="`vaccines_date_${index}`"
            type="date"
            v-model="vaccine.date"
            class="col-span-4"
            :label="__('dog.form.vaccines.date.label')"
            :message="form.errors[`vaccines.${index}.date`]"
            :max-date="new Date()"
          />

          <VInput
            :id="`vaccines_code_${index}`"
            v-model="vaccine.code"
            class="col-span-4"
            :label="__('dog.form.vaccines.code.label')"
            :message="form.errors[`vaccines.${index}.code`]"
          />
          <div class="pt-8 text-black hover:text-red-500" v-if="index !== 0" @click="remove_vaccine(index)">
            <span class="material-symbols-rounded">delete</span>
          </div>
        </div>
      </div>

      <div class="p-6">
        <Button
          class="btn btn-secondary border-gray-800"
          @click.prevent="add_vaccine"
          :label="__('dog.buttons.add_vaccine')"
        />
      </div>
    </CardSection>
  </form>
</template>

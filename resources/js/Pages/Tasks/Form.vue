<script setup>
import { useI18n } from 'vue-i18n';
import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import CardSection from '@/Components/CardSection.vue';
import ButtonShadcn from '@/Components/ui/button/Button.vue';


const { t } = useI18n();

const props = defineProps({
  form: Object,
  submitHandler: Function,
});

const form = props.form;
const priorities = {
  low: 'Baja',
  medium: 'Media',
  high: 'Alta',
  urgent: 'Urgente',
};
const states = {

};

const quarters = [];
const plants = [];
const tools = [];
const equipments = [];
const units = [];
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VInput
        id="name"
        v-model="form.name"
        :label="t('task.form.name.label')"
        :message="form.errors.name"
      />

      <VInput
        id="repeat_number"
        v-model="form.repeat_number"
        :label="t('task.form.repeat_number.label')"
        :message="form.errors.repeat_number"
      />

      <VInput
        id="repeat_type"
        v-model="form.repeat_type"
        :label="t('task.form.repeat_type.label')"
        :message="form.errors.repeat_type"
      />

      <VSelect
        id="priority"
        v-model="form.priority"
        :placeholder="t('generics.please_select')"
        :options="priorities"
        :label="t('task.form.priority.label')"
        :message="form.errors.priority"
      />

      <VSelect
        id="status"
        v-model="form.status"
        :placeholder="t('generics.please_select')"
        :options="states"
        :label="t('task.form.status.label')"
        :message="form.errors.status"
      />

      <VInput
        id="start_date"
        type="date"
        v-model="form.start_date"
        :label="t('task.form.start_date.label')"
        :message="form.errors.start_date"
      />

      <VInput
        id="end_date"
        type="date"
        v-model="form.end_date"
        :label="t('task.form.end_date.label')"
        :message="form.errors.end_date"
      />
    </CardSection>

    <CardSection :header-text="t('task.sections.assignment')">
      <VSelect
        id="field_id"
        v-model="form.field_id"
        :placeholder="t('generics.please_select')"
        :options="props.fields"
        :label="t('task.form.field_id.label')"
        :message="form.errors.field_id"
      />

      <VSelect
        id="quarter_id"
        v-model="form.quarter_id"
        :placeholder="t('generics.please_select')"
        :options="quarters"
        :label="t('task.form.quarter_id.label')"
        :message="form.errors.quarter_id"
      />

      <VSelect
        id="plant_id"
        v-model="form.plant_id"
        :placeholder="t('generics.please_select')"
        :options="plants"
        :label="t('task.form.plant_id.label')"
        :message="form.errors.plant_id"
      />

      <VSelect
        id="responsible_id"
        v-model="form.responsible_id"
        :placeholder="t('generics.please_select')"
        :options="props.responsibles"
        :label="t('task.form.responsible_id.label')"
        :message="form.errors.responsible_id"
      />
    </CardSection>

    <CardSection :header-text="t('task.sections.resources')">
      <VSelect
        id="tools"
        v-model="form.tools"
        :placeholder="t('generics.please_select')"
        :options="tools"
        :label="t('task.form.tools.label')"
        :message="form.errors.tools"
      />

      <VSelect
        id="equipments"
        v-model="form.equipments"
        :placeholder="t('generics.please_select')"
        :options="equipments"
        :label="t('task.form.equipments.label')"
        :message="form.errors.equipments"
      />

      <div
        class="p-6 grid grid-cols-2 gap-x-16 gap-y-4"
        v-for="(supply, index) in form.supplies"
      >
        <VInput
          :id="`supplies_name_${index}`"
          v-model="supply.name"
          :label="t('task.form.supplies.name.label')"
          :message="form.errors.supplies? form.errors.supplies[index].name : ''"
        />

        <div class="grid grid-cols-9 gap-x-16 gap-y-4">
          <VInput
            :id="`supplies_brand_${index}`"
            v-model="supply.brand"
            :label="t('task.form.supplies.brand.label')"
            :message="form.errors.supplies? form.errors.supplies[index].brand : ''"
          />
          <VInput
            :id="`supplies_quantity_${index}`"
            v-model="supply.quantity"
            :label="t('task.form.supplies.quantity.label')"
            :message="form.errors.supplies? form.errors.supplies[index].quantity : ''"
          />

          <VSelect
            :id="`supplies_unit_${index}`"
            v-model="form.unit"
            :placeholder="t('generics.please_select')"
            :options="units"
            :label="t('task.form.unit.label')"
            :message="form.errors.unit"
          />
          <div class="pt-8 text-black hover:text-red-500" v-if="index !== 0" @click="remove_vaccine(index)">
            <font-awesome-icon :icon="['fas', 'trash-can']" />
          </div>
        </div>
      </div>

      <div class="p-6">
        <ButtonShadcn class="btn btn-secondary border-gray-800" @click.prevent="add_vaccine">{{ t('dog.buttons.add_vaccine') }}</ButtonShadcn>
      </div>
    </CardSection>
  </form>
</template>

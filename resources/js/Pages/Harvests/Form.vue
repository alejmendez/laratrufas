<script setup>
import { useI18n } from 'vue-i18n';
import { format, getWeek, endOfWeek, startOfWeek } from 'date-fns';

import VueMultiselect from 'vue-multiselect'
import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import { Label } from '@/Components/ui/label';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  quarters: Array,
  dogs: Array,
  users: Array,
  plant_codes: Array,
  details: Boolean,
  submitHandler: Function,
});

const form = props.form;

const add_detail = () => {
  form.details.push({
    plant_code: null,
    quality: '',
    weight: null,
  });
};

const remove_detail = (index) => {
  form.details.splice(index, 1);
};

const dateRenderText = (m) => {
  const start = format(startOfWeek(m, { weekStartsOn: 1 }), 'dd/MM/yyyy');
  const end = format(endOfWeek(m, { weekStartsOn: 1 }), 'dd/MM/yyyy');
  const week = getWeek(m, { weekStartsOn: 1 });
  return `Semana ${week} - ${start} al ${end}`;
}
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
      <div class="border-t border-gray-200">
        <div class="p-6 grid grid-cols-2 gap-x-16 gap-y-4">
          <VInput
            id="date"
            type="date"
            v-model="form.date"
            :renderText="dateRenderText"
            :maxDate="new Date()"
            :label="t('harvest.form.date.label')"
            :message="form.errors.date"
          />

          <div>
            <Label class="input-label">
              {{ t('harvest.form.quarter_ids.label') }}
            </Label>

            <VueMultiselect
              class="mt-1"
              v-model="form.quarter_ids"
              :options="props.quarters"
              :multiple="true"
              :placeholder="t('generics.please_select')"
              :group-select="true"
              group-values="quarters"
              group-label="field"
              track-by="value"
              :customLabel="(o) => o.text"
            >
              <span slot="noResult">{{ t('generics.form.multiselect.not_found') }}</span>
            </VueMultiselect>
          </div>

          <VInput
            id="batch"
            v-model="form.batch"
            maxlength="2"
            v-mask="'AA'"
            :label="t('harvest.form.batch.label')"
            :message="form.errors.batch"
          />

          <VSelect
            id="dog_id"
            v-model="form.dog_id"
            :placeholder="t('generics.please_select')"
            :options="props.dogs"
            :label="t('harvest.form.dog_id.label')"
            :message="form.errors.dog_id"
          />

          <VSelect
            id="farmer_id"
            v-model="form.farmer_id"
            :placeholder="t('generics.please_select')"
            :options="props.users"
            :label="t('harvest.form.farmer_id.label')"
            :message="form.errors.farmer_id"
          />

          <VSelect
            id="assistant_id"
            v-model="form.assistant_id"
            :placeholder="t('generics.please_select')"
            :options="props.users"
            :label="t('harvest.form.assistant_id.label')"
            :message="form.errors.assistant_id"
          />
        </div>
      </div>
    </section>

    <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5" v-if="props.details">
      <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
        <h3 class="text-base font-semibold leading-6 text-gray-950">
          {{ t('harvest.sections.harvest') }}
        </h3>
      </header>
      <div class="border-t border-gray-200">
        <div
          class="px-6 py-3 grid grid-cols-2 gap-x-16 gap-y-4"
          v-for="(detail, index) in form.details"
        >
          <VInput
            :id="`details_plant_code_${index}`"
            v-model="detail.plant_code"
            :label="t('harvest.form.details.plant_code.label')"
            :message="form.errors.details? form.errors.details[index].plant_code : ''"
          />

          <div class="grid grid-cols-9 gap-x-16 gap-y-4">
            <VInput
              :id="`details_quality_${index}`"
              v-model="detail.quality"
              class="col-span-4"
              :label="t('harvest.form.details.quality.label')"
              :message="form.errors.details? form.errors.details[index].quality : ''"
            />

            <VInput
              :id="`details_weight_${index}`"
              v-model="detail.weight"
              class="col-span-4"
              :label="t('harvest.form.details.weight.label')"
              :message="form.errors.details? form.errors.details[index].weight : ''"
            />
            <div class="pt-8 text-black hover:text-red-500" v-if="index !== 0" @click="remove_detail(index)">
              <font-awesome-icon :icon="['fas', 'trash-can']" />
            </div>
          </div>
        </div>

        <div class="px-6 py-3">
          <button class="btn btn-secondary border-gray-800" @click.prevent="add_detail">{{ t('harvest.buttons.add_detail') }}</button>
        </div>
      </div>
    </section>
  </form>
</template>

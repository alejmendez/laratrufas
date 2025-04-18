<script setup>
import { ref, computed, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { format, getWeek, endOfWeek, startOfWeek } from 'date-fns';

import Dialog from 'primevue/dialog';
import DatePicker from 'primevue/datepicker';
import InputText from 'primevue/inputtext';
import InputGroup from 'primevue/inputgroup';
import InputNumber from 'primevue/inputnumber';
import VirtualScroller from 'primevue/virtualscroller';

import CardSection from '@/Components/CardSection.vue';
import VElementFormWrapper from '@/Components/Form/VElementFormWrapper.vue';
import VSelectMultiple from '@/Components/Form/VSelectMultiple.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import Button from '@/Components/Form/Button.vue';
import VInput from '@/Components/Form/VInput.vue';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  quarters: Array,
  dogs: Array,
  users: Array,
  plant_codes: Array,
  qualities: Array,
  details: Boolean,
  submitHandler: Function,
});

const form = props.form;

const dateRenderText = (m) => {
  const start = format(startOfWeek(m, { weekStartsOn: 1 }), 'dd/MM/yyyy');
  const end = format(endOfWeek(m, { weekStartsOn: 1 }), 'dd/MM/yyyy');
  const week = getWeek(m, { weekStartsOn: 1 });
  return t('harvest.form.date.renderText', { week, start, end });
};

const date_rendered = ref(form.date ? dateRenderText(form.date) : '');
const show_modal_datepicker = ref(false);

const add_detail = () => {
  form.details.push({
    id: null,
    plant_code: form.details[form.details.length - 1].plant_code,
    quality: null,
    weight: null,
  });
};

const remove_detail = (index) => {
  form.details.splice(index, 1);
};

const handler_open_datepicker = () => {
  show_modal_datepicker.value = true;
};

const handler_date_selected = () => {
  date_rendered.value = dateRenderText(form.date);
  show_modal_datepicker.value = false;
};

const handler_input_batch = (e) => {
  const filteredValue = e.target.value.replace(/[^a-zA-Z]/g, '').toUpperCase();
  e.target.value = filteredValue;
  form.batch = filteredValue;
};

const totalWeight = computed(() => {
  if (!form.details) {
    return 0;
  }

  return form.details.reduce((sum, detail) => {
    return sum + (Number(detail.weight) || 0);
  }, 0);
});

watch(totalWeight, (newValue) => {
  form.weight = newValue;
});
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VElementFormWrapper :label="t('harvest.form.date.label')" :message="form.errors.date">
        <InputGroup>
          <InputText
            fluid
            v-model="date_rendered"
            variant="filled"
            @click="handler_open_datepicker"
          />
          <Button severity="secondary" icon="pi pi-calendar" @click="handler_open_datepicker" />
        </InputGroup>
      </VElementFormWrapper>

      <VSelectMultiple
        v-model="form.quarter_ids"
        optionGroupLabel="text"
        optionGroupChildren="items"
        :options="props.quarters"
        :label="$t('harvest.form.quarter_ids.label')"
        :placeholder="t('generics.please_select')"
        :message="form.errors.quarter_ids"
      />

      <VInput
        id="batch"
        v-model="form.batch"
        maxlength="2"
        @input="handler_input_batch"
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
    </CardSection>

    <CardSection
      wrapperClass=""
      v-if="props.details"
    >
      <template #header>
        <header class="flex items-center justify-between gap-x-3 overflow-hidden px-6 py-4">
          <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-gray-100">
            {{ t('harvest.sections.harvest', { batch: form.batch.toUpperCase(), week: getWeek(form.date, { weekStartsOn: 1 })}) }}
          </h3>

          <div class="flex items-center gap-2">
            {{ t('harvest.form.weight.label') }}
            <InputNumber
              v-model="form.weight"
              :message="form.errors.weight"
              showButtons
              :min="0"
              :step="1"
              suffix=" grs"
            />
          </div>
        </header>
      </template>

      <VirtualScroller :items="form.details" :itemSize="30" style="height: 500px">
        <template v-slot:item="{ item, options }">
          <div class="px-6 py-3 grid grid-cols-2 gap-x-16 gap-y-4">
            <VInput
              :id="`details_plant_code_${options.index}`"
              v-model="item.plant_code"
              :label="t('harvest.form.details.plant_code.label')"
              :message="form.errors[`details.${options.index}.plant_code`]"
            />

            <div class="grid grid-cols-9 gap-x-16 gap-y-4">
              <VSelect
                :id="`details_quality_${options.index}`"
                class="col-span-4"
                v-model="item.quality"
                :placeholder="t('generics.please_select')"
                :options="props.qualities"
                :label="t('harvest.form.details.quality.label')"
                :message="form.errors[`details.${options.index}.quality`]"
              />

              <VInput
                :id="`details_weight_${options.index}`"
                type="number"
                class="col-span-4"
                v-model="item.weight"
                :min="0"
                :max="20000"
                :step="1"
                :label="t('harvest.form.details.weight.label')"
                :message="form.errors[`details.${options.index}.weight`]"
              />
              <div class="pt-8 text-black dark:text-white hover:text-red-500 cursor-pointer dark:hover:text-red-500" @click="remove_detail(options.index)">
                <font-awesome-icon :icon="['fas', 'trash-can']" />
              </div>
            </div>
          </div>
        </template>
      </VirtualScroller>
      <div class="px-6 py-3">
        <Button
          severity="secondary"
          @click.prevent="add_detail"
          :label="$t('harvest.buttons.add_detail')"
        />

        <Button
          class="ms-3"
          as="Link"
          severity="secondary"
          :href="route('harvests.create.bulk', { id: form.id })"
          :label="$t('generics.bulk.button')"
        />
      </div>
    </CardSection>
  </form>

  <Dialog v-model:visible="show_modal_datepicker" modal header="Seleccionar Fecha">
    <DatePicker v-model="form.date" fluid inline showWeek @date-select="handler_date_selected" />
  </Dialog>
</template>

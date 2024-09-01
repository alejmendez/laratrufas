<script setup>
import { ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import InputGroup from 'primevue/inputgroup';

import VSelectMultiple from '@/Components/Form/VSelectMultiple.vue';

import { getDataSelect } from '@/Services/Selects';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  submitHandler: Function,
  fields: Array,
  quarters: {
    type: Array,
    default: [],
  },
  plants: {
    type: Array,
    default: [],
  },
  responsibles: Array,
  tools: Array,
  machineries: Array,
});

const form = props.form;
const priorities = ['when_possible', 'routine', 'important', 'urgent'].map((p) => ({
  value: p,
  text: t('task.form.priority.options.' + p),
}));

const statesValues = ['to_begin', 'started', 'stopped', 'finished'];

const states = statesValues.map((s) => ({ value: s, text: t('task.form.status.options.' + s) }));

const repeat_types = ['diary', 'weekly', 'monthly'].map((s) => ({ value: s, text: t('task.form.repeat_type.options.' + s) }));

const quarters = ref(props.quarters);
const plants = ref(props.plants);

watch(
  () => form.field_id,
  async (field_id) => {
    quarters.value = await getDataSelect('quarter', { field_id });
    form.quarter_id = null;
  },
);

watch(
  () => form.quarter_id,
  async (quarter_id) => {
    plants.value = await getDataSelect('plant', { quarter_id });
    form.plant_id = null;
  },
);

const rows = generateLetterArray().map((r) => ({ value: r, text: r }));

const units = [
  'unit',
  'package',
  'box',
  'pallet',
  'container',
  'grams',
  'kilograms',
  'tons',
  'milliliters',
  'liters',
  'gallons',
  'barrels',
  'millimeters',
  'centimeters',
  'meters',
  'kilometers',
  'inches',
  'feet',
  'yards',
].map((u) => ({ value: u, text: t('task.form.supplies.unit.options.' + u) }));

const add_supply = () => {
  form.supplies.push({
    id: null,
    name: null,
    brand: null,
    quantity: null,
    unit: '',
  });
};

const remove_supply = (index) => {
  form.supplies.splice(index, 1);
};

function generateLetterArray() {
  const letters = [];

  for (let i = 0; i < 26; i++) {
    letters.push(String.fromCharCode(65 + i));
  }

  for (let i = 0; i < 1; i++) {
    for (let j = 0; j < 26; j++) {
      letters.push(String.fromCharCode(65 + i) + String.fromCharCode(65 + j));
    }
  }

  return letters;
}
</script>

<style>
.p-button.btn-status {
  margin-right: 20px;
}

.p-button.btn-status.btn-to_begin {
  background-color: #6C757D;
  border-color: #6C757D;
}

.p-button.btn-status.btn-to_begin:hover {
  background-color: #5a6168;
  border-color: #5a6168;
}

.p-button.btn-status.btn-started {
  background-color: #17A2B8;
  border-color: #17A2B8;
}

.p-button.btn-status.btn-started:hover {
  background-color: #158fa1;
  border-color: #158fa1;
}

.p-button.btn-status.btn-stopped {
  background-color: #28A745;
  border-color: #28A745;
}

.p-button.btn-status.btn-stopped:hover {
  background-color: #22923d;
  border-color: #22923d;
}

.p-button.btn-status.btn-finished {
  background-color: #DC3545;
  border-color: #DC3545;
}

.p-button.btn-status.btn-finished:hover {
  background-color: #bd2d3b;
  border-color: #bd2d3b;
}

textarea.p-textarea.comment {
  margin-top: 0;
  border-radius: 0;
  border: none;
}
</style>

<template>
  <div class="mt-5">
    <Button
      v-for="state in states"
      :class="`btn-status btn-${state.value} text-l`"
      @click.prevent="form.status = state"
      :label="$t(`task.form.status.options.${state.value}`)"
      :icon="form.status.value === state.value ? 'pi pi-check-square' : 'pi pi-stop'"
    />
  </div>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VInput
        id="name"
        v-model="form.name"
        :label="t('task.form.name.label')"
        :message="form.errors.name"
      />

      <div>
        <Label for="repeat_number">
          {{ $t('task.form.repeat_number.label') }}
        </Label>

        <InputGroup>
          <InputText
            id="repeat_number"
            v-model="form.repeat_number"
            type="number"
            min="1"
            max="2000"
            step="1"
            :message="form.errors.repeat_number"
          />
          <Select
            id="repeat_type"
            v-model="form.repeat_type"
            :placeholder="t('generics.please_select')"
            :options="repeat_types"
            optionLabel="text"
            style="max-width: 160px;"
          />
        </InputGroup>
      </div>

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

      <VSelectMultiple
        id="quarter_id"
        v-model="form.quarter_id"
        :placeholder="t('generics.please_select')"
        :options="quarters"
        :label="t('task.form.quarter_id.label')"
        :message="form.errors.quarter_id"
      />

      <VSelectMultiple
        id="rows"
        v-model="form.rows"
        :placeholder="t('generics.please_select')"
        :options="rows"
        :virtualScrollerOptions="{ itemSize: 44 }"
        :label="t('task.form.rows.label')"
        :message="form.errors.rows"
      />

      <VSelectMultiple
        id="plant_id"
        v-model="form.plant_id"
        :placeholder="t('generics.please_select')"
        :options="plants"
        :virtualScrollerOptions="{ itemSize: 44 }"
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

    <CardSection :header-text="t('task.sections.resources')" wrapperClass="">
      <div class="p-6 grid md:grid-cols-2 gap-x-16 gap-y-4 sm:grid-cols-1">
        <VSelectMultiple
          class="mt-1"
          v-model="form.tools"
          :options="props.tools"
          :label="$t('task.form.tools.label')"
          :placeholder="t('generics.please_select')"
          :message="form.errors.tools"
        />

        <VSelectMultiple
          class="mt-1"
          v-model="form.machineries"
          :options="props.machineries"
          :label="$t('task.form.machineries.label')"
          :placeholder="t('generics.please_select')"
          :message="form.errors.machineries"
        />
      </div>

      <div
        class="px-6 py-2 grid grid-cols-2 gap-x-16 gap-y-4"
        v-for="(supply, index) in form.supplies"
      >
        <VInput
          :id="`supplies_name_${index}`"
          v-model="supply.name"
          :label="t('task.form.supplies.name.label')"
          :message="form.errors[`supplies.${index}.name`]"
        />
        <!-- class="col-span-4" -->
        <div class="grid grid-cols-10">
          <div class="grid grid-cols-3 gap-x-4 gap-y-4 col-span-9">
            <VInput
              :id="`supplies_brand_${index}`"
              v-model="supply.brand"
              :label="t('task.form.supplies.brand.label')"
              :message="form.errors[`supplies.${index}.brand`]"
            />
            <VInput
              :id="`supplies_quantity_${index}`"
              v-model="supply.quantity"
              type="number"
              min="0"
              max="2000"
              step="0.01"
              :label="t('task.form.supplies.quantity.label')"
              :message="form.errors[`supplies.${index}.quantity`]"
            />

            <VSelect
              :id="`supplies_unit_${index}`"
              v-model="supply.unit"
              :placeholder="t('generics.please_select')"
              :options="units"
              :label="t('task.form.supplies.unit.label')"
              :message="form.errors[`supplies.${index}.unit`]"
            />
          </div>
          <div class="pt-8" v-if="index !== 0">
            <font-awesome-icon
              :icon="['fas', 'trash-can']"
              class="float-right me-3 text-black hover:text-red-500"
              @click="remove_supply(index)"
            />
          </div>
        </div>
      </div>

      <div class="p-6">
        <Button @click.prevent="add_supply" :label="$t('task.buttons.add_supply')" />
      </div>
    </CardSection>

    <CardSection :header-text="t('task.sections.comments')" wrapperClass="">
      <VInput
        id="comments"
        type="textarea"
        class="min-h-36 comment"
        v-model="form.comments"
        :placeholder="t('task.form.comments.placeholder')"
        :message="form.errors.comments"
      />
    </CardSection>
  </form>
</template>

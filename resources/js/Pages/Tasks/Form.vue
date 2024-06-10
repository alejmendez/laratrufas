<script setup>
import { watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { Label as LabelShadcn } from '@/Components/ui/label';
import { Input as InputShadcn } from '@/Components/ui/input';
import ButtonShadcn from '@/Components/ui/button/Button.vue';

import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import CardSection from '@/Components/CardSection.vue';
import VueMultiselect from 'vue-multiselect';

import { getDataSelect } from '@/Services/Selects';

const { t } = useI18n();

const props = defineProps({
  form: Object,
  submitHandler: Function,
  fields: Array,
  responsibles: Array,
  tools: Array,
  machineries: Array,
});

const form = props.form;

const priorities = [
  'when_possible',
  'routine',
  'important',
  'urgent',
].map(p => ({ value: p, text: t('task.form.priority.options.' + p), }));

const statesValues = [
  'to_begin',
  'started',
  'stopped',
  'finished',
];

const states = statesValues.map(s => ({ value: s, text: t('task.form.status.options.' + s), }));

const repeat_types = [
  'diary',
  'weekly',
  'monthly',
].map(s => ({ value: s, text: t('task.form.repeat_type.options.' + s), }));

let quarters = [];
let plants = [];

watch(() => form.field_id, async (field_id) => {
  quarters = await getDataSelect('quarter', { field_id })
});

watch(() => form.quarter_id, async (quarter_id) => {
  plants = await getDataSelect('plant', { quarter_id })
});

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
].map(u => ({ value: u, text: t('task.form.supplies.unit.options.' + u), }));

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
</script>

<style scoped>
.btn-status {
  border: none;
  margin-right: 20px;
}

.btn.btn-to_begin {
  background-color: #6C757D;
}

.btn.btn-to_begin:hover {
  background-color: #5a6168;
}

.btn.btn-started {
  background-color: #17A2B8;
}

.btn.btn-started:hover {
  background-color: #158fa1;
}

.btn.btn-stopped {
  background-color: #28A745;
}

.btn.btn-stopped:hover {
  background-color: #22923d;
}

.btn.btn-finished {
  background-color: #DC3545;
}

.btn.btn-finished:hover {
  background-color: #bd2d3b;
}
</style>

<template>
  <div class="mt-5">
    <ButtonShadcn
      v-for="state in statesValues"
      :class="`btn btn-status btn-${state} text-l`"
      @click.prevent="form.status = state"
    >
      <font-awesome-icon
        v-if="form.status === state"
        class="mr-2 text-xl"
        :icon="['far', 'square-check']"
      />
      <font-awesome-icon
        class="mr-2 text-xl"
        :icon="['far', 'square']"
        v-else
      />
      {{ t(`task.form.status.options.${state}`) }}
    </ButtonShadcn>
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
        <LabelShadcn for="repeat_number" class="input-label">
          {{ t('task.form.repeat_number.label') }}
        </LabelShadcn>

        <div class="flex">
          <InputShadcn
            id="repeat_number"
            class="input mt-1"
            type="text"
            v-model="form.repeat_number"
            :message="form.errors.repeat_number"
          />
          <VSelect
            id="repeat_type"
            v-model="form.repeat_type"
            :placeholder="t('generics.please_select')"
            :options="repeat_types"
          />
        </div>
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

    <CardSection :header-text="t('task.sections.resources')" wrapperClass="">
      <div class="p-6 grid md:grid-cols-2 gap-x-16 gap-y-4 sm:grid-cols-1">
        <div>
          <LabelShadcn class="input-label">
            {{ t('task.form.tools.label') }}
          </LabelShadcn>
          <VueMultiselect
            class="mt-1"
            v-model="form.tools"
            :options="props.tools"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
            :placeholder="t('generics.please_select')"
            track-by="value"
            :customLabel="(o) => o.text"
          >
            <span slot="noResult">{{ t('generics.form.multiselect.not_found') }}</span>
          </VueMultiselect>
        </div>

        <div>
          <LabelShadcn class="input-label">
            {{ t('task.form.machineries.label') }}
          </LabelShadcn>
          <VueMultiselect
            class="mt-1"
            v-model="form.machineries"
            :options="props.machineries"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
            :placeholder="t('generics.please_select')"
            track-by="value"
            :customLabel="(o) => o.text"
          >
            <span slot="noResult">{{ t('generics.form.multiselect.not_found') }}</span>
          </VueMultiselect>
        </div>
      </div>

      <div
        class="px-6 py-2 grid grid-cols-2 gap-x-16 gap-y-4"
        v-for="(supply, index) in form.supplies"
      >
        <VInput
          :id="`supplies_name_${index}`"
          v-model="supply.name"
          :label="t('task.form.supplies.name.label')"
          :message="form.errors.supplies? form.errors.supplies[index].name : ''"
        />
        <!-- class="col-span-4" -->
        <div class="grid grid-cols-10">
          <div class="grid grid-cols-3 gap-x-4 gap-y-4 col-span-9">
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
              v-model="supply.unit"
              :placeholder="t('generics.please_select')"
              :options="units"
              :label="t('task.form.supplies.unit.label')"
              :message="form.errors.unit"
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
        <ButtonShadcn class="btn btn-secondary border-gray-800" @click.prevent="add_supply">{{ t('task.buttons.add_supply') }}</ButtonShadcn>
      </div>
    </CardSection>

    <CardSection :header-text="t('task.sections.comments')" wrapperClass="">
      <VInput
        id="comments"
        type="textarea"
        class="mt-0 min-h-36"
        v-model="form.comments"
        :placeholder="t('task.form.comments.placeholder')"
        :message="form.errors.comments"
      />
    </CardSection>
  </form>
</template>

<script setup>
import VSelectMultiple from '@/Components/Form/VSelectMultiple.vue';

const props = defineProps({
  t: Function,
  form: Object,
  tools: Array,
  security_equipments: Array,
  machineries: Array,
});

const t = props.t;
const form = props.form;

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
</script>

<template>
  <CardSection :header-text="t('task.sections.resources')" wrapperClass="">
    <div class="p-6 grid md:grid-cols-3 gap-x-16 gap-y-4 sm:grid-cols-1">
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

      <VSelectMultiple
        class="mt-1"
        v-model="form.security_equipments"
        :options="props.security_equipments"
        :label="$t('task.form.security_equipments.label')"
        :placeholder="t('generics.please_select')"
        :message="form.errors.security_equipments"
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
            :min="0"
            :max="2000"
            :step="0.01"
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
</template>

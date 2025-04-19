<script setup>
import { useI18n } from 'vue-i18n';

import FormAssignment from './Assignment.vue';
import FormMain from './Main.vue';
import FormComments from './Comments.vue';
import FormResources from './Resources.vue';

import Button from '@Core/Components/Form/Button.vue';

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
  security_equipments: Array,
  machineries: Array,
});

const form = props.form;

const statesValues = ['to_begin', 'started', 'finished', 'stopped'];
const statesClasses = {
  to_begin: '!bg-gray-500 !border-gray-500 hover:!bg-gray-600 hover:!border-gray-600',
  started: '!bg-cyan-500 !border-cyan-500 hover:!bg-cyan-600 hover:!border-cyan-600',
  finished: '!bg-green-500 !border-green-500 hover:!bg-green-600 hover:!border-green-600',
  stopped: '!bg-red-500 !border-red-500 hover:!bg-red-600 hover:!border-red-600',
};

const states = statesValues.map((s) => ({ value: s, text: t('task.form.status.options.' + s) }));
</script>

<template>
  <div class="mt-5">
    <Button
      v-for="state in states"
      :class="`me-3 text-l ${statesClasses[state.value]}`"
      @click.prevent="form.status = state"
      :label="$t(`task.form.status.options.${state.value}`)"
      :icon="form.status.value === state.value ? 'pi pi-check-square' : 'pi pi-stop'"
    />
  </div>
  <form @submit.prevent="props.submitHandler">
    <FormMain :form="form" :t="t" :states="states" />
    <FormAssignment :form="form" :t="t" :fields="props.fields" :quarters="props.quarters" :plants="props.plants" :responsibles="props.responsibles" />
    <FormResources :form="form" :t="t" :tools="tools" :security_equipments="security_equipments" :machineries="machineries" />
    <FormComments :form="form" :t="t" :responsibles="props.responsibles" />
  </form>
</template>

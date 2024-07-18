<script setup>
import { useI18n } from 'vue-i18n';
import { format, getWeek, endOfWeek, startOfWeek } from 'date-fns';

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

const add_detail = () => {
  form.details.push({
    id: null,
    plant_code: form.details[form.details.length - 1].plant_code,
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
  return t('harvest.form.date.renderText', { week, start, end });
};
</script>

<template>
  <form @submit.prevent="props.submitHandler">
    <CardSection>
      <VInput
        id="date"
        type="date"
        v-model="form.date"
        :renderText="dateRenderText"
        :label="t('harvest.form.date.label')"
        :message="form.errors.date"
      />

      <div>
        <Label class="input-label">
          {{ $t('harvest.form.quarter_ids.label') }}
        </Label>

        <VueMultiselect
          class="mt-1"
          v-model="form.quarter_ids"
          :options="props.quarters"
          :multiple="true"
          :close-on-select="false"
          :clear-on-select="false"
          :placeholder="t('generics.please_select')"
          :group-select="true"
          group-values="quarters"
          group-label="field"
          track-by="value"
          :customLabel="(o) => o.text"
        >
          <span slot="noResult">{{ $t('generics.form.multiselect.not_found') }}</span>
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
    </CardSection>

    <CardSection :header-text="t('harvest.sections.harvest', { batch: form.batch.toUpperCase(), week: getWeek(form.date, { weekStartsOn: 1 })})" wrapperClass="" v-if="props.details">
      <div
        class="px-6 py-3 grid grid-cols-2 gap-x-16 gap-y-4"
        v-for="(detail, index) in form.details"
      >
        <VInput
          :id="`details_plant_code_${index}`"
          v-model="detail.plant_code"
          :label="t('harvest.form.details.plant_code.label')"
          :message="form.errors[`details.${index}.plant_code`]"
        />

        <div class="grid grid-cols-9 gap-x-16 gap-y-4">
          <VSelect
            :id="`details_quality_${index}`"
            class="col-span-4"
            v-model="detail.quality"
            :placeholder="t('generics.please_select')"
            :options="props.qualities"
            :label="t('harvest.form.details.quality.label')"
            :message="form.errors[`details.${index}.quality`]"
          />

          <VInput
            :id="`details_weight_${index}`"
            type="number"
            min="0"
            max="20000"
            step="1"
            class="col-span-4"
            v-model="detail.weight"
            :label="t('harvest.form.details.weight.label')"
            :message="form.errors[`details.${index}.weight`]"
          />
          <div class="pt-8 text-black hover:text-red-500" @click="remove_detail(index)">
            <font-awesome-icon :icon="['fas', 'trash-can']" />
          </div>
        </div>
      </div>
      <div class="px-6 py-3">
        <Button variant="secondary" @click.prevent="add_detail">{{ $t('harvest.buttons.add_detail') }}</Button>

        <Button
          variant="secondary"
          as-child
          class="ms-3"
        >
          <Link :href="route('harvests.create.bulk', { id: form.id })">
            {{ $t('generics.bulk.button') }}
          </Link>
        </Button>
      </div>
    </CardSection>
  </form>
</template>

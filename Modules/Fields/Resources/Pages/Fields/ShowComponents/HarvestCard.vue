<script setup>
import HarvestTable from '@Fields/Pages/Harvests/Components/HarvestTable.vue';

const props = defineProps({
  field_id: Number,
  harvest_available_years: Array,
  harvest_available_weeks: Array,
  field: Array,
  quarter: Array,
  user: Array,
});
</script>

<template>
  <div>
    <HarvestTable
      :field_id="props.field_id"
      :show_actions="false"
      :harvest_available_years="props.harvest_available_years"
      :harvest_available_weeks="props.harvest_available_weeks"
      :field="props.field"
      :quarter="props.quarter"
      :user="props.user"
    />
  </div>
</template>

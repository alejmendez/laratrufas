<script setup>
import HarvestTable from '@Fields/Pages/Harvests/Components/HarvestTable.vue';

const props = defineProps({
  field_id: Number,
});
</script>

<template>
  <div>
    <HarvestTable
      :field_id="props.field_id"
      :show_actions="false"
    />
  </div>
</template>

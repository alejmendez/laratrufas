<script setup>
import HarvestTable from '@/Pages/Harvests/Components/HarvestTable.vue';

const props = defineProps({
  quarter_id: Number,
});
</script>

<template>
  <div>
    <HarvestTable
      :quarter_id="props.quarter_id"
      :show_actions="false"
    />
  </div>
</template>

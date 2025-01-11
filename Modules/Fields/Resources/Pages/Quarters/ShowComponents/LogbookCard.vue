<script setup>
import LogsCard from '@Fields/Pages/Plants/ShowComponents/LogsCard.vue';

const props = defineProps({
  quarter_id: Number,
});
</script>

<template>
  <LogsCard :quarter_id="props.quarter_id" />
</template>

<script setup>
import LogsCard from '@/Pages/Plants/ShowComponents/LogsCard.vue';

const props = defineProps({
  field_id: Number,
});
</script>

<template>
  <LogsCard :field_id="props.field_id" />
</template>

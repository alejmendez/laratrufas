<script setup>
import { useI18n } from 'vue-i18n';
import HarvestTable from '@Fields/Pages/Harvests/Components/HarvestTable.vue';

const props = defineProps({
  field_id: Number,
});

const { t } = useI18n();
</script>

<template>
  <div>
    <HarvestTable
      :field_id="props.field_id"
      :show_actions="false"
    />
  </div>
</template>

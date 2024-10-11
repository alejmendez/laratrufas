<script setup>
import { ref, watch, toRaw } from 'vue';
import { useI18n } from 'vue-i18n';
import HarvestTable from '@/Pages/Harvests/Components/HarvestTable.vue';

const props = defineProps({
  field: Object,
});

const { t } = useI18n();
</script>

<template>
  <div>
    <HarvestTable
      :show_actions="false"
    />
  </div>
</template>

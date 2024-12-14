<script setup>
import { ref, computed, nextTick } from 'vue';
import { useI18n } from 'vue-i18n';

import Timeline from 'primevue/timeline';
import Checkbox from 'primevue/checkbox';

import { stringToFormat } from '@/Utils/date';
const { t } = useI18n();

const props = defineProps({
  details: Array,
});

const categories = ref([
  { name: 'height', key: 'height' },
  { name: 'crown_diameter', key: 'crown_diameter' },
  { name: 'trunk_diameter', key: 'trunk_diameter' },
  { name: 'root_diameter', key: 'root_diameter' },
  { name: 'invasion_radius', key: 'invasion_radius' },
  { name: 'foliage_sanitation', key: 'foliage_sanitation' },
  { name: 'trunk_sanitation', key: 'trunk_sanitation' },
  { name: 'soil_sanitation', key: 'soil_sanitation' },
  { name: 'irrigation_system', key: 'irrigation_system' },
]);

const selectedCategories = ref(categories.value.map((category) => category.name));
const selectAll = ref(['all']);
const selectAllHandler = async () => {
  await nextTick();
  if (selectAll.value.includes('all')) {
    selectedCategories.value = categories.value.map((category) => category.name);
  } else {
    selectedCategories.value = [];
  }
};

const selectHandler = async () => {
  await nextTick();
  if (selectedCategories.value.length === categories.value.length) {
    selectAll.value = ['all'];
  } else {
    selectAll.value = [];
  }
};

const colors = {
  height: '#39FF14',
  crown_diameter: '#FF0000',
  trunk_diameter: '#0066FF',
  root_diameter: '#FF00FF',
  invasion_radius: '#FFFF00',
  foliage_sanitation: '#00FFFF',
  trunk_sanitation: '#FF1493',
  soil_sanitation: '#00FF00',
  irrigation_system: '#FF6600',
};

const detailsFiltered = computed(() => {
  return props.details.filter((detail) => selectedCategories.value.includes(detail.type));
});

// mostrar bitacora - pre-filtrar por cosecha y por año cuando viene desde el heatmap del cuartel
</script>

<template>
  <div class="grid grid-cols-4 gap-4">
    <CardSection
      wrapperClass="p-5"
    >
      <div class="justify-center">
        <Checkbox v-model="selectAll" :inputId="`all-categories`" name="category" value="all" @change="selectAllHandler" />
        <label class="ms-2" :for="`all-categories`">{{ t(`harvest_details.all_categories`) }}</label>

        <span class="ms-8 text-surface-500 dark:text-surface-400">{{ t(`harvest_details.selected`, { size: selectedCategories.length }) }}</span>

        <div v-for="category of categories" :key="category.key" class="flex items-center gap-2 my-4">
          <Checkbox v-model="selectedCategories" :inputId="category.key" name="category" :value="category.name" @change="selectHandler" />
          <label :for="category.key">
            {{ t(`harvest_details.form.${category.name}.label`) }}
            <!--
              <div class="w-4 h-4 mt-1 ms-2 border-2 border-gray-500 rounded-full float-end" :style="{ backgroundColor: colors[category.name] }"></div>
            -->
          </label>
        </div>
      </div>
    </CardSection>
    <CardSection
      wrapperClass="p-5"
      sectionClass="mt-5 col-span-3 rounded-xl shadow-sm ring-1 ring-gray-950/5"
    >
      <div v-if="detailsFiltered.length > 0">
        <Timeline :value="detailsFiltered">
          <template #marker="slotProps">
            <span class="flex w-8 h-8 items-center justify-center text-white rounded-full z-10 shadow-sm" :style="{ backgroundColor: colors[slotProps.item.type] }">
              <i class="pi pi-circle-fill"></i>
            </span>
          </template>
          <template #opposite="slotProps">
            <span class="text-surface-500 dark:text-surface-400">{{ stringToFormat(slotProps.item.updated_at, 'dd/MM/yyyy HH:mm') }}</span>
          </template>
          <template #content="slotProps">
            {{ t(`harvest_details.form.${slotProps.item.type}.label`) }} <br />
            {{ slotProps.item.value }}
          </template>
        </Timeline>
      </div>
      <div v-else class="my-20">
        <p class="text-center text-surface-500 dark:text-surface-400">
          {{ t('harvest_details.no_data') }}
        </p>
        <p class="text-center text-surface-500 dark:text-surface-400">
          {{ t('harvest_details.no_data_description') }}
        </p>
      </div>
    </CardSection>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import QuarterService from '@/Services/QuarterService.js';

const props = defineProps({
  quarter: Object,
});

const { t } = useI18n();
const plants = ref([]);
const tableCols = ref([]);

onMounted(async () => {
  const response = await QuarterService.getPlants(props.quarter.id);

  const plantsByCols = Object.groupBy(response, ({ row }) => row);
  const cols = Object.keys(plantsByCols);
  const maxRows = Object.values(plantsByCols).reduce((acc, cur) => (cur.length > acc ? cur.length : acc), 0);
  const data = [];

  for (let i = 0; i < maxRows; i++) {
    const row = [];
    for (const col of cols) {
      if (!plantsByCols[col][i]) {
        row.push(null);
        continue;
      }
      const plant = plantsByCols[col][i];
      plant.number = plant.code;

      const numbers = plant.code.match(/\d+/g);
      plant.position = numbers[numbers.length - 1];

      row.push(plant);
    }
    data.push(row);
  }

  tableCols.value = cols;
  plants.value = data;
});
</script>

<style>
table.tabla-heat-map {
  text-align: center;
  th {
    background-color: #ddd;
    padding: 4px 0;
  }
  tr:nth-child(odd) {
    background-color: #f9f9f9;
  }
  tr:nth-child(even) {
    background-color: #e9e9e9;
  }
}
</style>

<template>
  <CardSection
    :header-text="t('field.show.statistics.title')"
    wrapperClass="p-5 grid gap-4"
  >
    <table class="tabla-heat-map">
      <thead>
        <tr>
          <th v-for="col in tableCols" v-text="col" />
        </tr>
      </thead>
      <tbody>
        <tr v-for="plantRow in plants">
          <td v-for="plant in plantRow" v-text="plant?.position" v-tooltip.top="plant?.code" />
        </tr>
      </tbody>
    </table>
  </CardSection>
</template>

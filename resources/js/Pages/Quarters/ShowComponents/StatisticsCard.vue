<script setup>
import { ref, toRaw, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import Dialog from 'primevue/dialog';
import QuarterService from '@/Services/QuarterService.js';

const props = defineProps({
  quarter: Object,
});

const { t } = useI18n();
const plants = ref([]);
const tableCols = ref([]);

const dataPlantsPosition = ref([]);
const open = ref(false);
const loading = ref(false);
const distributionPlants = ref('');

const changeDistribution = () => {
  const distribution = distributionPlants.value.split("\n").map((c) => {
    return c.split('\t');
  });

  const data = toRaw(dataPlantsPosition.value).reduce((acc, curr) => (acc[curr.code] = curr, acc), {});
  const distributionData = [];
  const dataToSave = [];
  for (let i = 0; i < distribution.length; i++) {
    const row = distribution[i];

    if (row.length === 1 && row[0] === '') continue;

    if (row.length != distribution[0].length) {
      console.error("No se puede procesar");
      return;
    }
    // console.log({row});
    const rowData = [];
    for (let j = 0; j < row.length; j++) {
      const ele = row[j];
      if (ele === '' || ele === undefined || data[ele] === undefined) {
        rowData.push('');
        continue;
      }
      // console.log(data[ele]);
      rowData.push(data[ele]);
      dataToSave.push([ele, i, j]);
    }
    distributionData.push(rowData);
  }

  QuarterService.updatePlantsPosition(props.quarter.id, dataToSave);

  plants.value = distributionData;
}

const generatePlantsDispositionWithPosition = (plantsPositions) => {
  const plantsByCols = Object.groupBy(plantsPositions, ({ row }) => row);
  const plantsByPosition = plantsPositions.filter(a => a.position != null).reduce((acc, curr)=> (acc[curr.position] = curr, acc), {});
  const cols = Object.keys(plantsByCols);
  const maxRows = Object.values(plantsByCols).reduce((acc, cur) => (cur.length > acc ? cur.length : acc), 0);
  const data = [];

  for (let i = 0; i < maxRows; i++) {
    const row = [];
    let j = 0;
    for (const col of cols) {
      const pos = `${i},${j++}`;
      console.log(plantsByPosition[pos]);
      if (!plantsByPosition[pos]) {
        row.push(null);
        continue;
      }
      const plant = plantsByPosition[pos];
      plant.number = plant.code;

      const numbers = plant.code.match(/\d+/g);
      plant.position = numbers[numbers.length - 1];

      row.push(plant);
    }
    data.push(row);
  }

  tableCols.value = cols;
  plants.value = data;
}

const generatePlantsDisposition = (plantsPositions) => {
  const hasPosition = plantsPositions.some(a => a.position);
  if (hasPosition) return generatePlantsDispositionWithPosition(plantsPositions);
  const plantsByCols = Object.groupBy(plantsPositions, ({ row }) => row);
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
}

onMounted(async () => {
  dataPlantsPosition.value = await QuarterService.getPlants(props.quarter.id);
  generatePlantsDisposition(dataPlantsPosition.value);
});
</script>

<style>
table.table-heat-map {
  text-align: center;
  th {
    background-color: #ddd;
    padding: 4px 0;
  }
}
</style>

<template>
  <CardSection
    :header-text="t('field.show.statistics.title')"
    wrapperClass="p-5 grid gap-4"
  >
    <Button
      :label="t('harvest.buttons.change_distribution')"
      @click.prevent="open = true"
    />

    <Dialog v-model:visible="open" modal header="cambiar distribucion de arboles" :style="{ maxWidth: '500px' }">
      <div class="grid gap-4 py-4">
        <div class="grid items-center gap-4">
          <VInput
            id="distributionPlants"
            type="textarea"
            class="min-h-36"
            v-model="distributionPlants"
          />
        </div>
      </div>
      <div class="flex justify-end">
        <Button type="submit" @click="changeDistribution" :label="$t('generics.actions.create')" :loading="loading" />
      </div>
    </Dialog>
    <table class="table-heat-map">
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

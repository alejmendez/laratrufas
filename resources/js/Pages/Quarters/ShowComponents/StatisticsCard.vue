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
const dataHarvests = ref([]);
const open = ref(false);
const loading = ref(false);
const distributionPlants = ref('');
const current_plant = ref({});

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

    const rowData = [];
    for (let j = 0; j < row.length; j++) {
      const ele = row[j];
      if (ele === '' || ele === undefined || data[ele] === undefined) {
        rowData.push('');
        continue;
      }

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
  const plantsByPosition = plantsPositions.filter(a => a.position != null).reduce((acc, curr) => (acc[curr.position] = curr, acc), {});
  const cols = Object.keys(plantsByCols);

  const maxRows = Math.max(
    Object.values(plantsByCols).reduce((acc, cur) => (cur.length > acc ? cur.length : acc), 0),
    plantsPositions.reduce((acc, cur) => {
      const posy = parseInt(cur.position.split(',')[0]);
      return posy > acc ? posy : acc
    }, 0)
  ) + 1;
  const data = [];

  for (let i = 0; i < maxRows; i++) {
    const row = [];
    let j = 0;
    for (const col of cols) {
      const pos = `${i},${j++}`;
      if (!plantsByPosition[pos]) {
        row.push(null);
        continue;
      }
      const plant = plantsByPosition[pos];
      plant.number = plant.code;

      const numbers = plant.code.match(/\d+/g);
      plant.position = numbers[numbers.length - 1];
      let scale = 0;
      if (plant.data) {
        const harvestDetails = Object.values(plant.data);
        const scales = harvestDetails.map(detail => detail.map(d => d.scale)).flat();
        scale = (scales.reduce((a, b) => a + b, 0) / scales.length).toFixed(2);
      }

      plant.scale = scale;
      plant.color = generarColorPorPorcentaje(scale);

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

function generarColorPorPorcentaje(porcentaje, colorFin = '#F06F38') {
    // Aseguramos que el porcentaje esté entre 0 y 100
    porcentaje = Math.max(0, Math.min(100, porcentaje));

    // Color blanco (RGB)
    const colorInicio = { r: 255, g: 255, b: 255 };

    // Convierte el color final hexadecimal a RGB
    const hexToRgb = (hex) => {
        const bigint = parseInt(hex.slice(1), 16);
        return {
            r: (bigint >> 16) & 255,
            g: (bigint >> 8) & 255,
            b: bigint & 255,
        };
    };

    const colorFinal = hexToRgb(colorFin);

    // Interpolación lineal entre dos valores
    const interpolate = (start, end, factor) => Math.round(start + (end - start) * factor);

    const factor = porcentaje / 100;

    const r = interpolate(colorInicio.r, colorFinal.r, factor);
    const g = interpolate(colorInicio.g, colorFinal.g, factor);
    const b = interpolate(colorInicio.b, colorFinal.b, factor);

    // Convierte de nuevo a formato hexadecimal
    const rgbToHex = (r, g, b) => `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;

    return rgbToHex(r, g, b);
}

function getHarvestById(id) {
  return dataHarvests.value.find(a => a.id === id)
}

function getHarvestDetailFromPlant(plant) {
  if (!plant || !plant?.data) {
    return [];
  }
  return Object.values(plant.data).flat();
}

onMounted(async () => {
  const response = await QuarterService.getPlants(props.quarter.id);
  dataPlantsPosition.value = response.plants;
  dataHarvests.value = response.harvests;
  generatePlantsDisposition(dataPlantsPosition.value);
});
</script>

<style scoped>
table {
  text-align: center;
}
table thead tr th {
  background-color: #ddd;
  padding: 0;
  font-weight: normal;
  font-size: 10px;
}

table tbody tr td {
  height: 15px;
  width: 35px;
  line-height: 0.5;
  background-color: #f6f6f6;
  cursor: pointer;
}
</style>

<template>
  <CardSection :header-text="t('field.show.statistics.title')" wrapperClass="p-5 grid gap-4">
    <div>
      <Button :label="t('harvest.buttons.change_distribution')" @click.prevent="open = true" />
      <Dialog v-model:visible="open" modal header="cambiar distribucion de arboles" :style="{ maxWidth: '500px' }">
        <div class="grid gap-4 py-4">
          <div class="grid items-center gap-4">
            <VInput id="distributionPlants" type="textarea" class="min-h-36" v-model="distributionPlants" />
          </div>
        </div>
        <div class="flex justify-end">
          <Button type="submit" @click="changeDistribution" :label="$t('generics.actions.create')" :loading="loading" />
        </div>
      </Dialog>
    </div>
    <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-1 gap-4">
      <table class="table-heat-map lg:col-span-3 md:col-span-2">
        <thead>
          <tr>
            <th v-for="col in tableCols" v-text="col" />
          </tr>
        </thead>
        <tbody>
          <tr v-for="plantRow in plants">
            <td
              v-for="plant in plantRow"
              v-html="'&nbsp;'"
              :style="{
                backgroundColor: plant?.color,
                border: plant?.code ? 'solid 1px #ccc' : '',
                borderLeft: plant?.code ? 'solid 1px #ccc' : 'solid 1px #ddd',
              }"
              v-tooltip.top="plant?.code"
              @click="current_plant = plant?.code ? plant : current_plant"
            />
          </tr>
        </tbody>
      </table>
      <div v-if="current_plant?.code">
        <div class="text-xl">{{ current_plant.code }}</div>
        <div class="">Valor: {{ current_plant.scale }} %</div>
        <div class="">Hilera: {{ current_plant.row }}</div>
        <div class="">
          <ul>
            <li v-for="harvest_details in getHarvestDetailFromPlant(current_plant)">
              Semana: {{ getHarvestById(harvest_details.harvest_id)?.week }} {{ getHarvestById(harvest_details.harvest_id)?.batch }}
              Peso: {{ harvest_details.weight }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </CardSection>
</template>

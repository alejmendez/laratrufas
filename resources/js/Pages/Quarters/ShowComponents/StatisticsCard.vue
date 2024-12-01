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
const detail_current_plant = ref({});

const processDistribution = (distribution) =>
  distribution
    .split('\n')
    .filter((row) => row.trim())
    .map((row) => row.split('\t'));

const changeDistribution = () => {
  const distribution = processDistribution(distributionPlants.value);
  const data = Object.fromEntries(toRaw(dataPlantsPosition.value).map((item) => [item.code, item]));

  const distributionData = [];
  const dataToSave = [];

  for (let i = 0; i < distribution.length; i++) {
    const row = distribution[i];
    if (row.length !== distribution[0].length) {
      console.error('Invalid row length');
      return;
    }

    const rowData = row.map((ele, j) => {
      const plant = data[ele];
      if (plant) dataToSave.push([ele, i, j]);
      return plant || '';
    });

    distributionData.push(rowData);
  }

  QuarterService.updatePlantsPosition(props.quarter.id, dataToSave);
  plants.value = distributionData;
};

const generatePlantsDispositionWithPosition = (dataPlants) => {
  const plantsByPosition = Object.fromEntries(dataPlants.filter((p) => p.position).map((p) => [p.position, p]));
  const plantsByCols = Object.groupBy(dataPlants, (p) => p.row);
  const cols = Object.keys(plantsByCols);

  const maxRows =
    Math.max(
      ...dataPlants.map((p) => parseInt(p.position?.split(',')[0], 10) || 0),
      Object.values(plantsByCols).reduce((max, col) => Math.max(max, col.length), 0),
    ) + 1;

  const data = Array.from({ length: maxRows }, (_, i) =>
    cols.map((_, j) => {
      const pos = `${i},${j}`;
      const plant = plantsByPosition[pos];
      if (plant) {
        plant.number = plant.code;
        const [_, position] = plant.code.match(/\d+/g);
        plant.position = position;
        plant.color = generarColorPorPorcentaje(plant.scale);
      }
      return plant || null;
    }),
  );

  tableCols.value = cols;
  plants.value = data;
};

const generarColorPorPorcentaje = (porcentaje, colorFin = '#008FFB') => {
  const colorInicio = { r: 246, g: 246, b: 246 };
  const hexToRgb = (hex) => {
    const bigint = parseInt(hex.slice(1), 16);
    return { r: (bigint >> 16) & 246, g: (bigint >> 8) & 246, b: bigint & 246 };
  };

  const colorFinal = hexToRgb(colorFin);
  const factor = Math.max(0, Math.min(100, porcentaje)) / 100;
  const interpolate = (start, end) => Math.round(start + (end - start) * factor);

  const r = interpolate(colorInicio.r, colorFinal.r);
  const g = interpolate(colorInicio.g, colorFinal.g);
  const b = interpolate(colorInicio.b, colorFinal.b);

  return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;
};

const getHarvestById = (id) => dataHarvests.value.find((harvest) => harvest.id === id);

const getHarvestDetailFromPlant = (plant) => {
  return plant?.data ? Object.values(plant.data).flat() : [];
};

const setCurrentPlant = (plant) => {
  current_plant.value = plant?.code ? plant : current_plant.value;
  detail_current_plant.value = getHarvestDetailFromPlant(current_plant.value);
};

onMounted(async () => {
  const { plants: plantData, harvests } = await QuarterService.getPlants(props.quarter.id);
  dataPlantsPosition.value = plantData;
  dataHarvests.value = harvests;
  generatePlantsDispositionWithPosition(plantData);
});
</script>

<style scoped>
table {
  text-align: center;
  border: solid 10px var(--p-neutral-300);
}
table thead tr th {
  background-color: var(--p-zinc-300);
  padding: 0;
  font-weight: normal;
  font-size: 10px;
}

table tbody tr td {
  height: 15px;
  width: 35px;
  line-height: 0.5;
  background-color: var(--p-neutral-300);
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
            <th v-for="col in tableCols" :key="col" v-text="col" />
          </tr>
        </thead>
        <tbody>
          <tr v-for="plantRow in plants" :key="plantRow">
            <td
              v-for="plant in plantRow"
              :key="plant?.code || 'empty'"
              v-html="'&nbsp;'"
              :style="{
                backgroundColor: plant?.color,
                border: plant?.code ? 'solid 1px #ccc' : '',
                borderLeft: plant?.code ? 'solid 1px #ccc' : 'solid 1px #ddd',
              }"
              v-tooltip.top="plant?.code"
              @click="setCurrentPlant(plant)"
            />
          </tr>
        </tbody>
      </table>
      <div v-if="current_plant?.code">
        <div class="text-xl">{{ current_plant.code }}</div>
        <div>Total cosecha (grs).: {{ detail_current_plant.reduce((a, b) => a + b.weight, 0) }}</div>
        <div>Unidades: {{ detail_current_plant.length }}</div>
        <div>
          <Link :href="route('plants.show', current_plant.id)">
            Ir a ficha de planta <font-awesome-icon :icon="['fas', 'up-right-from-square']" />
          </Link>
        </div>
      </div>
    </div>
  </CardSection>
</template>

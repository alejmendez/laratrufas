<script setup>
const props = defineProps({
  field: Object,
  harvest_data: Object,
  task_data: Object,
});

const task_data = props.task_data;

const percent_pending_tasks = getPorcent(task_data.tasks_totals, task_data.pending_tasks);
const percent_tasks_in_progress = getPorcent(task_data.tasks_totals, task_data.tasks_in_progress);

function getPorcent(total, num) {
  if (total === 0) {
    return 100;
  }

  return num * 100 / total;
}
</script>

<template>
  <section class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-4">
    <div class="mt-5 p-5 rounded-xl bg-white shadow-sm border border-gray-200 ">
      <div class="text-gray-500 font-bold">Ultima cosecha:</div>
      <div class="text-3xl font-bold mb-2">{{ harvest_data.total_weight_of_last_harvest }} kgs</div>
      <div class="text-sm">
        Promedio: {{ harvest_data.average_weight_per_plant }} gr por planta
      </div>
    </div>
    <div class="mt-5 p-5 rounded-xl bg-white shadow-sm border border-gray-200 ">
      <div class="text-gray-500 font-bold">Cosecha {{ harvest_data.years_variation[1] }} - {{ harvest_data.years_variation[0] }}</div>
      <div class="text-3xl font-bold mb-2">{{ harvest_data.variation_between_harvests }} %</div>
      <div
        class="text-sm text-green-500"
        :class="{
          'text-green-500': harvest_data.variation_between_harvests >= 0,
          'text-red-500': harvest_data.variation_between_harvests < 0,
        }"
      >
        {{ harvest_data.variation_between_harvests >= 0 ? 'Incremento' : 'Disminución'}}
        <font-awesome-icon :icon="['fas', harvest_data.variation_between_harvests >= 0 ? 'arrow-up-long' : 'arrow-down-long']" />
      </div>
    </div>

    <div class="mt-5 p-5 rounded-xl bg-[#EF5F28] shadow-sm text-[#F8F9FA]">
      <span class="text-3xl font-bold mr-2">{{ task_data.pending_tasks }}</span> Tareas Pendientes
      <div class="flex justify-between mt-3">
        <div>{{ task_data.tasks_totals }} Tareas</div>
        <div>{{ percent_pending_tasks }}%</div>
      </div>
      <div class="h-2 bg-[#F4AC91] mt-2 rounded">
        <div class="bg-[#F8F9FA] h-full rounded" :style="`width: ${percent_pending_tasks}%;`"></div>
      </div>
    </div>

    <div class="mt-5 p-5 rounded-xl bg-[#F9F9FF] shadow-sm text-[#0B0B0E] border-[#0B0B0E] border">
      <span class="text-3xl font-bold mr-2">{{ task_data.tasks_in_progress }}</span> Tareas en curso
      <div class="flex justify-between mt-3">
        <div>{{ task_data.tasks_totals }} Tareas</div>
        <div>{{ percent_tasks_in_progress }}%</div>
      </div>
      <div class="h-2 bg-[#B3B7BE] mt-2 rounded">
        <div class="bg-[#6C757D] h-full rounded" :style="`width: ${percent_tasks_in_progress}%;`"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  field: Object,
});

const field = props.field.data;
</script>

<template>
  <div class="lg:col-span-3 rounded-xl card-section">
    <header class="flex items-center overflow-hidden border-b dark:border-gray-800">
      <h3 class="px-4 py-3 text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">
        Campo: {{ field.name }}
      </h3>
    </header>
    <div class="p-5 grid grid-cols-4 gap-4">
      <div class="col-span-3">
        <img :src="field.blueprint" class="w-full" alt="">
      </div>
      <div>
        <div class="text-gray-500 dark:text-gray-100 font-bold mb-3">Ciclo: Siembra</div>
        <div class="min-h-10">
          <div class="w-8 h-8 px-2 py-1 me-2 rounded text-green-500 float-left" title="Ubicación">
            <font-awesome-icon :icon="['fas', 'location-dot']" />
          </div>
          <div class="pt-1 truncate" :title="field.location">
            {{ field.location }}
          </div>
        </div>
        <div class="min-h-10" title="Tamaño">
          <div class="w-8 h-8 px-2 py-1 me-2 rounded text-red-500 float-left" style="padding-left: 0.30rem; padding-top: 0.15rem;">
            <span class="text-xs">HAS</span>
          </div>
          <div class="pt-1">
            {{ Math.round((parseFloat(field.size) + Number.EPSILON) * 10) / 10 }}
          </div>
        </div>
        <div class="min-h-10" title="Cantidad de Cuarteles">
          <div class="w-8 h-8 px-2 py-1 me-2 rounded text-yellow-500 float-left">
            <font-awesome-icon :icon="['fas', 'vector-square']" />
          </div>
          <div class="pt-1">
            {{ field.quarters_count }}
          </div>
        </div>
        <div class="min-h-10" title="Cantidad de Arboles">
          <div class="w-8 h-8 px-2 py-1 me-2 rounded text-yellow-500 float-left">
            <font-awesome-icon :icon="['fas', 'tree']" />
          </div>
          <div class="pt-1">
            {{ field.plants_count }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

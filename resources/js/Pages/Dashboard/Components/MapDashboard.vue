<script setup>
import { useI18n } from 'vue-i18n';

const props = defineProps({});

const { t } = useI18n();
</script>

<template>
  <div class="lg:col-span-3 rounded-xl bg-white shadow-sm border border-gray-200">
    <header class="flex items-center overflow-hidden border-b">
      <h3 class="px-4 py-3 text-base font-semibold leading-6 text-gray-950">
        Campo: Pricilla
      </h3>
    </header>
    <div class="p-5 grid grid-cols-4 gap-4">
      <div class="col-span-3">
        <img src="https://placehold.co/575x356" class="w-full" alt="">
      </div>
      <div>
        <div class="text-gray-500 font-bold">Ciclo: Siembra</div>
        <div class="h-10">
          <div class="border border-gray-200 w-8 h-8 px-2 py-1 me-2 rounded text-green-500 float-left">
            <font-awesome-icon :icon="['fas', 'location-dot']" />
          </div>
          <div class="pt-1">
            00.000.000.00
          </div>
        </div>
        <div class="h-10">
          <div class="border border-gray-200 w-8 h-8 px-2 py-1 me-2 rounded text-red-500 float-left">
            <span>m</span><sup>2</sup>
          </div>
          <div class="pt-1">
            590.936
          </div>
        </div>
        <div class="h-10">
          <div class="border border-gray-200 w-8 h-8 px-2 py-1 me-2 rounded text-yellow-500 float-left">
            <font-awesome-icon :icon="['fas', 'vector-square']" />
          </div>
          <div class="pt-1">
            4
          </div>
        </div>
        <div class="h-10">
          <div class="border border-gray-200 w-8 h-8 px-2 py-1 me-2 rounded text-yellow-500 float-left">
            <font-awesome-icon :icon="['fas', 'tree']" />
          </div>
          <div class="pt-1">
            154
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

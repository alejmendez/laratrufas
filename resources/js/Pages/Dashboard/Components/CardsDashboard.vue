<script setup>
import { useI18n } from 'vue-i18n'

const props = defineProps({
  tasks: Array,
})

const { t } = useI18n()
</script>

<template>
  <section class="grid grid-cols-4 gap-4">
    <div class="mt-5 p-5 rounded-xl bg-orange-800/70 shadow-sm text-white">
      <span class="text-2xl">2</span> Tareas Pendientes
      <div class="flex justify-between mt-3">
        <div>10 Tareas</div>
        <div>80%</div>
      </div>
      <div class="h-2 bg-white/50 mt-2 rounded">
        <div class="w-[80%] bg-white h-full rounded"></div>
      </div>
    </div>
    <div class="mt-5 p-5 rounded-xl bg-white shadow-sm border border-gray-200 ">
      <div class="text-gray-500 font-bold">Ganancia</div>
      <div class="text-3xl font-bold">2.345$</div>
      <div class="text-sm text-green-500">
        32 Incremento
        <font-awesome-icon :icon="['fas', 'arrow-up-long']" />
      </div>
    </div>
    <div class="mt-5 p-5 rounded-xl bg-white shadow-sm border border-gray-200 ">
      <div class="text-gray-500 font-bold">Cosecha</div>
      <div class="text-3xl font-bold">2.345</div>
      <div class="text-sm text-green-500">
        32 Incremento
        <font-awesome-icon :icon="['fas', 'arrow-up-long']" />
      </div>
    </div>
    <div class="mt-5 p-5 rounded-xl bg-white shadow-sm border border-gray-200 ">
      <div class="text-gray-500 font-bold">
        Alertas
        <span class="inline-flex items-center rounded-md bg-red-800 px-1 py-0 text-xs text-white ring-1 ring-inset ring-gray-500/10">3</span>
      </div>
    </div>
  </section>
</template>

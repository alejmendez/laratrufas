<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  elements: Array
})
</script>

<template>
  <div class="breadcrumbs py-4 flex items-center flex-wrap text-gray-500 text-sm font-medium">
    <ul class="flex items-center">
      <li class="inline-flex items-center" v-for="(ele, index) in props.elements" :key="index">
        <Link :href="route(ele.to)" class="text-gray-600 hover:text-blue-500" v-if="ele.to">
          {{ ele.text }}
        </Link>
        <div v-else class="text-gray-600">
          {{ ele.text }}
        </div>
        <font-awesome-icon
          :icon="['fa', 'chevron-right']"
          class="w-5 fill-current mx-2 text-gray-400"
          v-if="index != props.elements.length - 1"
        />
      </li>
    </ul>
  </div>
</template>

<script setup>
import { useAttrs } from 'vue';
import { Link } from '@inertiajs/vue3';
const attrs = useAttrs();

const props = defineProps({
  link: String,
  text: String,
  icon: {
    type: String,
    default: 'fa-solid fa-circle',
  },
});
</script>

<template>
  <Link
    v-bind="attrs"
    :href="props.link"
    class="menu-element inline-flex relative items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 hover:bg-gray-200 hover:text-gray-800 transition duration-400 ease-in-out"
  >
    <FontAwesomeIcon :icon="props.icon" class="mr-2" />
    {{ props.text }}
  </Link>
</template>

<style>
.menu-element .fa-circle {
  font-size: 6px;
}
</style>

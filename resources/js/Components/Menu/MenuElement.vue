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
  active: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <Link
    v-bind="attrs"
    :href="props.link"
    class="menu-element inline-flex relative items-center py-[10px] px-[10px] w-full text-sm font-medium text-[#7B849C] rounded-md border-gray-200 hover:bg-[#FFEBE2] hover:text-[#ED3900] transition duration-400 ease-in-out"
    :class="{ active: props.active }"
  >
    <div class="w-[25px] mr-2 flex justify-center">
      <FontAwesomeIcon :icon="props.icon" class="text-xl" />
    </div>
    {{ props.text }}
  </Link>
</template>

<style>
.menu-element .fa-circle {
  font-size: 6px;
}
</style>

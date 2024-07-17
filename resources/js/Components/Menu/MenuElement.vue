<script setup>
import { useAttrs } from 'vue';
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
    class="menu-element inline-flex relative items-center py-[10px] w-full text-sm font-medium text-[#F8F9FA] rounded-md border-gray-200 transition duration-400 ease-in-out"
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

<script setup>
import { useAttrs } from 'vue';
import { Link } from '@inertiajs/vue3';

import { useSideBarStore } from '@/Stores/sidebar.js';

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

const sideBarStore = useSideBarStore();
</script>

<template>
  <Link
    v-bind="attrs"
    :href="props.link"
    class="menu-element"
    :class="{ active: props.active }"
    @click="sideBarStore.close"
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

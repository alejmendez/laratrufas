<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const root = ref(null);

const showDropDown = ref(false);

const toggleDrop = () => {
  showDropDown.value = !showDropDown.value;
};

const closeDropDown = (e) => {
  if (!root.value.contains(e.target)) {
    showDropDown.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', closeDropDown);
});

onUnmounted(() => {
  document.removeEventListener('click', closeDropDown);
});
</script>

<template>
  <div class="relative me-3" ref="root">
    <div
      class="text-lg w-[43px] h-[43px] hover:bg-gray-300 pt-2 ps-3 rounded-full transition-all ease-out duration-300"
      @click="toggleDrop"
    >
      <font-awesome-icon :icon="['far', 'bell']" />
      <span class="text-xs bg-orange-700 text-white rounded-full px-1 py-0 absolute top-2 right-2">3</span>
    </div>
  </div>
  <div
    v-show="showDropDown"
    class="absolute right-[60px] z-10 mt-12 w-96 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    tabindex="-1"
  >
    <div class="font-semibold text-left block px-4 py-2">
      <div>
        <font-awesome-icon :icon="['fas', 'triangle-exclamation']" class="text-orange-700" />
        Riego con fertilizantes cambió de estado.
      </div>
    </div>
  </div>
</template>

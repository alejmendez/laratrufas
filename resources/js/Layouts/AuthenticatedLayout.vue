<script setup>
import { ref } from 'vue';

import SideBarLeft from '@/Components/Menu/SideBarLeft.vue';
import MenuUser from '@/Components/Menu/MenuUser.vue';

const showSide = ref(true);

const toggleSideBar = () => {
  showSide.value = !showSide.value;
};
</script>

<template>
  <div class="w-full min-h-screen flex bg-gray-50 font-normal text-gray-950 antialiased">
    <div
      class="min-h-screen transition-all duration-200 ease-out z-10 border-r bg-gray-100 "
      :class="{ 'w-[320px] opacity-100': showSide, 'w-[0px] opacity-0': !showSide }"
    >
      <div class="flex justify-start items-center h-[64px]">
        <div class="px-[20px]">
          <h3 class="font-bold text-xl w-[230px]">SW Agricola</h3>
        </div>
      </div>
      <SideBarLeft />
    </div>
    <div class="w-full min-h-screen z-20">
      <div class="flex items-center w-full h-[64px] border-b px-[20px] py-[10px] z-30">
        <div
          class="cursor-pointer rounded outline-none transition duration-75 text-gray-400 hover:text-gray-500 focus-visible:ring-primary-600 border border-gray-400 px-3 py-1"
          @click="toggleSideBar"
        >
          <FontAwesomeIcon icon="fa-solid fa-bars" />
        </div>

        <div class="w-[calc(100%-30px)] flex justify-end">
          <MenuUser />
        </div>
      </div>
      <div class="min-h-[calc(100vh-64px)] w-full bg-gray-50 pb-5">
        <main class="py-[10px] px-[25px] min-h-screen">
          <slot></slot>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { storeToRefs } from 'pinia';
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';

import SideBarLeft from '@/Components/Menu/SideBarLeft.vue';
import MenuUser from '@/Components/Menu/MenuUser.vue';
import { useSideBarStore } from '@/Stores/sidebar.js';

const sideBarStore = useSideBarStore();
const { show } = storeToRefs(sideBarStore);
</script>

<template>
  <div class="flex items-center w-full h-[64px] bg-[#F8F9FA] dark:bg-[#2F3349] text-white px-[20px] py-[10px] z-30">
    <div class="w-[230px]">
      <div
        class="w-[36px] inline rounded outline-none transition duration-75 text-[color:--p-primary-500] hover:text-[color:--p-primary-700] focus-visible:ring-primary-600 border border-[color:--p-primary-500] hover:border-[color:--p-primary-700] px-3 py-1"
        @click="sideBarStore.toggle"
      >
        <FontAwesomeIcon icon="fa-solid fa-bars" />
      </div>
    </div>

    <div class="w-[calc(100%-30px)] flex justify-end">
      <MenuUser />
    </div>
  </div>
  <div class="w-full flex font-normal text-gray-900 antialiased">
    <div
      class="flex-none transition-all duration-200 ease-out z-10 bg-[#F8F9FA] dark:bg-[#2F3349] text-white"
      :class="{ 'lg:w-[320px] lg:opacity-100 w-[0px] opacity-0': !show, 'lg:w-[0px] lg:opacity-0 w-full opacity-100': show }"
    >
      <h3 class="font-bold text-xl inline ms-6 mt-4">
        <span class="text-[color:--p-primary-color]">SW </span>
        <span class="text-gray-900 dark:text-gray-50">Agricola</span>
      </h3>
      <SideBarLeft />
    </div>
    <div class="grow z-20 bg-[#F0F2F5] dark:bg-[#1D2132]">
      <div class="min-h-[calc(100vh-64px)] pb-5">
        <main class="py-[10px] px-[25px] w-full">
          <Toast />
          <slot></slot>
        </main>
      </div>
    </div>
  </div>
  <ConfirmDialog></ConfirmDialog>
</template>

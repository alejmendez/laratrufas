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
  <div class="flex items-center w-full h-[64px] bg-[#0F172A] text-white px-[20px] py-[10px] z-30">
    <div class="w-[230px]">
      <h3 class="font-bold text-xl hidden md:inline me-3">
        SW Agricola
      </h3>
      <div
        class="w-[36px] inline rounded outline-none transition duration-75 text-white hover:text-[#DD6633] focus-visible:ring-primary-600 border border-white hover:border-[#DD6633] px-3 py-1"
        @click="sideBarStore.toggle"
      >
        <FontAwesomeIcon icon="fa-solid fa-bars" />
      </div>
    </div>

    <div class="w-[calc(100%-30px)] flex justify-end">
      <MenuUser />
    </div>
  </div>
  <div class="w-full flex bg-[#F0F2F5] font-normal text-gray-950 antialiased">
    <div
      class="flex-none transition-all duration-200 ease-out z-10 border-r bg-[#0F172A] text-white"
      :class="{ 'lg:w-[320px] lg:opacity-100 w-[0px] opacity-0': !show, 'lg:w-[0px] lg:opacity-0 w-full opacity-100': show }"
    >
      <SideBarLeft />
    </div>
    <div class="grow z-20">
      <div class="min-h-[calc(100vh-64px)] bg-[#F0F2F5] pb-5">
        <main class="py-[10px] px-[25px] w-full">
          <slot></slot>
        </main>
      </div>
    </div>
  </div>
  <ConfirmDialog></ConfirmDialog>
  <Toast />
</template>

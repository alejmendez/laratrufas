<script setup>
import { usePage } from '@inertiajs/vue3';

import MenuGroup from './MenuGroup.vue';
import MenuElement from './MenuElement.vue';
import { menuElements } from '@/Services/Menu.js';

const page = usePage();
const currentComponent = page.component;

const menuData = menuElements(currentComponent);
const initialState = Array(menuData.length).fill(true);
const menuState = JSON.parse(localStorage.getItem('menu-state')) || initialState;

const openHandler = (e, index) => {
  const menuState = JSON.parse(localStorage.getItem('menu-state')) || initialState;
  const newState = [...menuState];
  newState[index] = e.value;
  localStorage.setItem('menu-state', JSON.stringify(newState));
};
</script>
<template>
  <aside class="min-h-[calc(100vh-50px)] px-[20px]">
    <div class="flex flex-col justify-between space-y-[10px] mt-3 mb-10">
      <div v-for="(menu, index) in menuData" :key="index">
        <div v-if="menu.link">
          <MenuElement
            :link="menu.link"
            :text="$t(menu.text)"
            :active="menu.active"
            :icon="menu.icon"
          />
        </div>
        <div v-else>
          <MenuGroup
            :text="$t(menu.text)"
            :elements="menu.children"
            :open="menuState[index]"
            @open="openHandler($event, index)"
          />
        </div>
      </div>
    </div>
  </aside>
</template>

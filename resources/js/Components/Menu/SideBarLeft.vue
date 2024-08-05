<script setup>
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';

import MenuGroup from './MenuGroup.vue';
import MenuElement from './MenuElement.vue';
import { menuElements } from '@/Services/Menu.js';

const page = usePage();
const currentComponent = page.component;
const userRoles = page.props.auth.user.roles;

const menuData = menuElements(currentComponent, userRoles);
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
      <MenuElement
        :link="route('dashboard')"
        :text="$t('menu.dashboard')"
        :active="page.component.startsWith('Dashboard')"
        icon="fa-solid fa-square-poll-vertical"
      />

      <MenuGroup
        v-for="(menu, index) in menuData"
        :key="index"
        :text="$t(menu.text)"
        :elements="menu.children"
        :open="menuState[index]"
        @open="openHandler($event, index)"
      />
    </div>
  </aside>
</template>

<script setup>
import MenuGroup from './MenuGroup.vue';
import MenuElement from './MenuElement.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const menuData = [
  {
    text: t('menu.management'),
    children: [
      { link: route('fields.index'), text: t('menu.fields') },
      { link: route('quarters.index'), text: t('menu.quarters') },
      { link: route('plants.index'), text: t('menu.plants') },
    ],
  },
  {
    text: t('menu.harvest_management'),
    children: [
      { link: route('users.index'), text: t('menu.harvest'), icon: 'fa-solid fa-person-digging' },
      { link: route('users.index'), text: t('menu.batch'), icon: 'fa-solid fa-person-digging' },
    ],
  },
  {
    text: t('menu.task_management'),
    children: [{ link: route('users.index'), text: t('menu.tasks'), icon: 'fa-solid fa-person-digging' }],
  },
  {
    text: t('menu.records'),
    children: [
      { link: route('users.index'), text: t('menu.machineries'), icon: 'fa-solid fa-person-digging' },
      { link: route('users.index'), text: t('menu.tools'), icon: 'fa-solid fa-person-digging' },
      { link: route('users.index'), text: t('menu.suppliers'), icon: 'fa-solid fa-person-digging' },
    ],
  },
  {
    text: t('menu.settings'),
    children: [
      { link: route('users.index'), text: t('menu.users') },
      { link: route('dogs.index'), text: t('menu.dogs') },
      { link: route('users.index'), text: t('menu.alerts'), icon: 'fa-solid fa-person-digging' },
      { link: route('users.index'), text: t('menu.bulk_uploads'), icon: 'fa-solid fa-person-digging' },
    ],
  },
];
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
  <aside class="min-h-[calc(100vh-64px)] py-[20px]">
    <div class="flex flex-col justify-between h-full px-[20px] space-y-[10px]">
      <div class="flex flex-col justify-between space-y-[10px]">
        <MenuElement :link="route('dashboard')" :text="t('menu.dashboard')" />

        <MenuGroup
          v-for="(menu, index) in menuData"
          :key="index"
          :text="menu.text"
          :elements="menu.children"
          :open="menuState[index]"
          @open="openHandler($event, index)"
        />
      </div>
    </div>
  </aside>
</template>

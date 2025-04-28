<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';

import MenuElement from './MenuElement.vue';
import { menuElements } from '@Core/Services/Menu.js';

const page = usePage();
const currentComponent = page.component;

const menuData = menuElements(currentComponent);
const menuState = ref(menuData.map((_, index) => index));
const initialState = Array(menuData.length).fill(true);
// const menuState = JSON.parse(localStorage.getItem('menu-state')) || initialState;

const openHandler = (e, index) => {
  console.log(e, index);
  // const menuState = JSON.parse(localStorage.getItem('menu-state')) || initialState;
  // const newState = [...menuState];
  // newState[index] = e.value;
  // localStorage.setItem('menu-state', JSON.stringify(newState));
};

watch(menuState, (newVal) => {
  console.log(newVal);
});
</script>
<template>
  <aside class="aside-left-menu min-h-[calc(100vh-50px)] ps-[15px] pe-[20px]">
    <div class="flex flex-col justify-between space-y-[10px] mt-3 mb-10">
      <Accordion :value="menuState" multiple :update:value="openHandler">
        <AccordionPanel :value="index" v-for="(menu, index) in menuData" :key="index">
          <div v-if="menu.link">
            <MenuElement
              :link="menu.link"
              :text="menu.text"
              :icon="menu.icon"
              :active="menu.active"
            />
          </div>
          <div v-else>
            <AccordionHeader>{{ menu.text }}</AccordionHeader>
            <AccordionContent>
              <MenuElement
                v-for="(ele, indexChild) in menu.children"
                :key="indexChild"
                :link="ele.link"
                :text="ele.text"
                :icon="ele.icon"
                :active="ele.active"
              />
            </AccordionContent>
          </div>
        </AccordionPanel>
      </Accordion>
    </div>
  </aside>
</template>

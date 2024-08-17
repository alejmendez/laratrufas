import { ref } from 'vue';
import { defineStore } from 'pinia';

export const useSideBarStore = defineStore('sideBar', () => {
  const show = ref((localStorage.getItem('showSideBar') || '1') === '1');

  function toggle() {
    update(!show.value);
  }

  function open() {
    update(true);
  }

  function close() {
    update(false);
  }

  function update(status) {
    show.value = status;
    localStorage.setItem('showSideBar', show.value ? '1' : '0');
  }

  return { show, toggle, open, close };
});

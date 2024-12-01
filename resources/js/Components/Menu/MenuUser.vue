<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePreset } from '@primevue/themes';
import SelectButton from 'primevue/selectbutton';

import Presents from '@/Libs/PrimePresents';

const darkModeValue = ref(null);
const darkMode = ref([
  { icon: 'pi pi-moon', value: 'dark' },
  { icon: 'pi pi-sun', value: 'light' },
]);

import MenuNotification from './MenuNotification.vue';

const root = ref(null);

const showDropDown = ref(false);

const themes = [
  { name: 'Apple', class: 'bg-green-600' },
  { name: 'Cobalt', class: 'bg-blue-800' },
  { name: 'DodgerBlue', class: 'bg-blue-500' },
  { name: 'Vulcan', class: 'bg-zinc-900' },
  { name: 'CarrotOrange', class: 'bg-amber-500' },
];

const toggleDrop = () => {
  showDropDown.value = !showDropDown.value;
};

const closeDropDown = (e) => {
  if (!root.value.contains(e.target)) {
    showDropDown.value = false;
  }
};

const toggleTheme = (isDark) => {
  localStorage.themeType = isDark ? 'dark' : 'light';
  darkModeValue.value = darkMode.value[isDark ? 0 : 1];
  document.documentElement.classList.toggle('dark', isDark);
};

const changeHandlerDarkMode = () => {
  toggleTheme(darkModeValue.value.value === 'dark');
};

if (localStorage.themeType === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
  toggleTheme(true);
} else {
  toggleTheme(false);
}

const setTheme = (theme) => {
  localStorage.setItem('theme', theme.name);
  usePreset(Presents[theme.name]);
};

onMounted(() => {
  document.addEventListener('click', closeDropDown);
});

onUnmounted(() => {
  document.removeEventListener('click', closeDropDown);
});
</script>

<style>
.select-mode .p-selectbutton .p-togglebutton {
  width: 50%;
}
</style>

<template>
  <MenuNotification />

  <div class="w-[40px]" ref="root">
    <!-- User login -->
    <div class="flex items-center justify-start space-x-4" @click="toggleDrop">
      <img class="w-10 h-10 rounded-full border-2 border-gray-50" :src="$page.props.auth.user.avatar_url || 'https://i.pravatar.cc/150?img=3'" alt="" />
    </div>
    <!-- Drop down -->
    <div
      v-show="showDropDown"
      class="absolute right-[10px] z-50 mt-2 w-56 origin-top-right rounded-md bg-white dark:bg-slate-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      role="menu"
      aria-orientation="vertical"
      aria-labelledby="menu-button"
      tabindex="-1"
    >
      <div class="text-black dark:text-gray-100 font-semibold text-left block px-4 py-2">
        <div>{{ $page.props.auth.user.full_name }}</div>
      </div>
      <div class="text-black font-semibold text-left block px-4 py-2 select-mode">
        <SelectButton
          class="w-full"
          v-model="darkModeValue"
          optionLabel="value"
          dataKey="value"
          aria-labelledby="custom"
          :options="darkMode"
          :allowEmpty="false"
          @change="changeHandlerDarkMode"
        >
          <template #option="slotProps">
            <i :class="slotProps.option.icon"></i>
          </template>
        </SelectButton>
      </div>
      <div class="px-4 py-2 mb-4">
        <div :class="`${theme.class} rounded-full w-4 h-4 float-left me-2`" v-for="theme in themes" @click="setTheme(theme)"></div>
      </div>
      <div class="py-1 text-left" role="none">
        <Link :href="route('profile.edit')" class="text-gray-700 dark:text-gray-100 block px-4 py-2"> {{ $t('menu.top.profile') }} </Link>
        <Link :href="route('logout')" method="post" as="button" class="text-gray-700 dark:text-gray-100 block px-4 py-2">
            {{ $t('menu.top.logout') }}
        </Link>
      </div>
    </div>
  </div>
</template>

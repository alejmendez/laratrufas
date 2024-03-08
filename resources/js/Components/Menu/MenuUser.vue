<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3';

import MenuNotification from './MenuNotification.vue'

const root = ref(null)

const showDropDown = ref(false)

const toggleDrop = () => {
  showDropDown.value = !showDropDown.value
}

const closeDropDown = (e) => {
  if (!root.value.contains(e.target)) {
    showDropDown.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', closeDropDown)
})

onUnmounted(() => {
  document.removeEventListener('click', closeDropDown)
})
</script>

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
      class="absolute right-[10px] z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      role="menu"
      aria-orientation="vertical"
      aria-labelledby="menu-button"
      tabindex="-1"
    >
      <div class="font-semibold text-left block px-4 py-2">
        <div>{{ $page.props.auth.user.name }}</div>
      </div>
      <div class="py-1 text-left" role="none">
        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
        <Link :href="route('profile.edit')" class="text-gray-700 block px-4 py-2"> Profile </Link>
        <Link :href="route('logout')" method="post" as="button" class="text-gray-700 block px-4 py-2">
            Log Out
        </Link>
      </div>
    </div>
  </div>
</template>

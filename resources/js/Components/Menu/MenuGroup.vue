<script setup>
import { ref } from 'vue'
import MenuElement from './MenuElement.vue'

const props = defineProps({
  text: String,
  elements: Array,
})

const heights = [
  'h-[40px]',
  'h-[80px]',
  'h-[120px]',
  'h-[160px]',
  'h-[200px]',
]

const open = ref(true)
</script>

<template>
  <div>
    <div
      class="cursor-pointer"
      @click="open = !open"
    >
      {{ props.text }}
      <font-awesome-icon
        class="mr-2 float-right transition duration-300"
        :icon="['fas', 'chevron-down']"
        :class="open ? '' : 'rotate-90'"
      />
    </div>

    <div
      class="transition-all ease-out duration-300 overflow-hidden w-full"
      :class="open ? `opacity-100 ${heights[props.elements.length - 1]}` : 'opacity-0 h-0'"
    >
      <template v-for="ele in props.elements" :key="index">
        <MenuElement :link="ele.link" :text="ele.text" />
      </template>
    </div>
  </div>
</template>

<style>
.menu-element .fa-circle {
  font-size: 6px;
}
</style>

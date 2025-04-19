<script setup>
import { ref } from 'vue';
import MenuElement from './MenuElement.vue';

const props = defineProps({
  text: String,
  elements: Array,
  open: Boolean,
});

const emit = defineEmits(['open']);

const heights = ['h-[40px]', 'h-[80px]', 'h-[120px]', 'h-[160px]', 'h-[200px]'];

const open = ref(props.open);

const clickHandler = () => {
  open.value = !open.value;
  emit('open', open);
};
</script>

<template>
  <div>
    <div
      class="menu-group"
      @click="clickHandler"
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
      <MenuElement
        v-for="(ele, index) in props.elements"
        :key="index"
        :link="ele.link"
        :text="$t(ele.text)"
        :icon="ele.icon"
        :active="ele.active"
      />
    </div>
  </div>
</template>

<style>
.menu-element .fa-circle {
  font-size: 6px;
}
</style>

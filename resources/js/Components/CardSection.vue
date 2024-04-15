<script setup>
const props = defineProps({
  headerText: String,
  wrapperClass: {
    type: String,
    default: 'p-6 grid md:grid-cols-2 gap-x-16 gap-y-4 sm:grid-cols-1',
  },
});
</script>

<template>
  <section class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
    <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4" v-if="props.headerText">
      <h3 class="text-base font-semibold leading-6 text-gray-950">
        {{ props.headerText }}
      </h3>
    </header>
    <div class="border-gray-200" :class="{ 'border-t': props.headerText }">
      <div :class="props.wrapperClass" >
        <slot />
      </div>
    </div>
  </section>
</template>

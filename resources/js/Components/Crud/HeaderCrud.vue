<script setup>
import { useSlots } from 'vue'
import BreadCrumbs from '@/Components/Crud/BreadCrumbs.vue'
import { Link } from '@inertiajs/vue3';

const slots = useSlots()

const props = defineProps({
  breadcrumbs: Array,
  title: String,
  links: Array
})
</script>

<template>
  <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <BreadCrumbs :elements="props.breadcrumbs" />

      <h1
        class="ftext-2xl font-bold tracking-tight text-gray-950 sm:text-3xl"
      >
        {{ props.title }}
      </h1>
    </div>

    <div
      class="gap-3 flex flex-wrap items-center justify-start shrink-0 sm:mt-[50px]"
      v-if="props.links"
    >
      <Link
        v-for="link in props.links"
        :key="link.text"
        :href="route(link.to)"
        class="btn btn-primary"
      >
        {{ link.text }}
      </Link>
    </div>

    <div
      class="gap-3 flex flex-wrap items-center justify-start shrink-0 sm:mt-[50px]"
      v-if="slots.header"
    >
      <slot name="header"></slot>
    </div>
  </header>
</template>
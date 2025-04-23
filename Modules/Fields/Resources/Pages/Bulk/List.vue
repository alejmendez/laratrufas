<script setup>
import { trans } from 'laravel-vue-i18n';
import { Link } from '@inertiajs/vue3';
import { can } from '@Auth/Services/Auth';

import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@Core/Components/Crud/HeaderCrud.vue';

const list = [
  {
    to: 'plants.create.bulk',
    icon: ['fas', 'seedling'],
    title: trans('bulk.plants.title'),
    subtitle: trans('bulk.plants.subtitle'),
  },
  {
    to: 'harvests.create.bulk',
    icon: ['fas', 'basket-shopping'],
    title: trans('bulk.harvests.title'),
    subtitle: trans('bulk.harvests.subtitle'),
  },
].filter((ele) => can(ele.to));
</script>

<template>
  <AuthenticatedLayout :title="__('bulk.title')">
    <HeaderCrud
      :title="__('bulk.title')"
    />

    <div class="grid grid-cols-4 gap-x-16 gap-y-4 mt-5">
      <Link
        v-for="ele in list"
        class="px-6 py-3 rounded-xl bg-white dark:bg-[#2F3349] dark:text-gray-200 shadow-sm ring-1 ring-gray-950/5 hover:bg-slate-100 dark:hover:bg-slate-700 hover:drop-shadow transition-all"
        :href="route(ele.to)"
      >
        <div class="text-xl">
          <font-awesome-icon class="me-2" :icon="ele.icon" />
          {{ ele.title }}
        </div>
        <div>{{ ele.subtitle }}</div>
      </Link>
    </div>
  </AuthenticatedLayout>
</template>

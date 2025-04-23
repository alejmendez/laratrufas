<script setup>
import { router } from '@inertiajs/vue3';

const searchHandler = (e) => {
  const url = new URL(window.location.href);
  url.searchParams.set('search', e.target.value);
  router.get(url);
};

const props = defineProps({
  q: String,
});
</script>

<template>
  <div class="flex justify-end px-4 py-3 sm:px-6">
    <div class="relative">
      <label for="inputSearch" class="sr-only">{{ __('generics.tables.search') }} </label>
      <input
        id="inputSearch"
        type="text"
        :placeholder="__('generics.tables.search') + '...'"
        class="block w-64 rounded-lg border py-2 pl-10 pr-4 text-sm focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-400"
        :value="props.q"
        @keyup.enter="searchHandler"
      />
      <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 transform text-gray-400">
        <font-awesome-icon :icon="['fas', 'magnifying-glass']" />
      </span>
    </div>
  </div>
</template>

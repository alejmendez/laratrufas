<script setup>
const props = defineProps({
  meta: Object,
});
</script>

<template>
  <nav class="w-full pagination" v-if="props.meta.total > 0">
    <p>
      {{ $t('generics.tables.pagination.show') }}
      <strong>{{ props.meta.from || 0 }}</strong> -
      <strong>{{ props.meta.to || 0 }}</strong>
      {{ $t('generics.tables.pagination.of') }}
      <strong>{{ props.meta.total }}</strong>
    </p>

    <ul>
      <li v-for="linkPagination in props.meta.links">
        <Link
          :href="linkPagination.url || '#'"
          class="pagination-link"
          :class="{ 'opacity-35': linkPagination.active }"
          v-html="linkPagination.label"
        >
        </Link>
      </li>
    </ul>
  </nav>
</template>

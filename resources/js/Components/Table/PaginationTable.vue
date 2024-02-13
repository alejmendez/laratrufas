<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  meta: Object
})

console.log(props.meta)
</script>

<template>
  <nav class="pagination" v-if="props.meta.total > 0">
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
            @click.prevent="firstPage()"
            v-html="linkPagination.label"
        >
        </Link>
      </li>
    </ul>
  </nav>
</template>

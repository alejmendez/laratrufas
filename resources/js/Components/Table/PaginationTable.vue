<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  from: {
    type: Number,
    default: 1
  },
  to: {
    type: Number,
    default: 1
  },
  total: {
    type: Number,
    default: 1
  },
  current_page: {
    type: Number,
    default: 1
  },
  last_page: {
    type: Number,
    default: 1
  }
})

const emit = defineEmits(['changePage'])

const paginationLimit = 3
const current_page = ref(props.current_page)

const listPages = computed(() => {
  const pages = []
  let startIn = current_page.value - paginationLimit
  let stopIn = current_page.value + paginationLimit
  if (startIn < 1) {
    startIn = 1
  }
  if (stopIn > props.last_page) {
    stopIn = props.last_page
  }

  for (let i = startIn; i <= stopIn; i++) {
    pages.push(i);
  }

  return pages
})

const getPage = (pageNumber) => {
  if (
    current_page.value === pageNumber
    || pageNumber > props.last_page
    || pageNumber < 1
  ) {
    return
  }
  current_page.value = pageNumber
  emit('changePage', pageNumber)
}

const firstPage = async () => getPage(1)
const prevPage = async () => getPage(current_page.value - 1)
const nextPage = async () => getPage(current_page.value + 1)
const lastPage = async () => getPage(props.last_page)
</script>

<template>
  <nav class="pagination" v-if="props.total > 0">
    <p>
      {{ $t('generics.tables.pagination.show') }}
      <strong>{{ props.from || 0 }}</strong> -
      <strong>{{ props.to || 0 }}</strong>
      {{ $t('generics.tables.pagination.of') }}
      <strong>{{ props.total }}</strong>
    </p>

    <ul>
      <li>
        <button
          class="pagination-link"
          :class="{ 'opacity-35': current_page === 1 }"
          @click.prevent="firstPage()"
        >
          <font-awesome-icon :icon="['fa', 'angles-left']" />
        </button>
      </li>
      <li>
        <button
          class="pagination-link"
          :class="{ 'opacity-35': current_page === 1 }"
          @click.prevent="prevPage()"
        >
          <font-awesome-icon :icon="['fa', 'chevron-left']" />
        </button>
      </li>
      <li v-for="pageNumber in listPages" :key="pageNumber">
        <button
          :class="{ 'pagination-link': pageNumber !== current_page, current: pageNumber === current_page }"
          @click.prevent="getPage(pageNumber)"
        >
          {{ pageNumber }}
        </button>
      </li>
      <li>
        <button
          class="pagination-link"
          :class="{ 'opacity-35': props.last_page === 1 }"
          @click.prevent="nextPage()"
        >
          <font-awesome-icon :icon="['fa', 'chevron-right']" />
        </button>
      </li>
      <li>
        <button
          class="pagination-link"
          :class="{ 'opacity-35': props.last_page === 1 }"
          @click.prevent="lastPage()"
        >
          <font-awesome-icon :icon="['fa', 'angles-right']" />
        </button>
      </li>
    </ul>
  </nav>
</template>

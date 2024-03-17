<script setup>
import { useSlots } from 'vue'
import { useI18n } from 'vue-i18n'
import { Link } from '@inertiajs/vue3';

import BreadCrumbs from '@/Components/Crud/BreadCrumbs.vue'
import { Button } from '@/Components/ui/button'

const slots = useSlots()
const { t } = useI18n()

const props = defineProps({
  breadcrumbs: Array,
  title: String,
  links: Array,
  form: Object,
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
      <Button
        v-for="link in props.links"
        :key="link.text"
        as-child
      >
        <Link :href="route(link.to)">
          {{ link.text }}
        </Link>
      </Button>
    </div>
    <div
      class="gap-3 flex flex-wrap items-center justify-start shrink-0 sm:mt-[50px]"
      v-if="slots.header"
    >
      <slot name="header"></slot>
    </div>
    <div
      class="gap-3 flex flex-wrap items-center justify-start shrink-0 sm:mt-[50px]"
      v-if="props.form"
    >
      <Button
        :disabled="props.form.instance.processing"
        @click="props.form.submitHandler"
      >
        <font-awesome-icon
          class="animate-spin me-1"
          :icon="['fas', 'circle-notch']"
          v-show="props.form.instance.processing"
        />
        {{ props.form.submitText }}
      </Button>

      <Button
        variant="secondary"
        as-child
        :disabled="props.form.instance.processing"
      >
        <Link :href="props.form.hrefCancel">
          {{ t('generics.buttons.cancel') }}
        </Link>
      </Button>
    </div>
  </header>
</template>

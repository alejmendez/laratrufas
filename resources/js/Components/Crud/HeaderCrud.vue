<script setup>
import BreadCrumbs from '@/Components/Crud/BreadCrumbs.vue';

const props = defineProps({
  breadcrumbs: Array,
  title: String,
  links: Array,
  form: Object,
});

const isPromise = (obj) => obj instanceof Promise;
const isFunction = (obj) => obj instanceof Function;
const isLink = (str) => str.toLowerCase().startsWith('http');
</script>

<template>
  <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div class="grow ">
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
      <template
        v-for="link in props.links"
        :key="link.text"
      >
        <template v-if="isPromise(link.to) || isFunction(link.to)">
          <Button :severity="link.variant" @click="link.to"  />
        </template>
        <template v-else>
          <Button
            as="Link"
            :key="link.text"
            :severity="link.variant"
            :href="isLink(link.to) ? link.to : route(link.to)"
            :label="link.text"
          />
        </template>
      </template>
    </div>

    <div
      class="gap-3 flex flex-wrap items-center justify-start shrink-0 sm:mt-[50px]"
    >
      <slot></slot>

      <Button
        :disabled="props.form?.instance.processing"
        @click="props.form?.submitHandler"
        v-if="props.form?.submitHandler"
        :loading="props.form?.instance.processing"
        :label="props.form?.submitText"
      />

      <Button
        severity="secondary"
        :disabled="props.form?.instance.processing"
        :href="props.form?.hrefCancel"
        :label="$t('generics.buttons.cancel')"
        v-if="props.form?.hrefCancel"
      />
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue';

import CardSection from '@/Components/CardSection.vue';

const props = defineProps({
  alert: String,
  errors: Array,
  title: String,
  downloadRoute: String,
});

const openAlert = ref(true);
const openErrors = ref(true);
</script>

<template>
  <CardSection :header-text="props.title" wrapperClass="">
    <div class="p-6">
      <p class="pb-3">{{ $t('generics.bulk.instruction_1') }}</p>
      <ul class="list-decimal ps-5">
        <li>{{ $t('generics.bulk.instruction_2') }}</li>
        <li>{{ $t('generics.bulk.instruction_3') }}</li>
        <li>{{ $t('generics.bulk.instruction_4') }}</li>
        <li>{{ $t('generics.bulk.instruction_5') }}</li>
        <li>{{ $t('generics.bulk.instruction_6') }}</li>
      </ul>
      <p class="py-3">
        <b>{{ $t('generics.bulk.important') }}:</b>
        {{ $t('generics.bulk.instruction_7') }}
      </p>

      <Button
        severity="outline"
        as="a"
        :href="route(props.downloadRoute)"
        target="_blank"
        :label="$t('generics.bulk.download_template')"
      />
    </div>

    <slot />

    <div class="px-6 pb-6" v-if="props.alert && openAlert">
      <div class="p-4 rounded-lg bg-[#D7EAE1] border border-[#89C1A7] text-[#2E5342]">
        <font-awesome-icon :icon="['fas', 'triangle-exclamation']" class="me-1" />
        {{ props.alert }}
        <font-awesome-icon :icon="['fas', 'xmark']" class="float-right text-lg" @click="openAlert = !openAlert" />
      </div>
    </div>

    <div class="px-6 pb-6" v-if="props.errors.length && openErrors">
      <div class="p-4 rounded-lg bg-[#F8DCDF] border border-[#EC979F] text-[#926065]">
        <font-awesome-icon :icon="['fas', 'triangle-exclamation']" class="me-1" />
        {{ $t('generics.bulk.error') }}
        <font-awesome-icon :icon="['fas', 'xmark']" class="float-right text-lg" @click="openErrors = !openErrors" />
        <ul class="list-disc ps-5">
          <li v-for="error in props.errors">
            {{ error }}
          </li>
        </ul>
      </div>
    </div>
  </CardSection>
</template>

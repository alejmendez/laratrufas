<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import { Button } from '@/Components/ui/button';

const { t } = useI18n();

const props = defineProps({
  alert: String,
  errors: String,
  downloadRoute: String,
});

const openAlert = ref(true);
const openErrors = ref(true);
</script>

<template>
  <section
    class="mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5"
  >
    <header class="flex items-center gap-x-3 overflow-hidden px-6 py-4">
      <h3 class="text-base font-semibold leading-6 text-gray-950">
        {{ t('plant.sections.recommendations') }}
      </h3>
    </header>
    <div class="border-t border-gray-200">
      <div class="p-6">
        <p class="pb-3">{{ t('generics.bulk.instruction_1') }}</p>
        <ul class="list-decimal ps-5">
          <li>{{ t('generics.bulk.instruction_2') }}</li>
          <li>{{ t('generics.bulk.instruction_3') }}</li>
          <li>{{ t('generics.bulk.instruction_4') }}</li>
          <li>{{ t('generics.bulk.instruction_5') }}</li>
          <li>{{ t('generics.bulk.instruction_6') }}</li>
        </ul>
        <p class="py-3">
          <b>{{ t('generics.bulk.important') }}:</b>
          {{ t('generics.bulk.instruction_7') }}
        </p>

        <Button
          variant="outline"
          as-child
        >
          <a :href="route(props.downloadRoute)" target="_blank">
            {{ t('generics.bulk.download_template') }}
          </a>
        </Button>
      </div>

      <slot />

      <div class="px-6 pb-6" v-if="props.alert && openAlert">
        <div class="p-4 rounded-lg bg-[#D7EAE1] border border-[#89C1A7] text-[#2E5342]">
          <font-awesome-icon :icon="['fas', 'triangle-exclamation']" class="me-1" />
          {{ t('generics.bulk.alert') }}
          <font-awesome-icon :icon="['fas', 'xmark']" class="float-right text-lg" @click="openAlert = !openAlert" />
        </div>
      </div>

      <div class="px-6 pb-6" v-if="props.errors && openErrors">
        <div class="p-4 rounded-lg bg-[#F8DCDF] border border-[#EC979F] text-[#926065]">
          <font-awesome-icon :icon="['fas', 'triangle-exclamation']" class="me-1" />
          {{ t('generics.bulk.error') }}
          <font-awesome-icon :icon="['fas', 'xmark']" class="float-right text-lg" @click="openError = !openError" />
          <ul class="list-disc ps-5">
            <li v-for="error in props.errors">
              {{ error }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

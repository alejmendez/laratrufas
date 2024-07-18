<script setup>
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>

<template>
  <CardSection
    :header-text="t('field.show.logbook.title')"
    wrapperClass="p-5 grid grid-cols-2 gap-4"
  >
  </CardSection>
</template>

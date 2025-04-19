<script setup>
import AuthenticatedLayout from '@Core/Layouts/AuthenticatedLayout.vue';
</script>

<template>
  <AuthenticatedLayout :title="$t('generics.forbidden')">
    <div class="flex flex-col items-center justify-center h-screen">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        {{ $t('generics.forbidden') }}
      </h1>
    </div>
  </AuthenticatedLayout>
</template>

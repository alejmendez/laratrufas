<script setup>
</script>

<template>
  <Head :title="$t('generics.forbidden')" />

  <AuthenticatedLayout>
    <div class="flex flex-col items-center justify-center h-screen">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
        {{ $t('generics.forbidden') }}
      </h1>
    </div>
  </AuthenticatedLayout>
</template>

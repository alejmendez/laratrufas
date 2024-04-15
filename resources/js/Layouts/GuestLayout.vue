<script setup>

</script>

<template>
  <div id="container-guest" class="h-screen flex items-center justify-center">
    <div class="w-full md:max-w-lg p-6 bg-white border-gray-300 rounded-md shadow-md border lg:max-w-md">
      <slot />
    </div>
  </div>
</template>

<style>
#container-guest {
  background-color: #cc6844;
  background-size: cover;
}
</style>

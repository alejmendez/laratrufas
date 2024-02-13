<script setup>
import MenuElement from './MenuElement.vue'
</script>
<template>
  <aside class="min-h-[calc(100vh-64px)] py-[20px]">
    <div class="flex flex-col justify-between h-full px-[20px] space-y-[10px]">
      <div class="flex flex-col justify-between space-y-[10px]">
        <MenuElement :link="route('dashboard')" text="Escritorio" />
        <div>Gestión</div>
        <MenuElement :link="route('fields.index')" text="Campos" />
        <MenuElement :link="route('quarters.index')" text="Cuarteles" />
        <MenuElement :link="route('plants.index')" text="Plantas" />
        <div>Configuraciones</div>
        <MenuElement :link="route('users.index')" text="Usuarios" />
      </div>
    </div>
  </aside>
</template>

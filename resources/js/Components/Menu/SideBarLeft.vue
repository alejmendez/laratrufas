<script setup>
import MenuElement from './MenuElement.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>
<template>
  <aside class="min-h-[calc(100vh-64px)] py-[20px]">
    <div class="flex flex-col justify-between h-full px-[20px] space-y-[10px]">
      <div class="flex flex-col justify-between space-y-[10px]">
        <MenuElement :link="route('dashboard')" :text="t('menu.dashboard')" />

        <div>{{ t('menu.management') }}</div>
        <MenuElement :link="route('fields.index')" :text="t('menu.fields')" />
        <MenuElement :link="route('quarters.index')" :text="t('menu.quarters')" />
        <MenuElement :link="route('plants.index')" :text="t('menu.plants')" />

        <div>{{ t('menu.harvest_management') }}</div>
        <MenuElement :link="route('users.index')" :text="t('menu.harvest')" />
        <MenuElement :link="route('users.index')" :text="t('menu.batch')" />

        <div>{{ t('menu.task_management') }}</div>
        <MenuElement :link="route('users.index')" :text="t('menu.tasks')" />

        <div>{{ t('menu.records') }}</div>
        <MenuElement :link="route('users.index')" :text="t('menu.machineries')" />
        <MenuElement :link="route('users.index')" :text="t('menu.tools')" />
        <MenuElement :link="route('users.index')" :text="t('menu.suppliers')" />

        <div>{{ t('menu.settings') }}</div>
        <MenuElement :link="route('users.index')" :text="t('menu.users')" />
        <MenuElement :link="route('users.index')" :text="t('menu.dogs')" />
        <MenuElement :link="route('users.index')" :text="t('menu.alerts')" />
        <MenuElement :link="route('users.index')" :text="t('menu.bulk_uploads')" />
      </div>
    </div>
  </aside>
</template>

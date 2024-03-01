<script setup>
import MenuGroup from './MenuGroup.vue'
import MenuElement from './MenuElement.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>
<template>
  <aside class="min-h-[calc(100vh-64px)] py-[20px]">
    <div class="flex flex-col justify-between h-full px-[20px] space-y-[10px]">
      <div class="flex flex-col justify-between space-y-[10px]">
        <MenuElement :link="route('dashboard')" :text="t('menu.dashboard')" />

        <MenuGroup
          :text="t('menu.management')"
          :elements="[
            {link: route('fields.index'), text: t('menu.fields')},
            {link: route('quarters.index'), text: t('menu.quarters')},
            {link: route('plants.index'), text: t('menu.plants')},
          ]"
        />

        <MenuGroup
          :text="t('menu.harvest_management')"
          :elements="[
            {link: route('users.index'), text: t('menu.harvest')},
            {link: route('users.index'), text: t('menu.batch')},
          ]"
        />

        <MenuGroup
          :text="t('menu.task_management')"
          :elements="[
            {link: route('users.index'), text: t('menu.tasks')},
          ]"
        />

        <MenuGroup
          :text="t('menu.records')"
          :elements="[
            {link: route('users.index'), text: t('menu.machineries')},
            {link: route('users.index'), text: t('menu.tools')},
            {link: route('users.index'), text: t('menu.suppliers')},
          ]"
        />

        <MenuGroup
          :text="t('menu.settings')"
          :elements="[
            {link: route('users.index'), text: t('menu.users')},
            {link: route('dogs.index'), text: t('menu.dogs')},
            {link: route('users.index'), text: t('menu.alerts')},
            {link: route('users.index'), text: t('menu.bulk_uploads')},
          ]"
        />
      </div>
    </div>
  </aside>
</template>

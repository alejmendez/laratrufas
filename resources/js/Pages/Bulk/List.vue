<script setup>
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const list = [
  {
    to: 'plants.create.bulk',
    icon: ['fas', 'seedling'],
    title: t('bulk.plants.title'),
    subtitle: t('bulk.plants.subtitle'),
  },
  {
    to: 'harvests.create.bulk',
    icon: ['fas', 'basket-shopping'],
    title: t('bulk.harvests.title'),
    subtitle: t('bulk.harvests.subtitle'),
  },
];
</script>

<template>
    <Head :title="t('bulk.title')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('bulk.title')"
      />

      <div class="grid grid-cols-4 gap-x-16 gap-y-4 mt-5">
        <Link
          v-for="ele in list"
          class="px-6 py-3 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 hover:bg-slate-100 hover:drop-shadow transition-all"
          :href="route(ele.to)"
        >
          <div class="text-xl">
            <font-awesome-icon class="me-2" :icon="ele.icon" />
            {{ ele.title }}
          </div>
          <div>{{ ele.subtitle }}</div>
        </Link>
      </div>
    </AuthenticatedLayout>
</template>

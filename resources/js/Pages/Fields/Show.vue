<script setup>
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';

import FileCard from '@/Pages/Fields/ShowComponents/FileCard.vue';
import LogbookCard from '@/Pages/Fields/ShowComponents/LogbookCard.vue';
import HarvestCard from '@/Pages/Fields/ShowComponents/HarvestCard.vue';
import StatisticsCard from '@/Pages/Fields/ShowComponents/StatisticsCard.vue';

const { t } = useI18n();

const props = defineProps({
  field: Object,
  harvests: Object,
  order: String,
  search: String,
  current_tab: String,
});

const field = props.field.data;

const tabs = ['file', 'logbook', 'harvest', 'statistics'];

const selectTab = (tab) => {
  const url = new URL(window.location.href);
  url.searchParams.set('current_tab', tab);
  return url.href;
};

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('fields.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('field.titles.show')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('field.titles.show')"
        :breadcrumbs="[{ to: 'fields.index', text: t('field.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
      >
        <Button
          severity="secondary"
          @click="deleteHandler(field.id)"
          :label="$t('generics.actions.delete')"
        />
        <Button
          as="Link"
          :href="route('fields.edit', field.id)"
          :label="$t('generics.actions.edit')"
        />
      </HeaderCrud>

      <div class="flex place-content-center">
        <nav class="flex mb-1 rounded-lg bg-white border border-gray-200 px-4 py-1">
          <Link
            v-for="tab of tabs"
            class="px-4 py-2 cursor-default font-semibold"
            :class="props.current_tab === tab ? 'text-red-600' : 'hover:text-red-300 text-gray-400'"
            :href="selectTab(tab)"
          >
            {{ $t('field.show.tabs.' + tab) }}
          </Link>
        </nav>
      </div>

      <FileCard
        :field="field"
        v-show="props.current_tab === tabs[0]"
      />

      <LogbookCard
        v-show="props.current_tab === tabs[1]"
      />

      <HarvestCard
        :field="field"
        v-show="props.current_tab === tabs[2]"
      />

      <StatisticsCard
        v-show="props.current_tab === tabs[3]"
      />
    </AuthenticatedLayout>
</template>

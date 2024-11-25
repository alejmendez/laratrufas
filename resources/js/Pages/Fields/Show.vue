<script setup>
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';

import FileCard from '@/Pages/Fields/ShowComponents/FileCard.vue';
import LogbookCard from '@/Pages/Fields/ShowComponents/LogbookCard.vue';
import HarvestCard from '@/Pages/Fields/ShowComponents/HarvestCard.vue';
import StatisticsCard from '@/Pages/Fields/ShowComponents/StatisticsCard.vue';
import DocumentationCard from '@/Pages/Fields/ShowComponents/DocumentationCard.vue';

const { t } = useI18n();

const props = defineProps({
  field: Object,
  harvests: Object,
  order: String,
  search: String,
  current_tab: String,
});

const field = props.field.data;

const tabs = ['file', 'logbook', 'harvest', 'statistics', 'documentation'];

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
    <Head :title="t('field.titles.show', { name: field.name })" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('field.titles.show', { name: field.name })"
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
        <nav class="flex mb-1 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 px-4 py-1">
          <Link
            v-for="tab of tabs"
            class="px-4 py-2 cursor-default font-semibold"
            :class="props.current_tab === tab ? 'text-[--p-primary-500]' : 'hover:text-[--p-primary-300] dark:hover:text-[--p-primary-600] text-gray-400'"
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
        :field_id="field.id"
        v-show="props.current_tab === tabs[2]"
      />

      <StatisticsCard
        :field="field"
        v-show="props.current_tab === tabs[3]"
      />

      <DocumentationCard
        :field="field"
        v-show="props.current_tab === tabs[4]"
      />
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';

import StatisticsCard from '@/Pages/Quarters/ShowComponents/StatisticsCard.vue';

const { t } = useI18n();

const props = defineProps({
  data: Object,
});

const { data } = props.data;

const tabs = ['file', 'documentation', 'logbook', 'statistics'];

const currentTab = ref(tabs[3]);

const dataFile = [
  [t('quarter.show.file.field'), data.field.name],
  [t('quarter.show.file.area'), data.area],
  [t('quarter.show.file.plants_count'), data.plants_count],
  [t('quarter.show.file.responsible'), data.responsible.name],
];

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('quarters.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('quarter.titles.show', {name: data.name})" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('quarter.titles.show', {name: data.name})"
        :breadcrumbs="[{ to: 'quarters.index', text: t('quarter.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
      >
        <Button
          severity="secondary"
          @click="deleteHandler(data.id)"
          :label="$t('generics.actions.delete')"
        />
        <Button
          as="Link"
          :href="route('quarters.edit', data.id)"
          :label="$t('generics.actions.edit')"
        />
      </HeaderCrud>

      <div class="flex place-content-center">
        <nav class="flex mb-1 rounded-lg bg-white border border-gray-200 px-4 py-1">
          <span
            v-for="tab of tabs"
            class="px-4 py-2 cursor-default font-semibold"
            :class="currentTab === tab ? 'text-red-600' : 'hover:text-red-300 text-gray-400'"
            @click="currentTab = tab"
          >
            {{ $t('quarter.show.tabs.' + tab) }}
          </span>
        </nav>
      </div>

      <CardSection
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[0]"
      >
        <div>
          <img
            :src="data.blueprint"
            class="w-full"
            alt=""
          >
        </div>
        <div>
          <template v-for="block of dataFile">
            <div class="text-gray-400 pb-1">
              {{ block[0] }}
            </div>
            <div class="pb-3">
              {{ block[1] }}
            </div>
          </template>
        </div>
      </CardSection>

      <CardSection
        :header-text="t('quarter.show.documentation.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[1]"
      >
      </CardSection>

      <CardSection
        :header-text="t('quarter.show.logbook.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[2]"
      >
      </CardSection>

      <StatisticsCard
        :quarter="data"
        v-show="currentTab === tabs[3]"
      />
    </AuthenticatedLayout>
</template>

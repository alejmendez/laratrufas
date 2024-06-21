<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';
import { format } from 'date-fns';
import { stringToDate } from '@/Utils/date';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'
import { Button } from '@/Components/ui/button';
import CardSection from '@/Components/CardSection.vue';

const { t } = useI18n();

const props = defineProps({
  data: Object,
});

const { data } = props.data;

const tabs = [
  'file',
  'variables',
  'logs',
  'harvest',
  'statistics',
];

const currentTab = ref(tabs[0]);

const dataFile = [
  [t('plant.show.file.field'), data.field.name],
  [t('plant.show.file.quarter'), data.quarter.name],
  [t('plant.show.file.plant_type'), data.plant_type.name],
  [t('plant.show.file.age'), data.age],
  [t('plant.show.file.planned_at'), format(stringToDate(data.planned_at), 'dd/MM/yyyy')],
  [t('plant.show.file.responsible'), data.responsible.name],
]

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('plants.destroy', id));
  });
};
</script>

<template>
    <Head :title="t('plant.titles.show')" />

    <AuthenticatedLayout>
      <HeaderCrud
        :title="t('plant.titles.show')"
        :breadcrumbs="[{ to: 'plants.index', text: t('plant.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
      >
        <Button
          variant="secondary"
          @click="deleteHandler(data.id)"
        >
          {{ t('generics.actions.delete') }}
        </Button>
        <Button as-child>
          <Link :href="route('plants.edit', data.id)">
            {{ t('generics.actions.edit') }}
          </Link>
        </Button>
      </HeaderCrud>

      <div class="flex place-content-center">
        <nav class="flex mb-1 rounded-lg bg-white border border-gray-200 px-4 py-1">
          <span
            v-for="tab of tabs"
            class="px-4 py-2 cursor-default font-semibold"
            :class="currentTab === tab ? 'text-red-600' : 'hover:text-red-300 text-gray-400'"
            @click="currentTab = tab"
          >
            {{ t('plant.show.tabs.' + tab) }}
          </span>
        </nav>
      </div>

      <CardSection
        :header-text="t('plant.show.file.title', {name: data.name})"
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
        :header-text="t('plant.show.variables.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[1]"
      >
      </CardSection>

      <CardSection
        :header-text="t('plant.show.logs.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[2]"
      >
      </CardSection>

      <CardSection
        :header-text="t('plant.show.harvest.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[3]"
      >
      </CardSection>
      <CardSection
        :header-text="t('plant.show.statistics.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[4]"
      >
      </CardSection>
    </AuthenticatedLayout>
</template>

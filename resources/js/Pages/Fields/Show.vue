<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';

const { t } = useI18n();

const props = defineProps({
  data: Object,
});

const { data } = props.data;

const tabs = [
  'file',
  'logbook',
  'harvest',
  'statistics',
];

const currentTab = ref(tabs[0]);

const dataFile = [
  [t('field.show.file.location'), data.location],
  [t('field.show.file.size'), data.size],
  [t('field.show.file.plants_count'), data.plants_count],
  [t('field.show.file.quarters_count'), data.quarters_count],
]

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
          variant="secondary"
          @click="deleteHandler(data.id)"
        >
          {{ $t('generics.actions.delete') }}
        </Button>
        <Button as-child>
          <Link :href="route('fields.edit', data.id)">
            {{ $t('generics.actions.edit') }}
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
            {{ $t('field.show.tabs.' + tab) }}
          </span>
        </nav>
      </div>

      <CardSection
        :header-text="t('field.show.file.title', {name: data.name})"
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
        :header-text="t('field.show.logbook.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[1]"
      >
      </CardSection>

      <CardSection
        :header-text="t('field.show.harvest.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[2]"
      >
      </CardSection>

      <CardSection
        :header-text="t('field.show.statistics.title')"
        wrapperClass="p-5 grid grid-cols-2 gap-4"
        v-show="currentTab === tabs[3]"
      >
      </CardSection>
    </AuthenticatedLayout>
</template>

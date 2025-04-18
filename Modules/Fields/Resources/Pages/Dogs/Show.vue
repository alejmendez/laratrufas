<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { useConfirm } from 'primevue/useconfirm';
import { deleteRowTable } from '@/Utils/table';
import { stringToFormat } from '@/Utils/date';
import { can } from '@/Services/Auth';

const { t } = useI18n();

const props = defineProps({
  data: Object,
  current_tab: String,
});

const { data } = props.data;

const gender = t('dog.form.gender.options.' + (data.gender.toLowerCase() === 'm' ? 'male' : 'female'));

const canDestroy = can('dogs.destroy');
const canEdit = can('dogs.edit');

const headerLinks = [];
if (canDestroy) {
  headerLinks.push({ to: () => deleteHandler(data.id), variant: 'secondary', text: t('generics.actions.delete') });
}
if (canEdit) {
  headerLinks.push({ to: route('dogs.edit', data.id), text: t('generics.actions.edit') });
}

const FILE_TAB = 'file';
const ACTIVITY_TAB = 'activity';
const STATISTICS_TAB = 'statistics';

const tabs = [FILE_TAB, ACTIVITY_TAB, STATISTICS_TAB];

const currentTab = ref(props.current_tab || FILE_TAB);
const confirm = useConfirm();

const isFileTab = computed(() => currentTab.value === FILE_TAB);
const isActivityTab = computed(() => currentTab.value === ACTIVITY_TAB);
const isStatisticsTab = computed(() => currentTab.value === STATISTICS_TAB);

const selectTab = (tab) => {
  currentTab.value = tab;
  const url = new URL(window.location.href);
  url.searchParams.set('current_tab', tab);
  window.history.pushState({}, '', url);
};

const deleteHandler = async (id) => {
  await deleteRowTable(t, confirm, () => {
    router.delete(route('dogs.destroy', id));
  });
};
</script>

<template>
  <Head :title="t('dog.titles.show')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="t('dog.titles.show')"
      :breadcrumbs="[{ to: 'dogs.index', text: t('dog.titles.entity_breadcrumb') }, { text: t('generics.detail') }]"
      :links="headerLinks"
    />

    <div class="grid grid-cols-3 gap-4 auto-cols-max">
      <div class="card-section p-4 flex col-span-2 mt-5 rounded-xl shadow-sm ring-1 ring-gray-950/5">
        <div class="w-32 border rounded-md me-4">
          <img
            class="border rounded-md"
            :src="data.avatar"
            v-if="data.avatar"
            alt=""
          >
        </div>
        <div class="grow">
          <h3 class="my-4 text-2xl dark:text-white font-bold">{{ data.name }}</h3>
          <div class="text-gray-400">Cuartel: {{ data.quarter.name }}</div>
        </div>
      </div>

      <div class="card-section p-4 mt-5 rounded-xl shadow-sm ring-1 ring-gray-950/5">
        <div class="text-gray-400 pb-1">{{ $t('dog.show.created_at') }}</div>
        <div class="pb-3 dark:text-white">{{ stringToFormat(data.created_at) }}</div>
        <div class="text-gray-400 pb-1">{{ $t('dog.show.updated_at') }}</div>
        <div class="dark:text-white">{{ stringToFormat(data.updated_at) }}</div>
      </div>
    </div>

    <div class="flex place-content-center mt-5">
      <nav class="flex mb-1 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 px-4 py-1">
        <span
          v-for="tab of tabs"
          class="px-4 py-2 cursor-default font-semibold"
          :class="currentTab === tab ? 'text-(--p-primary-500)' : 'hover:text-(--p-primary-300) dark:hover:text-(--p-primary-600) text-gray-400'"
          @click="selectTab(tab)"
        >
          {{ $t('dog.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <CardSection
      :header-text="t('dog.show.file.title')"
      wrapperClass="p-5 grid grid-cols-3 gap-4"
      v-show="isFileTab"
    >
      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('dog.show.file.breed.label') }}</div>
        <div class="">{{ data.breed }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('dog.show.file.gender.label') }}</div>
        <div class="">{{ gender }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('dog.show.file.age.label') }}</div>
        <div class="">{{ data.age }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('dog.show.file.birthdate.label') }}</div>
        <div class="">{{ stringToFormat(data.birthdate) }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('dog.show.file.veterinary.label') }}</div>
        <div class="">{{ data.veterinary }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('dog.show.file.couple.label') }}</div>
        <div class="">{{ data.couple.name }}</div>
      </div>
    </CardSection>

    <CardSection
      :header-text="t('dog.show.activity.title')"
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="isActivityTab"
    >
    </CardSection>
    <CardSection
      :header-text="t('dog.show.statistics.title')"
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="isStatisticsTab"
    >
    </CardSection>
  </AuthenticatedLayout>
</template>

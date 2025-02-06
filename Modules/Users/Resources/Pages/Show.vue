<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { deleteRowTable } from '@/Utils/table';
import { stringToFormat } from '@/Utils/date';

const { t } = useI18n();

const props = defineProps({
  data: Object,
});

const { data } = props.data;

const tabs = ['file', 'activity', 'statistics'];

const currentTab = ref(tabs[0]);

const deleteHandler = async (id) => {
  await deleteRowTable(t, () => {
    router.delete(route('users.destroy', id));
  });
};
</script>

<template>
  <Head :title="$t('user.titles.show')" />

  <AuthenticatedLayout>
    <HeaderCrud
      :title="$t('user.titles.show')"
      :breadcrumbs="[{ to: 'users.index', text: $t('user.titles.entity_breadcrumb') }, { text: $t('generics.detail') }]"
      :links="[
        { to: () => deleteHandler(data.id), variant: 'secondary', text: $t('generics.actions.delete') },
        { to: route('users.edit', data.id), text: $t('generics.actions.edit') }
      ]"
    />

    <div class="grid grid-cols-3 gap-4 auto-cols-max">
      <div class="p-4 flex col-span-2 mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
        <div class="w-32 border rounded-md me-4">
          <img
            class="border rounded-md"
            :src="data.avatar"
            v-if="data.avatar"
            alt=""
          >
        </div>
        <div class="grow">
          <h3 class="my-4 text-2xl font-bold">{{ data.full_name }}</h3>
          <div class="text-gray-400">{{ data.role.name }}</div>
        </div>
      </div>

      <div class="p-4 mt-5 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5">
        <div class="text-gray-400 pb-1">{{ $t('user.show.created_at') }}</div>
        <div class="pb-3">{{ stringToFormat(data.created_at) }}</div>
        <div class="text-gray-400 pb-1">{{ $t('user.show.updated_at') }}</div>
        <div>{{ stringToFormat(data.updated_at) }}</div>
      </div>
    </div>

    <div class="flex place-content-center mt-5">
      <nav class="flex mb-1 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 px-4 py-1">
        <span
          v-for="tab of tabs"
          class="px-4 py-2 cursor-default font-semibold"
          :class="currentTab === tab ? 'text-[--p-primary-500]' : 'hover:text-[--p-primary-300] dark:hover:text-[--p-primary-600] text-gray-400'"
          @click="currentTab = tab"
        >
          {{ $t('user.show.tabs.' + tab) }}
        </span>
      </nav>
    </div>

    <CardSection
      :header-text="$t('user.show.file.title')"
      wrapperClass="p-5 grid grid-cols-3 gap-4"
      v-show="currentTab === tabs[0]"
    >
      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('user.show.file.dni.label') }}</div>
        <div class="">{{ data.dni }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('user.show.file.name.label') }}</div>
        <div class="">{{ data.name }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('user.show.file.last_name.label') }}</div>
        <div class="">{{ data.last_name }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('user.show.file.email.label') }}</div>
        <div class="">{{ data.email }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('user.show.file.phone.label') }}</div>
        <div class="">{{ data.phone }}</div>
      </div>

      <div class="mb-2">
        <div class="text-gray-400 mb-2">{{ $t('user.show.file.role.label') }}</div>
        <div class="">{{ data.role.name }}</div>
      </div>
    </CardSection>

    <CardSection
      :header-text="$t('user.show.activity.title')"
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="currentTab === tabs[1]"
    >
    </CardSection>
    <CardSection
      :header-text="$t('user.show.statistics.title')"
      wrapperClass="p-5 grid grid-cols-2 gap-4"
      v-show="currentTab === tabs[2]"
    >
    </CardSection>
  </AuthenticatedLayout>
</template>

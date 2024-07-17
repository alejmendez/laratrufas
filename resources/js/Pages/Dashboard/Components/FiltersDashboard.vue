<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const props = defineProps({
  fields: Array,
});

const { t } = useI18n();

const form = useForm({
  field_id: '',
  start_date: '',
  end_date: '',
});
</script>

<template>
  <section class="mt-5 p-5 rounded-xl bg-white shadow-sm border border-gray-200 grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-x-16 gap-y-4">
    <div class="flex">
      <img class="object-cover object-center w-[72px] h-[72px] rounded-full border-2 border-gray-50" :src="$page.props.auth.user.avatar_url || 'https://i.pravatar.cc/150?img=3'" alt="" />
      <div class="pt-3 ps-2">
        <div>
          Hola!
        </div>
        <div>
          {{ $page.props.auth.user.full_name }}
        </div>
      </div>
    </div>
    <div>
      <VSelect
        id="field"
        v-model="form.field_id"
        :placeholder="t('generics.please_select')"
        :options="props.fields"
        :label="t('dashboard.form.field_id.label')"
      />
    </div>
    <div>
      <VInput
        id="start_date"
        type="date"
        v-model="form.start_date"
        :label="t('dashboard.form.start_date.label')"
        :message="form.errors.start_date"
      />
    </div>
    <div>
      <VInput
        id="end_date"
        type="date"
        v-model="form.end_date"
        :label="t('dashboard.form.end_date.label')"
        :message="form.errors.end_date"
      />
    </div>
  </section>
</template>

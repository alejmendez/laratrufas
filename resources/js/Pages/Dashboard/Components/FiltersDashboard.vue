<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const props = defineProps({
  fields: Array,
  field: Object,
});

const { t } = useI18n();

const form = useForm({
  field_id: props.fields.find(a => a.value === props.field.data.id),
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
    <div class="col-end-5">
      <VSelect
        id="field"
        v-model="form.field_id"
        :placeholder="t('generics.please_select')"
        :options="props.fields"
        :label="t('dashboard.form.field_id.label')"
      />
    </div>
  </section>
</template>

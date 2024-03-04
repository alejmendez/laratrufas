<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FiltersDashboard from '@/Pages/Dashboard/Components/FiltersDashboard.vue'
import CardsDashboard from '@/Pages/Dashboard/Components/CardsDashboard.vue'
import MapDashboard from '@/Pages/Dashboard/Components/MapDashboard.vue'
import MessageDashboard from '@/Pages/Dashboard/Components/MessageDashboard.vue'

const props = defineProps({
  fields: Array,
})

const { t } = useI18n()
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
      <FiltersDashboard :fields="props.fields" />
      <CardsDashboard :fields="props.fields" />

      <section class="mt-5 grid grid-cols-4 gap-4">
        <MapDashboard :fields="props.fields" />
        <MessageDashboard :fields="props.fields" />
      </section>
    </AuthenticatedLayout>
</template>

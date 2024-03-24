<script setup>
import { Head, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FiltersDashboard from '@/Pages/Dashboard/Components/FiltersDashboard.vue';
import CardsDashboard from '@/Pages/Dashboard/Components/CardsDashboard.vue';
import MapDashboard from '@/Pages/Dashboard/Components/MapDashboard.vue';
import MessageDashboard from '@/Pages/Dashboard/Components/MessageDashboard.vue';

const props = defineProps({
  fields: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
      <FiltersDashboard :fields="props.fields" />
      <CardsDashboard />

      <section class="mt-5 grid grid-cols-4 gap-4">
        <MapDashboard />
        <MessageDashboard />
      </section>
    </AuthenticatedLayout>
</template>

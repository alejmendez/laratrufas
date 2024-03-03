<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6 text-gray-900"><img class="w-10 h-10 rounded-full border-2 border-gray-50" :src="$page.props.auth.user.avatar" alt="" /> You're logged in!</div>
    </AuthenticatedLayout>
</template>

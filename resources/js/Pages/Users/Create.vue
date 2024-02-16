<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3'

import { useI18n } from 'vue-i18n'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue'

const { t } = useI18n()

const props = defineProps({
    order: String,
    search: String,
    data: Object,
})

const form = useForm({
  first_name: null,
  last_name: null,
  email: null,
})

const submitHandler = () => {
    router.post('/users', form)
    // router.post('/users', data, {
    //     forceFormData: true,
    // })
}
</script>

<template>
    <Head :title="t('user.titles.entity_breadcrumb')" />

    <AuthenticatedLayout>
        <HeaderCrud
            :title="t('user.titles.entity_breadcrumb')"
            :breadcrumbs="[{ to: 'users.index', text: t('user.titles.entity_breadcrumb') }, { text: t('generics.list') }]"
            :links="[{ to: 'users.create', text: t('generics.new') }]"
        />

        <form @submit.prevent="submitHandler">
            <text-input
                v-model="form.first_name"
                :error="form.errors.first_name"
                class="pb-8 pr-6 w-full lg:w-1/2"
                label="First name"
            />
        </form>
    </AuthenticatedLayout>
</template>

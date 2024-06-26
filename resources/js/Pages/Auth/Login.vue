<script setup>
import { useI18n } from 'vue-i18n';
import { Head, Link, useForm } from '@inertiajs/vue3';

import GuestLayout from '@/Layouts/GuestLayout.vue';
import VInput from '@/Components/Form/VInput.vue';
import { Checkbox } from '@/Components/ui/checkbox';
import { Button } from '@/Components/ui/button';

const { t } = useI18n();

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
    <GuestLayout>
        <Head :title="t('auth.login.title')" />

        <div class="my-4 text-4xl text-gray-900 font-bold text-center">
          {{ t('auth.login.title') }}
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
          <VInput
            id="email"
            type="email"
            classWrapper="mt-4"
            v-model="form.email"
            :label="t('auth.login.form.email')"
            :message="form.errors.email"
          />

          <VInput
            id="password"
            type="password"
            autocomplete="current-password"
            classWrapper="mt-4"
            v-model="form.password"
            :label="t('auth.login.form.password')"
            :message="form.errors.password"
          />

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ t('auth.login.form.remember_me') }}</span>
                </label>
            </div>

            <div class="block mt-4">
              <Button :disabled="form.processing" class="w-full">
                <font-awesome-icon
                  class="animate-spin me-1"
                  :icon="['fas', 'circle-notch']"
                  v-show="form.processing"
                />
                {{ t('auth.login.form.submit') }}
              </Button>
            </div>

            <div class="block mt-4 text-center">
              <Link
                  v-if="canResetPassword"
                  :href="route('password.request')"
                  class="text-l font-bold text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                {{ t('auth.login.links.restore_password') }}
              </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

import { useI18n } from 'vue-i18n';
const { t } = useI18n();

const form = useForm({
  password: '',
});

const submit = () => {
  form.post(route('password.confirm'), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <GuestLayout>
    <Head :title="t('auth.confirmPassword.title')" />

    <div class="mb-4 text-sm text-gray-600">
      {{ $t('auth.confirmPassword.subtitle') }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="password" :value="t('auth.confirmPassword.form.password')" />
        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
          autofocus
        />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex justify-end mt-4">
        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('auth.confirmPassword.form.password') }}
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>

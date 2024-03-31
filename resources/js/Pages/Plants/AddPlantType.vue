<script setup>
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import VInput from '@/Components/form/VInput.vue';
import { Button } from '@/Components/ui/button';

import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/Components/ui/dialog';

const { t } = useI18n();

const props = defineProps({});

const form = useForm({
  name: null,
});

const addPlantType = () => {};
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button
        variant="outline"
      >
        <font-awesome-icon :icon="['fas', 'plus']" />
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Agregar un tipo de planta</DialogTitle>
      </DialogHeader>

      <div class="grid gap-4 py-4">
        <div class="grid items-center gap-4">
          <VInput
            id="name"
            v-model="form.name"
            :label="t('plant.form.name.label')"
            :message="form.errors.name"
          />
        </div>
      </div>
      <DialogFooter>
        <Button type="submit" @click="addPlantType">
          {{ t('generics.actions.create') }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>

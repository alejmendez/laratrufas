<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import { create } from '@/Services/PlantType.js';

import Dialog from 'primevue/dialog';

const { t } = useI18n();

const props = defineProps({
  callback: Function,
});

const plant_type_name = ref('');
const open = ref(false);
const loading = ref(false);

const addPlantType = async () => {
  loading.value = true;
  const newType = await create(plant_type_name.value);
  loading.value = false;
  open.value = false;
  props.callback(newType);
};
</script>

<template>
  <Button
    severity="secondary"
    @click.prevent="open = true"
    icon="pi pi-plus"
  />
  <Dialog v-model:visible="open" modal header="Agregar un tipo de planta" :style="{ maxWidth: '425px' }">
    <div class="grid gap-4 py-4">
      <div class="grid items-center gap-4">
        <VInput
          id="plant_type_name"
          v-model="plant_type_name"
          :label="t('plant.form.name.label')"
        />
      </div>
    </div>
    <div class="flex justify-end">
      <Button type="submit" @click="addPlantType" :label="$t('generics.actions.create')" :loading="loading" />
    </div>
  </Dialog>
</template>

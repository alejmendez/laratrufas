<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

import { create } from '@/Services/PlantType.js';

import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/Components/ui/dialog';

const { t } = useI18n();

const props = defineProps({
  callback: Function,
});

const plant_type_name = ref('');
const open = ref(false);

const addPlantType = async () => {
  const newType = await create(plant_type_name.value);
  open.value = false;
  props.callback(newType);
};
</script>

<template>
  <Dialog :open="open">
    <Button
      variant="outline"
      @click.prevent="open = true"
    >
      <font-awesome-icon :icon="['fas', 'plus']" />
    </Button>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Agregar un tipo de planta</DialogTitle>
      </DialogHeader>

      <div class="grid gap-4 py-4">
        <div class="grid items-center gap-4">
          <VInput
            id="plant_type_name"
            v-model="plant_type_name"
            :label="t('plant.form.name.label')"
          />
        </div>
      </div>
      <DialogFooter>
        <Button type="submit" @click="addPlantType">
          {{ $t('generics.actions.create') }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>

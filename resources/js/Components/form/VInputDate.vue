<script setup>
import { watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { format } from 'date-fns';

import { cn } from '@/lib/utils';
import { Button } from '@/Components/ui/button';
import { Calendar } from '@/Components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover';

const model = defineModel();
const props = defineProps({
  maxDate: {
    type: Object,
  },
  minDate: {
    type: Object,
  },
});

const { t } = useI18n();

const emit = defineEmits(['change', 'blur']);

watch(model, async (newValue, _) => {
  emit('change', newValue);
});
</script>

<template>
  <Popover>
    <PopoverTrigger as-child>
      <Button
        :variant="'outline'"
        :class="cn(
          'w-full justify-start text-left font-normal mt-1',
          !model && 'text-muted-foreground',
        )"
      >
        <font-awesome-icon :icon="['far', 'calendar']" class="mr-2 h-4 w-4" />
        <span>{{ model ? format(model, "dd/MM/yyyy") : t('generics.form.date.label') }}</span>
      </Button>
    </PopoverTrigger>
    <PopoverContent class="w-auto p-0" align="start">
      <Calendar v-model="model" :max-date="props.maxDate" :min-date="props.minDate" />
    </PopoverContent>
  </Popover>
</template>

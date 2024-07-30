import PrimeVue from 'primevue/config';
import { definePreset } from '@primevue/themes';
import Lara from '@primevue/themes/lara';

const AppPreset = definePreset(Lara, {
  semantic: {
    primary: {
      50: '{orange.50}',
      100: '{orange.100}',
      200: '{orange.200}',
      300: '{orange.300}',
      400: '{orange.400}',
      500: '{orange.500}',
      600: '{orange.600}',
      700: '{orange.700}',
      800: '{orange.800}',
      900: '{orange.900}',
      950: '{orange.950}'
    },
    formField: {
      height: '2.5rem',
      width: '100%',
    },
  },
});

export const initPrime = (app) => {
  app.use(PrimeVue, {
    theme: {
      preset: AppPreset,
      options: {
          prefix: 'p',
          darkModeSelector: '.dark-mode',
          cssLayer: false
      }
    }
  });
};

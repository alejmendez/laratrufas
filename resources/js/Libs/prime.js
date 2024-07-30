import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';

export const initPrime = (app) => {
  app.use(PrimeVue, {
    theme: {
      preset: Aura,
      options: {
          prefix: 'p',
          darkModeSelector: '.dark-mode',
          cssLayer: false
      }
    }
  });
};

import PrimeVue from 'primevue/config';
import primeLocale from '@/lang/es/prime';

import Presents from './PrimePresents';

import 'quill-mention/dist/quill.mention.min.css';

export const initPrime = (app) => {
  const theme = localStorage.getItem('theme') || 'CarrotOrange';

  app.use(PrimeVue, {
    theme: {
      preset: Presents[theme],
      options: {
        prefix: 'p',
        darkModeSelector: '.dark',
        cssLayer: false,
      },
    },
    locale: primeLocale,
  });
};

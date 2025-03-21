import { createI18n } from 'vue-i18n';
import es from '@Core/Lang/es';

export const initI18n = (app) => {
  app.use(
    createI18n({
      legacy: false,
      locale: 'es',
      messages: {
        es,
      },
    }),
  );
};

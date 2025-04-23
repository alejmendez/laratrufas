import { i18nVue } from 'laravel-vue-i18n';
import { trans } from 'laravel-vue-i18n';

export const initI18n = (app) => {
  app.use(i18nVue, {
    lang: 'es',
    resolve: (lang) => {
      const langs = import.meta.glob('../../../../lang/*.json', { eager: true });
      return langs[`../../../../lang/php_${lang}.json`].default;
    },
  });
  app.config.globalProperties.__ = trans;
};

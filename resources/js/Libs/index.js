import { initFontAwesome } from './font-awesome';
import { initPinia } from './pinia';
import { initI18n } from './i18n';
import { initMask } from './mask';
import { initPrime } from './prime';
import { initApexCharts } from './apexcharts';
import { initComponent } from './components';

export const initLibs = (app) => {
  initFontAwesome(app);
  initPinia(app);
  initI18n(app);
  initMask(app);
  initPrime(app);
  initApexCharts(app);
  initComponent(app);
};

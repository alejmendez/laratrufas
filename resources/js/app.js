import './bootstrap';
import 'primeicons/primeicons.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import { initLibs } from '@/Libs';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Importamos todos los módulos de una vez
const modulePages = import.meta.glob('./../../Modules/*/Resources/Pages/**/*.vue');
const pages = import.meta.glob('./Pages/**/*.vue');

const resolvePageComponent = (name) => {
  let page;
  if (name.includes('::')) {
    const [module, pageName] = name.split('::');
    const pagePath = `../../Modules/${module}/Resources/Pages/${pageName}.vue`;

    if (!modulePages[pagePath]) {
      throw new Error(`Page "${pagePath}" not found`);
    }

    page = modulePages[pagePath];
  } else {
    page = pages[`./Pages/${name}.vue`];
  }

  return typeof page === 'function' ? page() : page;
};

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(name),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });
    initLibs(app);
    return app.use(plugin).use(ZiggyVue).mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});

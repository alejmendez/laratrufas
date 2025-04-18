import Label from '@/Components/Form/Label.vue';
import Button from '@/Components/Form/Button.vue';

import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';

import Tooltip from 'primevue/tooltip';

export const initComponent = (app) => {
  app.component('Label', Label);
  app.component('Button', Button);

  app.use(ToastService);
  app.use(ConfirmationService);

  app.directive('tooltip', Tooltip);
};

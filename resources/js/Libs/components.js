import { Link, Head } from '@inertiajs/vue3';

import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import VInputFile from '@/Components/Form/VInputFile.vue';

import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import CardSection from '@/Components/CardSection.vue';
import TableList from '@/Components/Table/TableList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Label from '@/Components/Form/Label.vue';
import Button from '@/Components/Form/Button.vue';

import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';

import Tooltip from 'primevue/tooltip';

export const initComponent = (app) => {
  app.component('Head', Head);
  app.component('Link', Link);

  app.component('VInput', VInput);
  app.component('VSelect', VSelect);
  app.component('VInputFile', VInputFile);
  app.component('HeaderCrud', HeaderCrud);
  app.component('CardSection', CardSection);
  app.component('TableList', TableList);
  app.component('AuthenticatedLayout', AuthenticatedLayout);

  app.component('Label', Label);
  app.component('Button', Button);

  app.use(ToastService);
  app.use(ConfirmationService);

  app.directive('tooltip', Tooltip);
};

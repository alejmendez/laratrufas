import { Link, Head } from '@inertiajs/vue3';

import VElementFormWrapper from '@/Components/Form/VElementFormWrapper.vue';
import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import VSelectMultiple from '@/Components/Form/VSelectMultiple.vue';
import VInputFile from '@/Components/Form/VInputFile.vue';
import VInputDni from '@/Components/Form/VInputDni.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import CardSection from '@/Components/CardSection.vue';
import TableList from '@/Components/Table/TableList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Label from '@/Components/Form/Label.vue';
import Button from '@/Components/Form/Button.vue';
import Checkbox from '@/Components/Form/Checkbox.vue';

export const initComponent = (app) => {
  app.component('Head', Head);
  app.component('Link', Link);
  app.component('VSelectMultiple', VSelectMultiple);

  app.component('VElementFormWrapper', VElementFormWrapper);
  app.component('VInput', VInput);
  app.component('VSelect', VSelect);
  app.component('VInputFile', VInputFile);
  app.component('VInputDni', VInputDni);
  app.component('PrimaryButton', PrimaryButton);
  app.component('HeaderCrud', HeaderCrud);
  app.component('CardSection', CardSection);
  app.component('TableList', TableList);
  app.component('AuthenticatedLayout', AuthenticatedLayout);

  app.component('Label', Label);
  app.component('Button', Button);
  app.component('Checkbox', Checkbox);
};

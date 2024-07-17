import { Link, Head } from '@inertiajs/vue3';
import VueMultiselect from 'vue-multiselect';

import VInput from '@/Components/Form/VInput.vue';
import VSelect from '@/Components/Form/VSelect.vue';
import VInputFile from '@/Components/Form/VInputFile.vue';
import VInputDni from '@/Components/Form/VInputDni.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import HeaderCrud from '@/Components/Crud/HeaderCrud.vue';
import CardSection from '@/Components/CardSection.vue';
import TableList from '@/Components/Table/TableList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Label } from '@/Components/ui/label';
import Button from '@/Components/ui/button/Button.vue';
import { Checkbox } from '@/Components/ui/checkbox';

export const initComponent = (app) => {
  app.component('Head', Head);
  app.component('Link', Link);
  app.component('VueMultiselect', VueMultiselect);

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

export const menuElements = (t, page) => {
  return [
    {
      text: t('menu.management'),
      children: [
        {
          link: route('fields.index'),
          text: t('menu.fields'),
          icon: 'fa-solid fa-table-cells',
          active: page.component.startsWith('Field'),
        },
        {
          link: route('quarters.index'),
          text: t('menu.quarters'),
          icon: 'fa-solid fa-table-cells-large',
          active: page.component.startsWith('Quarter'),
        },
        { link: route('plants.index'), text: t('menu.plants'), icon: 'fa-brands fa-envira', active: page.component.startsWith('Plant') },
      ],
    },
    {
      text: t('menu.harvest_management'),
      children: [
        {
          link: route('harvests.index'),
          text: t('menu.harvest'),
          icon: 'fa-solid fa-basket-shopping',
          active: page.component.startsWith('Harvests'),
        },
        {
          link: route('harvests.details.create'),
          text: t('menu.harvest_details'),
          icon: 'fa-solid fa-barcode',
          active: page.component.startsWith('HarvestDetails'),
        },
        { link: route('users.index'), text: t('menu.batch'), icon: 'fa-solid fa-file-invoice-dollar' },
      ],
    },
    {
      text: t('menu.task_management'),
      children: [{ link: route('tasks.index'), text: t('menu.tasks'), icon: 'fa-solid fa-list-check' }],
    },
    {
      text: t('menu.records'),
      children: [
        { link: route('machineries.index'), text: t('menu.machineries'), icon: 'fa-solid fa-tractor' },
        { link: route('tools.index'), text: t('menu.tools'), icon: 'fa-solid fa-wrench' },
        { link: route('users.index'), text: t('menu.suppliers'), icon: 'fa-solid fa-handshake' },
      ],
    },
    {
      text: t('menu.settings'),
      children: [
        // <font-awesome-icon icon="fa-solid fa-file-arrow-up" />
        { link: route('users.index'), text: t('menu.users'), icon: 'fa-solid fa-users', active: page.component.startsWith('User') },
        { link: route('dogs.index'), text: t('menu.dogs'), icon: 'fa-solid fa-dog', active: page.component.startsWith('Dog') },
        { link: route('users.index'), text: t('menu.alerts'), icon: 'fa-solid fa-triangle-exclamation' },
        {
          link: route('bulk.index'),
          text: t('menu.bulk_uploads'),
          icon: 'fa-solid fa-file-arrow-up',
          active: page.component.startsWith('Bulk'),
        },
      ],
    },
  ];
};

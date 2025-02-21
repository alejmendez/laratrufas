import { can } from '@/Services/Auth';

export const menuElements = (currentComponent) => {
  const menuItems = [
    {
      text: 'menu.management',
      children: [
        {
          link: route('fields.index'),
          text: 'menu.fields',
          icon: 'fa-solid fa-table-cells',
          active: currentComponent.startsWith('Fields::Field'),
          can: can('fields.index'),
        },
        {
          link: route('quarters.index'),
          text: 'menu.quarters',
          icon: 'fa-solid fa-table-cells-large',
          active: currentComponent.startsWith('Fields::Quarter'),
          can: can('quarters.index'),
        },
        {
          link: route('plants.index'),
          text: 'menu.plants',
          icon: 'fa-brands fa-envira',
          active: currentComponent.startsWith('Fields::Plant'),
          can: can('plants.index'),
        },
      ],
    },
    {
      text: 'menu.harvest_management',
      children: [
        {
          link: route('harvests.index'),
          text: 'menu.harvest',
          icon: 'fa-solid fa-basket-shopping',
          active: currentComponent.startsWith('Fields::Harvests'),
          can: can('harvests.index'),
        },
        {
          link: route('harvests.details.create'),
          text: 'menu.harvest_details',
          icon: 'fa-solid fa-barcode',
          active: currentComponent.startsWith('Fields::HarvestDetails'),
          can: can('harvests.details.create'),
        },
        {
          link: route('batches.index'),
          text: 'menu.batch',
          icon: 'fa-solid fa-table-list',
          active: currentComponent.startsWith('Fields::Batches'),
          can: can('batches.index'),
        },
        {
          link: route('liquidations.index'),
          text: 'menu.liquidations',
          icon: 'fa-solid fa-file-invoice-dollar',
          active: currentComponent.startsWith('Fields::Liquidations'),
          can: can('liquidations.index'),
        },
      ],
    },
    {
      text: 'menu.task_management',
      children: [
        {
          link: route('tasks.index'),
          text: 'menu.tasks',
          icon: 'fa-solid fa-list-check',
          active: currentComponent.startsWith('Tasks::'),
          can: can('tasks.index'),
        },
      ],
    },
    {
      text: 'menu.records',
      children: [
        {
          link: route('machineries.index'),
          text: 'menu.machineries',
          icon: 'fa-solid fa-tractor',
          active: currentComponent.startsWith('Fields::Machineries'),
          can: can('machineries.index'),
        },
        {
          link: route('tools.index'),
          text: 'menu.tools',
          icon: 'fa-solid fa-wrench',
          active: currentComponent.startsWith('Fields::Tools'),
          can: can('tools.index'),
        },
        {
          link: route('security_equipments.index'),
          text: 'menu.security_equipments',
          icon: 'fa-solid fa-shield-heart',
          active: currentComponent.startsWith('Fields::SecurityEquipments'),
          can: can('security_equipments.index'),
        },
        // {
        //   link: route('suppliers.index'),
        //   text: 'menu.suppliers',
        //   icon: 'fa-solid fa-handshake',
        //   active: currentComponent.startsWith('Fields::Suppliers'),
        //   can: can('suppliers-index'),
        // },
      ],
    },
    // {
    //   text: 'menu.reports',
    //   children: [
    //     {
    //       link: route('users.index'),
    //       text: 'menu.report1',
    //       active: currentComponent.startsWith('Fields::Reports'),
    //       can: can('report-index'),
    //     },
    //   ],
    // },
    {
      text: 'menu.settings',
      children: [
        {
          link: route('users.index'),
          text: 'menu.users',
          icon: 'fa-solid fa-users',
          active: currentComponent.startsWith('Users::'),
          can: can('users.index'),
        },
        {
          link: route('dogs.index'),
          text: 'menu.dogs',
          icon: 'fa-solid fa-dog',
          active: currentComponent.startsWith('Fields::Dog'),
          can: can('dogs.index'),
        },
        // {
        //   link: route('alerts.index'),
        //   text: 'menu.alerts',
        //   icon: 'fa-solid fa-triangle-exclamation',
        //   active: currentComponent.startsWith('Fields::Alerts'),
        //   can: can('alerts.index'),
        // },
        {
          link: route('bulk.index'),
          text: 'menu.bulk_uploads',
          icon: 'fa-solid fa-file-arrow-up',
          active: currentComponent.startsWith('Fields::Bulk'),
          can: can('plants.create.bulk') || can('harvests.create.bulk'),
        },
      ],
    },
  ];

  const menuItemsFiltered = menuItems
    .map((item) => {
      const children = item.children.filter((child) => {
        return child.can;
      });

      return {
        ...item,
        children,
      };
    })
    .filter((item) => item.children.length > 0);

  return menuItemsFiltered;
};

export const menuElementsRight = (currentComponent) => {
  const menuItems = [
    {
      link: route('category_products.index'),
      text: 'menu.right.category_product',
      icon: '',
      active: currentComponent.startsWith('Fields::CategoryProducts'),
      can: can('category_products.index'),
    },
    {
      link: route('importers.index'),
      text: 'menu.right.importer',
      icon: '',
      active: currentComponent.startsWith('Fields::Importer'),
      can: can('importers.index'),
    },
    {
      link: route('owners.index'),
      text: 'menu.right.owner',
      icon: '',
      active: currentComponent.startsWith('Fields::Owner'),
      can: can('owners.index'),
    },
    {
      link: route('plant_types.index'),
      text: 'menu.right.plant_type',
      icon: '',
      active: currentComponent.startsWith('Fields::PlantType'),
      can: can('plant_types.index'),
    },
  ];

  const menuItemsFiltered = menuItems
    .filter((item) => item.can)
    .map((item) => ({
      ...item,
      can: can(item.can),
    }));

  return menuItemsFiltered;
};

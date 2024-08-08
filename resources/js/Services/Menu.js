import { can } from "@/Services/Auth";

export const menuElements = (currentComponent) => {
  const menuItems = [
    {
      text: 'menu.management',
      children: [
        {
          link: route('fields.index'),
          text: 'menu.fields',
          icon: 'fa-solid fa-table-cells',
          active: currentComponent.startsWith('Field'),
          can: can('field-index'),
        },
        {
          link: route('quarters.index'),
          text: 'menu.quarters',
          icon: 'fa-solid fa-table-cells-large',
          active: currentComponent.startsWith('Quarter'),
          can: can('quarter-index'),
        },
        {
          link: route('plants.index'),
          text: 'menu.plants',
          icon: 'fa-brands fa-envira',
          active: currentComponent.startsWith('Plant'),
          can: can('plant-index'),
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
          active: currentComponent.startsWith('Harvests'),
          can: can('harvest-index'),
        },
        {
          link: route('harvests.details.create'),
          text: 'menu.harvest_details',
          icon: 'fa-solid fa-barcode',
          active: currentComponent.startsWith('HarvestDetails'),
          can: can('harvest-create'),
        },
        {
          link: route('users.index'),
          text: 'menu.batch',
          icon: 'fa-solid fa-table-list',
          active: currentComponent.startsWith('Batchs'),
          can: can('batch-index'),
        },
        {
          link: route('users.index'),
          text: 'menu.liquidations',
          icon: 'fa-solid fa-file-invoice-dollar',
          active: currentComponent.startsWith('Liquidations'),
          can: can('liquidation-index'),
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
          active: currentComponent.startsWith('Tasks'),
          can: can('task-index'),
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
          active: currentComponent.startsWith('Machineries'),
          can: can('machinery-index'),
        },
        {
          link: route('tools.index'),
          text: 'menu.tools',
          icon: 'fa-solid fa-wrench',
          active: currentComponent.startsWith('Tools'),
          can: can('tool-index'),
        },
        {
          link: route('users.index'),
          text: 'menu.suppliers',
          icon: 'fa-solid fa-handshake',
          active: currentComponent.startsWith('Suppliers'),
          can: can('supply-index'),
        },
      ],
    },
    {
      text: 'menu.reports',
      children: [
        {
          link: route('users.index'),
          text: 'menu.report1',
          active: currentComponent.startsWith('Reports'),
          can: can('report-index'),
        },
      ],
    },
    {
      text: 'menu.settings',
      children: [
        {
          link: route('users.index'),
          text: 'menu.users',
          icon: 'fa-solid fa-users',
          active: currentComponent.startsWith('User'),
          can: can('user-index'),
        },
        {
          link: route('dogs.index'),
          text: 'menu.dogs',
          icon: 'fa-solid fa-dog',
          active: currentComponent.startsWith('Dog'),
          can: can('dog-index'),
        },
        {
          link: route('users.index'),
          text: 'menu.alerts',
          icon: 'fa-solid fa-triangle-exclamation',
          active: currentComponent.startsWith('Alerts'),
          can: can('alert-index'),
        },
        {
          link: route('bulk.index'),
          text: 'menu.bulk_uploads',
          icon: 'fa-solid fa-file-arrow-up',
          active: currentComponent.startsWith('Bulk'),
          can: can('plant-bulk-create') || can('harvest-bulk-create'),
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

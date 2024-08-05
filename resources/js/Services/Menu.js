const rolesAvailable = {
  farmer: 'agricultor',
  technician: 'tecnico',
  administrator: 'administrador',
  super_admin: 'super-admin',
};

export const menuElements = (currentComponent, userRoles) => {
  const menuItems = [
    {
      text: 'menu.management',
      children: [
        {
          link: route('fields.index'),
          text: 'menu.fields',
          icon: 'fa-solid fa-table-cells',
          active: currentComponent.startsWith('Field'),
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician],
        },
        {
          link: route('quarters.index'),
          text: 'menu.quarters',
          icon: 'fa-solid fa-table-cells-large',
          active: currentComponent.startsWith('Quarter'),
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician, rolesAvailable.farmer],
        },
        {
          link: route('plants.index'),
          text: 'menu.plants',
          icon: 'fa-brands fa-envira',
          active: currentComponent.startsWith('Plant'),
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician, rolesAvailable.farmer],
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
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician, rolesAvailable.farmer],
        },
        {
          link: route('harvests.details.create'),
          text: 'menu.harvest_details',
          icon: 'fa-solid fa-barcode',
          active: currentComponent.startsWith('HarvestDetails'),
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician, rolesAvailable.farmer],
        },
        {
          link: route('users.index'),
          text: 'menu.batch',
          icon: 'fa-solid fa-table-list',
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician, rolesAvailable.farmer],
        },
        {
          link: route('users.index'),
          text: 'menu.liquidations',
          icon: 'fa-solid fa-file-invoice-dollar',
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator],
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
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician, rolesAvailable.farmer],
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
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician],
        },
        {
          link: route('tools.index'),
          text: 'menu.tools',
          icon: 'fa-solid fa-wrench',
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician],
        },
        {
          link: route('users.index'),
          text: 'menu.suppliers',
          icon: 'fa-solid fa-handshake',
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator, rolesAvailable.technician],
        },
      ],
    },
    {
      text: 'menu.reports',
      children: [
        {
          link: route('users.index'),
          text: 'menu.report1',
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator],
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
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator],
        },
        {
          link: route('dogs.index'),
          text: 'menu.dogs',
          icon: 'fa-solid fa-dog',
          active: currentComponent.startsWith('Dog'),
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator],
        },
        {
          link: route('users.index'),
          text: 'menu.alerts',
          icon: 'fa-solid fa-triangle-exclamation',
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator],
        },
        {
          link: route('bulk.index'),
          text: 'menu.bulk_uploads',
          icon: 'fa-solid fa-file-arrow-up',
          active: currentComponent.startsWith('Bulk'),
          roles: [rolesAvailable.super_admin, rolesAvailable.administrator],
        },
      ],
    },
  ];

  const menuItemsFiltered = menuItems.map((item) => {
    const children = item.children.filter((child) => {
      return child.roles.includes(userRoles[0]);
    });

    return {
      ...item,
      children,
    };
  }).filter((item) => item.children.length > 0);

  return menuItemsFiltered;
};

import { usePage } from '@inertiajs/vue3';

let userPermissions = [];

export const can = (permission) => {
  if (userPermissions.length === 0) {
    const page = usePage();
    userPermissions = [...page.props.auth.user.permissions];
  }

  return userPermissions.includes(permission);
};

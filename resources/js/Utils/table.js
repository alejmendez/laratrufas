export const deleteRowTable = async (t, confirm, accept, entity = null) => {
  if (!entity) {
    entity = t('generics.tables.entity');
  }
  confirm.require({
    message: t('generics.tables.confirm.delete', { entity }),
    header: t('generics.tables.confirm.delete_header', { entity }),
    icon: 'pi pi-info-circle',
    rejectLabel: t('generics.tables.confirm.denyButton'),
    rejectProps: {
      label: t('generics.tables.confirm.denyButton'),
      severity: 'secondary',
      outlined: true,
    },
    acceptProps: {
      label: t('generics.tables.confirm.confirmButton'),
      severity: 'danger',
    },
    accept,
    reject: () => {},
  });
};

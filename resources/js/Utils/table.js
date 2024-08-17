export const deleteRowTable = async (t, confirm, accept) => {
  confirm.require({
    message: t('generics.tables.confirm.delete'),
    header: t('generics.tables.confirm.delete_header'),
    icon: 'pi pi-info-circle',
    rejectLabel: t('generics.tables.confirm.denyButton'),
    rejectProps: {
      label: t('generics.tables.confirm.denyButton'),
      severity: 'secondary',
      outlined: true
    },
    acceptProps: {
      label: t('generics.tables.confirm.confirmButton'),
      severity: 'danger'
    },
    accept,
    reject: () => {}
  });
};

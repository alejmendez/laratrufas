const createConfirmOptions = (t, entity, accept) => ({
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

const showToast = (toast, t, isSuccess = true) => {
  const config = isSuccess ? {
    severity: 'success',
    summary: t('generics.messages.deleted_successfully_summary'),
    detail: t('generics.messages.deleted_successfully'),
  } : {
    severity: 'danger',
    summary: t('generics.tables.errors.could_not_delete_the_record_summary'),
    detail: t('generics.tables.errors.could_not_delete_the_record'),
  };

  toast.add({
    ...config,
    life: 3000,
  });
};

const handleDeleteConfirmation = async (handler, datatable, toast, t) => {
  const result = await handler();

  if (result) {
    datatable.value.loadLazyData();
    showToast(toast, t, true);
    return;
  }

  showToast(toast, t, false);
};

export const deleteRowTable = async (t, confirm, accept, entity = null) => {
  const confirmOptions = createConfirmOptions(
    t,
    entity || t('generics.tables.entity'),
    accept
  );

  confirm.require(confirmOptions);
};

export const deleteRowDatatable = (options) => {
  const {
    datatable,
    confirm,
    toast,
    t,
    entity = t('generics.tables.entity'),
    handler,
  } = options;

  const confirmOptions = createConfirmOptions(
    t,
    entity,
    async () => await handleDeleteConfirmation(handler, datatable, toast, t)
  );

  confirm.require(confirmOptions);
};

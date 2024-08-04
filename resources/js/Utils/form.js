export const generateSubmitHandler = (form, url) => {
  return () => {
    form
      .post(url, {
        forceFormData: true,
      });
  }
};

export const generateSubmitHandler = (form, url) => {
  return () => {
    const json_v = JSON.stringify(form);
    console.log({
      form: json_v,
    });
    form.post(url, {
      forceFormData: true,
    });
  };
};

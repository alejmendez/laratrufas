import { format } from 'date-fns';

export const generateSubmitHandler = (form, url, transform) => {
  return () => {
    form
      .transform((data) => formTransform(data, transform))
      .post(url, {
        forceFormData: true,
      });
  }
};

export const formTransform = (data, transform) => {
  const transformValue = (value) => {
    if (typeof value === 'string' || typeof value === 'number') {
      return value;
    } else if (value instanceof Date) {
      return format(value, 'yyyy-MM-dd');
    } else if (Array.isArray(value)) {
      return value.map(item => (typeof item === 'object' && 'value' in item ? item.value : item));
    } else if (typeof value === 'object' && value !== null && 'value' in value) {
      return value.value;
    }
    return value; // Devuelve el valor sin cambios si no coincide con ningún caso
  };

  let transformedData = Object.keys(data).reduce((acc, key) => {
    acc[key] = transformValue(data[key]);
    return acc;
  }, {});

  if (transform) {
    transformedData = transform(transform);
  }

  return transformedData;
};

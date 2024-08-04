import { format } from 'date-fns';

export const generateSubmitHandler = (form, url, postProcessFunction) => {
  return () => {
    form
      // .transform((data) => formTransform(data, postProcessFunction))
      .post(url, {
        forceFormData: true,
      });
  }
};

export const formTransform = (originalData, postProcessFunction) => {
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

  const data = JSON.parse(JSON.stringify(originalData));

  const transformedData = Object.keys(data).reduce((acc, key) => {
    acc[key] = transformValue(data[key]);
    return acc;
  }, {});

  if (typeof postProcessFunction === 'function') {
    return postProcessFunction(transformedData);
  }

  return transformedData;
};

import axios from 'axios';

function transformFilters(obj) {
  // Clona el objeto para no mutar el original
  let newObj = JSON.parse(JSON.stringify(obj));

  // Recorre las claves dentro de 'filters'
  for (let key in newObj.filters) {
      let filter = newObj.filters[key];

      // Verifica si hay una propiedad 'value' y si es un array
      if (filter.value && typeof filter.value === 'object' && filter.value !== null) {
          // Mapea el array para obtener los valores numéricos dentro de 'value'
          filter.value = filter.value.value;
      }
  }

  return newObj;
}

const list = async (lazyParams) => {
  const response = await axios.get(route('harvests.index'), {
    params: {
      dt_params: JSON.stringify(transformFilters(lazyParams)),
    },
  });

  return response.data;
};

const del = async (id) => {
  await axios.delete(route('harvests.destroy', { id }));
  return true;
};

export default {
  list,
  del,
};

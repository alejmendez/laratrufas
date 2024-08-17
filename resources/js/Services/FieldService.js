import axios from 'axios';

const list = async (lazyParams) => {
  const response = await axios.get(route('fields.index'), {
    params: {
      dt_params: JSON.stringify(lazyParams),
    },
  });

  return response.data;
};

const del = async (id) => {
  await axios.delete(route('fields.destroy', { id }));
  return true;
};

export default {
  list,
  del,
};

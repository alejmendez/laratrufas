import axios from 'axios';

const list = async (lazyParams) => {
  const response = await axios.get(route('quarters.index'), {
    params: {
      dt_params: JSON.stringify(lazyParams),
    },
  });

  return response.data;
};

const del = async (id) => {
  await axios.delete(route('quarters.destroy', { id }));
  return true;
};

export default {
  list,
  del,
};

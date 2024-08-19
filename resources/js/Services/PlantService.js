import axios from 'axios';
import datatable from '@/Services/Datatable';

const list = async (lazyParams) => {
  const response = await datatable.list(route('plants.index'), lazyParams);

  return response.data;
};

const del = async (id) => {
  await axios.delete(route('plants.destroy', { id }));
  return true;
};

export default {
  list,
  del,
};

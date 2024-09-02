import axios from 'axios';
import datatable from '@/Services/Datatable';

const list = async (lazyParams) => {
  const response = await datatable.list(route('batches.index'), lazyParams);

  return response.data;
};

const del = async (id) => {
  await axios.delete(route('batches.destroy', { id }));
  return true;
};

export default {
  list,
  del,
};

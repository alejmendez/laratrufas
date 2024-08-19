import axios from 'axios';
import datatable from '@/Services/Datatable';

const list = async (lazyParams) => {
  const response = await datatable.list(route('machineries.index'), lazyParams);

  return response.data;
};

const del = async (id) => {
  await axios.delete(route('machineries.destroy', { id }));
  return true;
};

export default {
  list,
  del,
};

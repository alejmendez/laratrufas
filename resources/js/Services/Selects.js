import axios from 'axios';

export const getDataSelect = async (entity) => {
  const response = await axios.get(route('selects', { entity }));
  return response.data;
};

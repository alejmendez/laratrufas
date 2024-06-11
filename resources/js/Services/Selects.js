import axios from 'axios';

export const getDataSelect = async (entity, filter) => {
  const response = await axios.get(route('selects', { entity }), {
    params: {
      filter
    }
  });
  return response.data;
};

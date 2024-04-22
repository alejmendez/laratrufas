import axios from 'axios';

export const create = async (name) => {
  const response = await axios.post(route('plants.types.store'), { name });
  return response.data.type;
};

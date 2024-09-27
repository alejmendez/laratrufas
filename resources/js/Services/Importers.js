import axios from 'axios';

export const create = async (name) => {
  const response = await axios.post(route('importers.store'), { name });
  return response.data.importer;
};

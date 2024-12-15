import axios from 'axios';

const list = async (route) => {
  const response = await axios.get(route);
  return response.data.data;
};

const listByPlantId = async (id) => {
  return await list(route('plants.details', { id }));
};

const listByQuarterId = async (id) => {
  return await list(route('plants.details.by_quarter', { id }));
};

const listByFieldId = async (id) => {
  return await list(route('plants.details.by_field', { id }));
};

export default {
  listByPlantId,
  listByQuarterId,
  listByFieldId,
};

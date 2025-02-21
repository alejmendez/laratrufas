import axios from 'axios';

const list = async (route, show_harvests) => {
  const response = await axios.get(route, {
    params: {
      show_harvests,
    }
  });
  return response.data.data;
};

const listByPlantId = async (id, show_harvests) => {
  return await list(route('plants.details.index', { id }), show_harvests);
};

const listByQuarterId = async (id, show_harvests) => {
  return await list(route('plants.details.by_quarter', { id }), show_harvests);
};

const listByFieldId = async (id, show_harvests) => {
  return await list(route('plants.details.by_field', { id }), show_harvests);
};

export default {
  listByPlantId,
  listByQuarterId,
  listByFieldId,
};

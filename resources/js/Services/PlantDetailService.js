import axios from 'axios';

const list = async (route, show_harvests) => {
  const response = await axios.get(route, {
    params: {
      show_harvests,
    }
  });
  return response.data.data;
};

const listByPlantId = async (id, year, show_harvests) => {
  return await list(route('plants.details.index', { id, year }), show_harvests);
};

const listByQuarterId = async (id, year, show_harvests) => {
  return await list(route('plants.details.by_quarter', { id, year }), show_harvests);
};

const listByFieldId = async (id, year, show_harvests) => {
  return await list(route('plants.details.by_field', { id, year }), show_harvests);
};

export default {
  listByPlantId,
  listByQuarterId,
  listByFieldId,
};

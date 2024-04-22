import axios from 'axios';

export const findByCode = async (code) => {
  const response = await axios.get(route('harvests.details.find_by_code', { code }));
  return response.data.plant;
};

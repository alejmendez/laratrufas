import axios from 'axios';

const store = async (form) => {
  try {
    console.log(form);
    const formData = form.data();
    console.log(formData);
    await axios.post(route('harvests_details.store'), formData);
    return true;
  } catch (error) {
    return false;
  }
};

export default {
  store,
};

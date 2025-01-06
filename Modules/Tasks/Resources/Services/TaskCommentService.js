import axios from 'axios';

export const store = async (data) => {
  try {
    const response = await axios.post(route('task.comments.store'), {
      task_id: data.task_id,
      comment: data.comment,
    });
    return response.data.data;
  } catch (error) {
    throw new Error(error.response.data.message);
  }
};

export const update = async (id, data) => {
  try {
    const response = await axios.put(route('task.comments.update', { id }), {
      comment: data.comment,
    });
    return response.data.data;
  } catch (error) {
    throw new Error(error.response.data.message);
  }
};

export const destroy = async (id) => {
  try {
    await axios.delete(route('task.comments.destroy', { id }));
    return true;
  } catch (error) {
    return false;
  }
};

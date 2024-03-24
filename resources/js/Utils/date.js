export const getAge = (birthDate) => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e10);
export const stringToDate = (date) => {
  const [year, month, day] = date.split('-');
  return new Date(year, month - 1, day);
};

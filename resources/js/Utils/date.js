import { parse, parseISO, format } from 'date-fns';

export const getAge = (birthDate) => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e10);
export const stringToDate = (date) => {
  // Verifica si la fecha contiene una 'T', indicando un formato ISO
  if (date.includes('T')) {
    return parseISO(date);
  }
  return parse(date, 'yyyy-MM-dd', new Date());
};

export const dateToString = (date, f = 'dd/MM/yyyy') => {
  return format(date, f);
};

export const stringToFormat = (date, f = 'dd/MM/yyyy') => {
  return format(stringToDate(date), f);
};

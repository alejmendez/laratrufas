export const getAge = (birthDate) => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e10);
export const stringToDate = (date) => {
  // Si el texto no incluye una 'T', asumimos que es una fecha sin tiempo y agregamos 'T00:00:00Z'
  if (!date.includes('T')) {
    date += 'T00:00:00Z';
  }

  // Crea un nuevo objeto Date usando la cadena de texto
  let fecha = new Date(date);

  // Verifica si la fecha es válida
  if (isNaN(fecha.getTime())) {
      throw new Error("Fecha no válida");
  }

  return fecha;
};

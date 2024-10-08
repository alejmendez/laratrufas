import PrimeVue from 'primevue/config';
import { definePreset } from '@primevue/themes';
import Aura from '@primevue/themes/aura';

const AppPreset = definePreset(Aura, {
  semantic: {
    primary: {
      50: '{orange.50}',
      100: '{orange.100}',
      200: '{orange.200}',
      300: '{orange.300}',
      400: '{orange.400}',
      500: '{orange.500}',
      600: '{orange.600}',
      700: '{orange.700}',
      800: '{orange.800}',
      900: '{orange.900}',
      950: '{orange.950}',
    },
    formField: {
      height: '2.5rem',
      width: '100%',
    },
  },
});

export const initPrime = (app) => {
  app.use(PrimeVue, {
    theme: {
      preset: AppPreset,
      options: {
        prefix: 'p',
        darkModeSelector: '.dark-mode',
        cssLayer: false,
      },
    },
    locale: {
      startsWith: 'Comienza con',
      contains: 'Contiene',
      notContains: 'No contiene',
      endsWith: 'Termina con',
      equals: 'Igual a',
      notEquals: 'No igual a',
      noFilter: 'Sin filtro',
      lt: 'Menor que',
      lte: 'Menor o igual que',
      gt: 'Mayor que',
      gte: 'Mayor o igual que',
      dateIs: 'Fecha es',
      dateIsNot: 'Fecha no es',
      dateBefore: 'Fecha antes de',
      dateAfter: 'Fecha después de',
      clear: 'Limpiar',
      apply: 'Aplicar',
      matchAll: 'Coincidir todo',
      matchAny: 'Coincidir cualquiera',
      addRule: 'Agregar regla',
      removeRule: 'Eliminar regla',
      accept: 'Aceptar',
      reject: 'Rechazar',
      choose: 'Elegir',
      upload: 'Subir',
      cancel: 'Cancelar',
      completed: 'Completado',
      pending: 'Pendiente',
      fileSizeTypes: ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
      monthNames: [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre',
      ],
      monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      chooseYear: 'Elegir año',
      chooseMonth: 'Elegir mes',
      chooseDate: 'Elegir fecha',
      prevDecade: 'Década anterior',
      nextDecade: 'Década siguiente',
      prevYear: 'Año anterior',
      nextYear: 'Año siguiente',
      prevMonth: 'Mes anterior',
      nextMonth: 'Mes siguiente',
      prevHour: 'Hora anterior',
      nextHour: 'Hora siguiente',
      prevMinute: 'Minuto anterior',
      nextMinute: 'Minuto siguiente',
      prevSecond: 'Segundo anterior',
      nextSecond: 'Segundo siguiente',
      am: 'am',
      pm: 'pm',
      today: 'Hoy',
      weekHeader: 'Sem',
      firstDayOfWeek: 0,
      showMonthAfterYear: false,
      dateFormat: 'dd/mm/yy',
      weak: 'Débil',
      medium: 'Medio',
      strong: 'Fuerte',
      passwordPrompt: 'Introduce una contraseña',
      searchMessage: '{0} resultados disponibles',
      selectionMessage: '{0} elementos seleccionados',
      emptySelectionMessage: 'Ningún elemento seleccionado',
      emptySearchMessage: 'No se encontraron resultados',
      fileChosenMessage: '{0} archivos',
      noFileChosenMessage: 'Ningún archivo seleccionado',
      emptyMessage: 'No hay opciones disponibles',
      aria: {
        trueLabel: 'Verdadero',
        falseLabel: 'Falso',
        nullLabel: 'No seleccionado',
        star: '1 estrella',
        stars: '{star} estrellas',
        selectAll: 'Seleccionar todos los elementos',
        unselectAll: 'Deseleccionar todos los elementos',
        close: 'Cerrar',
        previous: 'Anterior',
        next: 'Siguiente',
        navigation: 'Navegación',
        scrollTop: 'Desplazar arriba',
        moveTop: 'Mover arriba',
        moveUp: 'Mover arriba',
        moveDown: 'Mover abajo',
        moveBottom: 'Mover abajo',
        moveToTarget: 'Mover al objetivo',
        moveToSource: 'Mover a la fuente',
        moveAllToTarget: 'Mover todo al objetivo',
        moveAllToSource: 'Mover todo a la fuente',
        pageLabel: 'Página {page}',
        firstPageLabel: 'Primera página',
        lastPageLabel: 'Última página',
        nextPageLabel: 'Página siguiente',
        prevPageLabel: 'Página anterior',
        rowsPerPageLabel: 'Filas por página',
        jumpToPageDropdownLabel: 'Saltar a página desplegable',
        jumpToPageInputLabel: 'Saltar a página de entrada',
        selectRow: 'Fila seleccionada',
        unselectRow: 'Fila deseleccionada',
        expandRow: 'Fila expandida',
        collapseRow: 'Fila colapsada',
        showFilterMenu: 'Mostrar menú de filtros',
        hideFilterMenu: 'Ocultar menú de filtros',
        filterOperator: 'Operador de filtro',
        filterConstraint: 'Restricción de filtro',
        editRow: 'Editar fila',
        saveEdit: 'Guardar edición',
        cancelEdit: 'Cancelar edición',
        listView: 'Vista de lista',
        gridView: 'Vista de cuadrícula',
        slide: 'Diapositiva',
        slideNumber: 'Diapositiva {slideNumber}',
        zoomImage: 'Ampliar imagen',
        zoomIn: 'Acercar',
        zoomOut: 'Alejar',
        rotateRight: 'Girar a la derecha',
        rotateLeft: 'Girar a la izquierda',
      },
    },
  });
};

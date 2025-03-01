export default {
  list: 'Lista',
  new: 'Nuevo',
  detail: 'Detalle',
  please_select: 'Seleccione',
  yes: 'Si',
  no: 'No',
  all: 'Todos',
  forbidden: 'Prohibido',
  messages: {
    saved: 'Guardado',
    saved_successfully: 'Guardado satisfactoriamente',
    deleted_successfully_summary: 'Eliminación',
    deleted_successfully: 'Eliminado satisfactoriamente',
    entity_not_found: 'Registro no encontrado, intente nuevamente',
  },
  errors: {
    trying_to_save: 'Error al intentar guardar',
    trying_to_delete: 'Error al intentar eliminar',
  },
  tables: {
    search: 'Buscar',
    actions: 'Acciones',
    entity: 'registro',
    confirm: {
      delete_header: 'Eliminar {entity}',
      delete: '¿Está seguro que desea eliminar el {entity}?',
      confirmButton: 'Aceptar',
      denyButton: 'Cancelar',
    },
    empty: 'No se encontraron registros',
    errors: {
      searching_for_information: 'Error al buscar información',
      could_not_delete_the_record_summary: 'Error al eliminar',
      could_not_delete_the_record: 'No se pudo eliminar el registro, intentelo luego',
      could_not_load_the_data_summary: 'Error al cargar los datos',
      could_not_load_the_data: 'No se pudo cargar los datos, intentelo luego',
    },
    pagination: {
      template: 'Mostrando del {from} al {to} de {total} registros',
      show: 'Mostrando',
      of: 'de',
    },
  },
  form: {
    file: {
      select_a_image: 'Seleccione un imagen',
      remove_image: 'Quitar imagen',
      select_a_file: 'Seleccione el archivo',
      upload_image: 'Cargar imagen',
      upload_file: 'Cargar archivo',
    },
    date: {
      label: 'Seleccione una fecha',
    },
    multiselect: {
      not_found: '¡Ups! No se han encontrado elementos. Considere la posibilidad de cambiar la consulta de búsqueda.',
    },
  },
  buttons: {
    create: 'Crear',
    save_edit: 'Guardar Cambios',
    cancel: 'Cancelar',
    filter: 'Filtrar',
  },
  actions: {
    create: 'Crear',
    edit: 'Editar',
    delete: 'Eliminar',
    show: 'Detalle',
    bulk: 'Carga Masiva',
  },
  date: {
    seconds_ago: 'hace {time} segundos',
    minutes_ago: 'hace {time} minutos',
    hours_ago: 'hace {time} horas',
    days_ago: 'hace {time} dias',
    months_ago: 'hace {time} meses',
    years_ago: 'hace {time} años',
  },
  bulk: {
    button: 'Carga Masiva',
    download_template: 'Descargar template',
    section_title: 'Recomendaciones',
    important: 'IMPORTANTE',
    instruction_1:
      'La carga masiva de datos es un proceso que te permite ingresar una gran cantidad de información en el sistema de forma rápida y eficiente. Para realizar la carga masiva de datos, debes seguir los siguientes pasos:',
    instruction_2: 'Descarga el template.',
    instruction_3: 'Abre el template de excel, guarda el archivo de excel en tu computador y rellena los datos que quieres cargar.',
    instruction_4: 'Haz clic en cargar archivo y elige el archivo de excel que guardaste en el paso anterior.',
    instruction_5:
      'Espera a que el sistema valide el archivo y te muestre un resumen de la carga. Si hay algún error o advertencia, corrígelo en el archivo de excel y repite el paso anterior. Si todo está correcto, haz clic en el botón de confirmar carga.',
    instruction_6: '¡Listo! El sistema te mostrará un mensaje de confirmación y podrás ver los datos cargados en el sistema.',
    instruction_7:
      'Cada fila representa un registro. Respeta el formato y el tipo de datos de cada columna. No modifiques ni elimines las cabeceras ni los nombres de las columnas. No apliques ningún filtro ni orden al archivo, ya que esto puede generar errores en la carga de la información.',
  },
};

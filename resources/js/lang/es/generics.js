export default {
  list: 'Lista',
  new: 'Nuevo',
  please_select: 'Seleccione',
  messages: {
    saved_successfully: 'Guardado satisfactoriamente',
    deleted_successfully: 'Eliminado satisfactoriamente',
    entity_not_found: 'Registro no encontrado, intente nuevamente',
  },
  errors: {
    trying_to_save: 'Error al intentar guardar',
  },
  tables: {
    search: 'Buscar',
    actions: 'Acciones',
    confirm: {
      delete: '¿Está seguro que desea eliminar el registro?',
      confirmButton: 'Aceptar',
      denyButton: 'Cancelar',
    },
    empty: 'No se encontraron registros',
    errors: {
      searching_for_information: 'Error al buscar información',
      could_not_delete_the_record: 'No se pudo eliminar el registro, intentelo luego',
    },
    pagination: {
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
      not_found: '¡Ups! No se han encontrado elementos. Considere la posibilidad de cambiar la consulta de búsqueda.'
    },
  },
  buttons: {
    create: 'Crear',
    save_edit: 'Guardar Cambios',
    cancel: 'Cancelar',
  },
  actions: {
    create: 'Crear',
    edit: 'Editar',
    bulk: 'Carga Masiva',
  },
  bulk: {
    button: 'Carga Masiva',
    download_template: 'Descargar template',
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
    alert: 'La carga de datos ha sido completada con éxito. Se han ingresado x registros de tipo de datos al sistema. ¡Buen trabajo!',
    error:
      'El sistema no ha podido procesar el archivo de excel. Hay algunos errores o advertencias que debes corregir antes de confirmar la carga. Puedes ver el detalle de los errores en el resumen de la carga.',
  },
};

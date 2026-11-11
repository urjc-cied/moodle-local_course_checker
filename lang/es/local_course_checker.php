<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_course_checker
 * @category    string
 * @copyright   2025 Stefan Dani, Fernfachhochschule Schweiz (FFHS) <stefan.dani@ffhs.ch>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Verificador de cursos';
$string['subplugintype_coursechecker'] = 'Verificador de cursos';
$string['subplugintype_coursechecker_plural'] = 'Verificadores de cursos';
$string['settings_name'] = 'Configuración general del verificador de cursos';
$string['plugin_enabled'] = '{$a}: habilitado.';
$string['plugin_disabled'] = '{$a}: deshabilitado.';
$string['settings_general'] = '<p>Recargue la página si habilita o deshabilita un plugin.</p>';
$string['settings_referencecourseid'] = 'ID del curso de referencia';
$string['course_checker:view'] = 'Ver el verificador de cursos';
$string['course_checker:runcheck'] = 'Ejecutar el verificador de cursos';
$string['course_checker:view_navigation'] = 'Mostrar el verificador de cursos en el menú de navegación';
$string['course_checker:managereportversions'] = 'Gestionar y ver las versiones guardadas de los informes de verificación del curso';

// Notification.
$string['course_checker:view_notification'] = 'Ver las notificaciones del verificador de cursos';
$string['messageprovider:checker_completed'] = 'Verificación del curso completada';
// String for messageprovider.
// Multiple checks.
$string['messageprovider_subject'] = 'Verificaciones completadas en el curso {$a}';
$string['messageprovider_completed'] = 'Las verificaciones se completaron.';
// Only one checks.
$string['messageprovider_singlechecks_subject'] = 'Verificación {$a->checkername} completada en el curso {$a->coursename}';
$string['messageprovider_singlechecks_completed'] = 'La verificación {$a->checkername} se completó.';
$string['messageprovider_result_label'] = 'Resultados';
$string['messageprovider_greeting'] = 'Hola';
$string['messageprovider_following_checks_completed'] = 'Se completaron las siguientes verificaciones:';
// Fail in check tasks.
$string['messageprovider:checker_failed'] = 'Falló la verificación del curso';
$string['messageprovider_subject_failed'] = 'Ocurrió un error durante la verificación del curso.';
$string['messageprovider_failed_notification_html'] = 'Hola, {$a->firstname}:<br><br>
Lamentablemente, el verificador de cursos no pudo completarse para el curso <strong>{$a->coursename}</strong>.<br><br>
Comuníquese con el administrador.';
$string['messageprovider_failed_notification_small'] = 'No se pudo completar la verificación del curso.';

// Versioning bar.
$string['checker_report_version'] = 'Versión del informe:';
$string['checker_version_latest'] = 'Más reciente';
$string['delete_all_results'] = 'Eliminar todos los resultados de verificación';
$string['delete_all_results_title'] = 'Eliminar resultados de verificación';
$string['delete_all_results_confirm'] = '¿Está seguro de que desea eliminar todos los resultados de verificación de este curso?';
$string['save_results'] = 'Guardar resultados';
$string['save_results_title'] = 'Guardar resultados de verificación';
$string['overwrite_results'] = 'Sobrescribir';
$string['overwrite_results_title'] = '¿Sobrescribir los resultados guardados?';
$string['overwrite_results_confirm'] = 'La versión de informe "{$a}" ya existe. ¿Desea sobrescribirla?';
$string['replace_oldest_report'] = 'Reemplazar el informe más antiguo';
$string['replace_oldest_report_title'] = 'Se alcanzó el límite de informes guardados';
$string['replace_oldest_report_confirm'] = 'Se alcanzó el límite de informes guardados. ¿Desea reemplazar el informe más antiguo, "{$a}"?';
$string['saved_report_limit_reached'] = 'Se alcanzó el límite de informes guardados. Confirme el reemplazo del informe más antiguo antes de guardar.';
$string['settings_enableversioning'] = 'Habilitar el control de versiones de informes';
$string['settings_enableversioning_desc'] = 'Habilita los controles para seleccionar, guardar y eliminar versiones de informes. Si el control de versiones está deshabilitado, todos los informes, excepto el más reciente de cada curso, se eliminarán durante la siguiente limpieza.';
$string['cleanup_reports_task'] = 'Limpiar los informes del verificador de cursos';
$string['settings_maxsavedreports'] = 'Máximo de informes guardados por curso';
$string['settings_maxsavedreports_desc'] = 'Número máximo de informes con nombre que se almacenan por curso. Los informes más antiguos que excedan el límite se eliminan durante la siguiente limpieza. Use 0 para no establecer un límite.';
$string['version_name'] = 'Nombre de la versión';
$string['version_name_required'] = 'Ingrese un nombre de versión.';
$string['version_name_exists'] = 'Ya existe una versión de informe con este nombre.';
$string['version_name_invalid'] = 'El nombre de la versión solo puede contener letras, números, guiones y guiones bajos.';
$string['version_name_too_long'] = 'El nombre de la versión no debe tener más de 20 caracteres.';
$string['versioningdisabled'] = 'El control de versiones de informes está deshabilitado.';

// Result page.
$string['checker_last_run'] = 'Última ejecución: {$a}';
$string['checker_never_run'] = 'Nunca';
$string['failed_checks'] = 'Fallidas';
$string['failed_checks_help'] = 'Una o más verificaciones detectaron problemas que no cumplen los criterios requeridos y deben corregirse.';
$string['error_checks'] = 'Error';
$string['error_checks_help'] = 'Una o más verificaciones presentaron errores técnicos o excepciones de código. Comuníquese con su administrador.';
$string['error_contact_admin'] = 'La verificación no pudo completarse debido a un error interno. Informe este incidente a su administrador.';
$string['warning_checks'] = 'Advertencia';
$string['warning_checks_help'] = 'Una o más verificaciones detectaron posibles problemas que podrían requerir atención, aunque no son necesariamente críticos.';
$string['info_checks'] = 'Información';
$string['info_checks_help'] = 'Una o más verificaciones ofrecen notas informativas o sugerencias de mejora.';
$string['successful_checks'] = 'Correctas';
$string['successful_checks_help'] = 'Estas verificaciones se completaron correctamente y no encontraron problemas.';
$string['running_checks'] = 'En ejecución';
$string['running_checks_help'] = 'Estas verificaciones se están ejecutando. Espere a que terminen.';
$string['check_course'] = 'Verificar este curso';
$string['check_course_in_progress'] = 'Verificación en curso...';

// Event log translations.
$string['activity'] = 'Actividad';
$string['activity_help'] = 'El registro de actividad muestra los cambios realizados en el curso (como actividades creadas, actualizadas o eliminadas) desde la última vez que se ejecutó el verificador de cursos.';
$string['last_modified_activity'] = 'Actividades modificadas desde la última verificación';
$string['action'] = 'Acción';
$string['course'] = 'Curso';
$string['course_section'] = 'Sección';
$string['user'] = 'Usuario';
$string['timestamp'] = 'Fecha y hora';
$string['details'] = 'Detalles';
$string['created'] = 'Creado';
$string['updated'] = 'Actualizado';
$string['deleted'] = 'Eliminado';
$string['unknown'] = 'Desconocido';

// Custom Admin Settings.
$string['admin_setting_regex_invalidregex'] = 'La expresión regular proporcionada no es válida. Revise la sintaxis.';

$string['admin_setting_coursesregex'] = 'Filtro de expresión regular para el nombre completo del curso';
$string['admin_setting_coursesregex_help'] =
        'Defina la expresión regular para permitir este verificador únicamente en los cursos cuyo nombre completo coincida con ella.';
$string['admin_setting_coursesregex_skip_course'] = 'La verificación omitió este curso';
$string['admin_setting_coursesregex_skip_course_desc'] = 'La expresión regular no coincidió con el nombre completo del curso.';

$string['admin_setting_restrictedint_min'] = 'El valor mínimo es {$a}';
$string['admin_setting_restrictedint_max'] = 'El valor máximo es {$a}';

// String specific for the resolution link helper.
$string['checker_links_activity'] = 'Actividad: {$a->name} ({$a->modname})';
$string['groups_activity'] = 'Actividad "{$a->name}"';

// Tasks.
$string['queue_check_task'] = 'Poner la verificación en cola';
$string['run_checker_task'] = 'Ejecutar la verificación';
$string['send_notification_task'] = 'Enviar notificación';

// Privacy provider.
$string['privacy:metadata:local_course_checker_event'] = 'Almacena los eventos y registros de actividad del verificador de cursos.';
$string['privacy:metadata:userid'] = 'El ID del usuario que originó el evento.';
$string['privacy:metadata:relateduserid'] = 'El usuario relacionado al que afecta el evento.';
$string['privacy:metadata:checker_id'] = 'El ID de la ejecución del verificador.';
$string['privacy:metadata:action'] = 'La acción realizada (por ejemplo: creada, actualizada, eliminada).';
$string['privacy:metadata:target'] = 'El objeto de destino (por ejemplo: course_module).';
$string['privacy:metadata:objectid'] = 'El ID del objeto afectado.';
$string['privacy:metadata:other'] = 'Datos adicionales del evento en formato JSON.';
$string['privacy:metadata:timecreated'] = 'La fecha y hora en que se creó el evento.';
$string['progress_queued'] = 'Preparando las verificaciones…';
$string['progress_pending'] = 'Verificando el curso… Quedan {$a} verificaciones por terminar. Esta página se actualizará sola.';
$string['progress_done'] = 'Verificación terminada. Cargando los resultados…';
$string['result_group_error'] = 'Errores de ejecución';
$string['result_group_failed'] = 'Fallidos';
$string['result_group_warning'] = 'Advertencias';
$string['result_group_info'] = 'Información';
$string['result_group_successful'] = 'Correctos';

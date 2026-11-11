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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'coursechecker_referencesettings'.
 *
 * @package    coursechecker_referencesettings
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de la configuración de referencia';
$string['pluginname_help'] = 'Esta verificación compara la configuración general seleccionada del curso con un curso de referencia y, además, puede comparar los estados de los filtros del curso y las opciones de formato del curso. También puede exigir una imagen de curso y una fecha de inicio sin fecha de fin; estas dos reglas no se aplican al curso de referencia. Solo se verifican los grupos de configuración establecidos; las propiedades de curso seleccionadas que no estén disponibles se informan como fallos. También compara los nombres y la configuración de las categorías del calificador.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
// String specific for the reference course settings checker.
$string['referencesettings_comparison'] =
        ' (Curso de referencia: "{$a->settingvaluereference}" | Curso actual: "{$a->settingvaluecurrent}")';
$string['referencesettings_settingismissing'] = '"{$a->setting}" no es una configuración de curso disponible.';
$string['referencesettings_failing'] = 'La configuración "{$a->setting}" no es correcta {$a->comparison}';
$string['referencesettings_success'] = 'La configuración "{$a->setting}" es correcta';
$string['referencesettings_checklist'] = 'Lista de configuraciones que se comprobarán con el curso de referencia';
$string['referencesettings_checklist_help'] = 'Seleccione una o varias configuraciones para comprobarlas con el curso de referencia.';
// String specific for the reference course settings checker filters.
$string['referencefilter_comparison'] =
        ' (Curso de referencia: "{$a->filtervaluereference}" | Curso actual: "{$a->filtervaluecurrent}")';
$string['referencefilter_failing'] = 'El filtro "{$a->filterkey}" no es correcto {$a->comparison}';
$string['referencefilter_success'] = 'Todos los filtros están configurados correctamente en el curso actual';
$string['referencefilter_enabled'] = 'Verificación de filtros de la configuración de referencia habilitada';
$string['referencefilter_enabled_help'] = 'Habilite esta opción para comparar todos los filtros del curso con el curso de referencia.';
$string['referencefilter_filternotsetincurrentcourse'] = 'Falta el filtro "{$a->filterkey}" en el curso actual.';
$string['referenceformatoptions_failing'] = 'La opción de formato "{$a->optionkey}" no es correcta {$a->comparison}';
$string['referenceformatoptions_success'] = 'Todas las opciones de formato están configuradas correctamente en el curso actual';
$string['referenceformatoptions_enabled'] = 'Verificación de opciones de formato de la configuración de referencia habilitada';
$string['referenceformatoptions_enabled_help'] =
        'Habilite esta opción para comparar todas las opciones de formato del curso con el curso de referencia.';
// Course image and dates.
$string['referencesettings_dates_success'] = 'El curso tiene fecha de inicio y no tiene fecha de fin';
$string['referencesettings_enddate_set'] = 'El curso tiene fecha de fin ({$a->enddate}). Debe tener solo fecha de inicio.';
$string['referencesettings_gradecategories_success'] = 'El calificador tiene las categorías del curso de referencia: {$a->expected}.';
$string['referencesettings_gradecategory_extra'] = 'La categoría "{$a->name}" del calificador sobra: el calificador debe tener solo las categorías del curso de referencia ({$a->expected}).';
$string['referencesettings_gradecategory_missing'] = 'Falta la categoría "{$a->name}" en el calificador.';
$string['referencesettings_image_missing'] = 'El curso no tiene imagen de curso.';
$string['referencesettings_image_success'] = 'El curso tiene imagen de curso';
$string['referencesettings_requiregradecategories'] = 'Exigir las categorías del calificador';
$string['referencesettings_requiregradecategories_help'] = 'El calificador debe tener exactamente las categorías del curso de referencia, comparadas por su nombre. No se distinguen mayúsculas.';
$string['referencesettings_comparegradecategorysettings'] = 'Comparar la configuración de las categorías del calificador';
$string['referencesettings_comparegradecategorysettings_help'] = 'Compara con el curso de referencia la configuración de cada categoría del calificador con el mismo nombre y del total del curso: cálculo total, calificaciones vacías, resultados, calificaciones descartadas o mantenidas, tipo de calificación, calificaciones máxima, mínima y para aprobar, visibilidad, modo de mostrar, decimales y peso o puntos extra. Solo se aplica si se exigen las categorías del calificador.';
$string['referencesettings_gradecategory_setting_failing'] = 'La configuración "{$a->setting}" de la categoría "{$a->category}" del calificador no es correcta{$a->comparison}';
$string['referencesettings_gradecategory_settings_success'] = 'La categoría "{$a->category}" del calificador tiene la misma configuración que el curso de referencia.';
$string['referencesettings_requireimage'] = 'Exigir imagen de curso';
$string['referencesettings_requireimage_help'] = 'Comprueba que el curso tenga una imagen. No se aplica al curso de referencia.';
$string['referencesettings_requirestartdateonly'] = 'Exigir solo fecha de inicio';
$string['referencesettings_requirestartdateonly_help'] = 'Comprueba que el curso tenga fecha de inicio y no tenga fecha de fin. No se aplica al curso de referencia.';
$string['referencesettings_startdate_missing'] = 'El curso no tiene fecha de inicio.';

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
 * Strings for component 'coursechecker_rubrics_settings'.
 *
 * @package     coursechecker_rubrics_settings
 * @copyright   2026 Stefan Dani, Fernfachhochschule Schweiz (FFHS) <stefan.dani@ffhs.ch>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de la configuración de rúbricas';
$string['pluginname_help'] = 'Esta verificación examina las tareas que tienen habilitada una rúbrica como método de calificación avanzada. El tipo de calificación debe ser puntuación y no escala. También debe estar disponible un formulario de calificación con rúbrica activo. Si el formulario falta o sigue en estado de borrador, se emite una advertencia. Si la puntuación máxima de la rúbrica no coincide con la calificación máxima de la configuración de la tarea, se informa un error. No se verifican las tareas sin una rúbrica activa.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
$string['rubric_grade_type_scale'] = 'Al usar una rúbrica, el tipo de calificación debe ser "Puntuación". Actualmente está seleccionada una escala.';
$string['rubric_grade_type_none'] = 'Al usar una rúbrica, el tipo de calificación debe ser "Puntuación".';
$string['rubric_points_mismatch'] = 'La puntuación máxima de la rúbrica ({$a->rubric_max}) no coincide con la calificación máxima de la configuración de la tarea ({$a->assign_grade}).';
$string['rubric_points_success'] = 'Los puntos de la rúbrica coinciden con la configuración de la tarea.';

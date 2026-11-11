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
 * Strings for component 'coursechecker_submission_feedbacktype'.
 *
 * @package    coursechecker_submission_feedbacktype
 * @copyright  2026 Stefan Dani, Fernfachhochschule Schweiz (FFHS) <stefan.dani@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación del tipo de retroalimentación de tareas';
$string['pluginname_help'] = 'Esta verificación examina las tareas que tienen habilitado un tipo de entrega de texto en línea, archivos enviados o video de Kaltura, y exige al menos un tipo de retroalimentación habilitado. Se ignoran las tareas que no tienen ninguno de estos tres tipos de entrega; los demás tipos de entrega habilitados no activan por sí solos la verificación.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
$string['submission_feedbacktype_error'] = 'La tarea tiene tipos de entrega habilitados, pero ningún tipo de retroalimentación habilitado. Habilite al menos un tipo de retroalimentación.';
$string['submission_feedbacktype_success'] = 'La tarea tiene al menos un tipo de retroalimentación habilitado.';

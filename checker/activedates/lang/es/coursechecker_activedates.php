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
 * Strings for component 'coursechecker_activedates'.
 *
 * @package    coursechecker_activedates
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$string['pluginname'] = 'Verificación de fechas activas';
$string['pluginname_help'] = 'Esta verificación examina las actividades visibles y accesibles de los tipos configurados e informa las fechas de finalización habilitadas o los campos de disponibilidad y fecha límite propios de cada actividad. No se verifican los cursos excluidos por el patrón de nombre de curso configurado, los tipos de actividad no configurados ni las actividades ocultas o no accesibles.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
// String specific for the activedates checker.
$string['activedates_setting_modules'] = 'Módulos habilitados';
$string['activedates_setting_modules_help'] = 'Defina los módulos permitidos (deben estar habilitados en <a href="{$a}" target="_blank">Gestionar actividades</a>) en los que se verificarán las fechas activas.';
$string['activedates_noactivedates'] = 'La fecha de finalización esperada no debe estar habilitada.';
$string['activedates_noactivedatesinactivity'] = 'La actividad <b>{$a->modtype}</b> tiene fechas habilitadas en los siguientes campos: <b>{$a->adateissetin}</b>.';
$string['activedates_success'] = 'La actividad {$a} no tiene fechas habilitadas.';

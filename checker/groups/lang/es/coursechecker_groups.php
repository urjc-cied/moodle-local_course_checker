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
 * Strings for component 'coursechecker_groups'.
 *
 * @package    coursechecker_groups
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de entrega por grupos';
$string['pluginname_help'] = 'Esta verificación examina cada tarea visible para el usuario que tenga una página de visualización. Las tareas sin entrega por grupos se aprueban; cuando la entrega por grupos está habilitada, se requiere un agrupamiento válido que contenga al menos dos grupos. No se verifican las tareas ocultas o no accesibles por otro motivo.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
// String specific for the group checker.
$string['groups_deactivated'] = 'La configuración de entrega por grupos está desactivada';
$string['groups_idmissing'] = 'La entrega por grupos está activa, pero no se ha establecido ningún agrupamiento';
$string['groups_missing'] = 'El agrupamiento no se configuró correctamente';
$string['groups_lessthantwogroups'] = 'Se configuraron menos de 2 grupos para el agrupamiento activo';
$string['groups_success'] = 'La configuración de entrega por grupos está bien definida';
$string['groups_activity'] = 'Actividad "{$a->name}"';

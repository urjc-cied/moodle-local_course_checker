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
 * Strings for component 'coursechecker_blocks'.
 *
 * @package    coursechecker_blocks
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación del cajón de bloques';
$string['pluginname_help'] = 'Esta verificación compara la presencia de cada bloque configurado en el curso actual con su presencia en el curso de referencia e informa los bloques que existen solo en uno de ellos. Se ignoran los bloques ausentes en ambos cursos, y no se comparan su configuración, posición ni región.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
$string['blocks_setting'] = 'Bloques habilitados';
$string['blocks_setting_help'] =
        'Defina los bloques permitidos (deben estar habilitados en la página <a href="{$a}" target="_blank">Bloques</a>) que se verificarán.';
$string['blocks_comparison'] = '(Curso de referencia: "{$a->valuereference}" | Curso actual: "{$a->valuecurrent}")';
$string['blocks_success'] = 'El bloque está insertado correctamente en el curso actual';
$string['blocks_error'] = 'El bloque está presente por error o falta en el curso actual.';
$string['blocks_activity'] = 'Bloque "{$a->name}"';

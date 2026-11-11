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
 * Strings for component 'coursechecker_userdata'.
 *
 * @package    coursechecker_userdata
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de datos de usuario';
$string['pluginname_help'] = 'Esta verificación busca contenido existente de bases de datos, glosarios, wikis o foros en las actividades visibles y accesibles de los tipos compatibles configurados. Se ejecuta solo en los cursos que coinciden con el patrón de curso configurado; se ignoran los tipos no compatibles o deshabilitados, y se omiten las actividades cuyos nombres coinciden con la expresión regular de la lista blanca configurada.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
// String specific for the userdata checker.
$string['userdata_setting_modules'] = 'Módulos habilitados';
$string['userdata_setting_modules_help'] = 'Defina los módulos permitidos (deben estar habilitados en <a href="{$a}" target="_blank">Gestionar actividades</a>, contener el método reset_userdata en <code>mod/{modname}/lib.php</code> y ser compatibles con este plugin) en los que se verificarán los datos de usuario.';
$string['userdata_error'] = 'No debería haber datos de usuario en la actividad {$a}.';
$string['userdata_success'] = 'La actividad {$a} no contiene datos de usuario.';
$string['userdata_skip'] = 'La actividad "{$a}" se omitió porque está en la lista blanca.';
$string['userdata_help'] = 'Si desea que estos datos se copien a otros cursos, debe importarlos manualmente. Estos son algunos manuales útiles (en inglés): <a href="https://docs.moodle.org/38/en/Backup_of_user_data" target="_blank">Copia de seguridad de datos de usuario</a> y <a href="https://docs.moodle.org/38/en/Reusing_activities" target="_blank">Reutilización de actividades</a>.';
$string['regex_forum_whitelist'] = 'Lista blanca de foros';
$string['regex_forum_whitelist_desc'] = 'Los foros cuyos nombres coinciden con la expresión regular especificada se excluyen de la verificación.';

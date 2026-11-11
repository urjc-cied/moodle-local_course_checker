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
 * Strings for component 'coursechecker_subheadings'.
 *
 * @package    coursechecker_subheadings
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de subtítulos en áreas de texto y medios';
$string['pluginname_help'] = 'Esta verificación examina las actividades visibles de tipo Área de texto y medios, y exige que su primer elemento de contenido sea un encabezado <code>h4</code> que contenga un icono de Font Awesome. Se ignoran los demás tipos de actividad y las actividades ocultas, y se acepta sin estos criterios el contenido que incluya una cadena de la lista blanca configurada.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
// String specific for the subheadings checker.
$string['subheadings_wrongfirsthtmltag'] = 'La primera etiqueta HTML no es {$a->htmltag}.';
$string['subheadings_iconmissing'] = 'Falta el icono en la primera etiqueta HTML.';
$string['subheadings_generalerror'] = 'Ocurrió un problema al ejecutar esta verificación.';
$string['subheadings_success'] = 'Esta Área de texto y medios tiene un subtítulo y un icono válidos.';
$string['subheadings_labelignored'] = 'Esta área se ignora debido a la lista blanca de la configuración del plugin.';
$string['subheadings_setting_whitelist'] = 'Lista blanca de cadenas del verificador de subtítulos';
$string['subheadings_setting_whitelist_help'] = 'Agregue una cadena por línea. Ejemplo: "Estimado(a) desarrollador(a) del módulo".';

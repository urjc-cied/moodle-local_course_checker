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
 * Strings for component 'coursechecker_links'.
 *
 * @package    coursechecker_links
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de enlaces';
$string['pluginname_help'] = 'Esta verificación extrae los enlaces HTTP y HTTPS del resumen del curso, de los nombres, las introducciones y el contenido de las actividades, de los capítulos de libros y de las páginas wiki, y comprueba directamente si las actividades de URL son accesibles y si coinciden con los patrones de páginas de error HTML configurados. Solo los códigos HTTP y los errores de conexión configurados son error; los demás son avisos para comprobar manualmente. Se omiten las URL exactas y los dominios incluidos en las listas blancas configuradas, así como las solicitudes bloqueadas por las políticas de seguridad de Moodle.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
// Results.
$string['course_summary'] = 'Resumen del curso';
$string['book_chapter'] = 'Capítulo del libro: {$a->title}';
$string['wiki_page'] = 'Página wiki: {$a->title}';
$string['filetype_unknown'] = 'Archivo desconocido';
$string['filetype_html'] = 'Documento HTML';
$string['filetype_pdf'] = 'PDF';
$string['filetype_zip'] = 'ZIP';
$string['filetype_image'] = 'Imagen';
$string['url_code_valid'] = 'El enlace <b>{$a->url}</b> es accesible <b>(Estado {$a->http_code})</b>.'; // You can get any curl info or pare_url field in $a.
$string['error_code'] = 'No se pudo acceder al enlace <b>{$a->url}</b> <b>(Error {$a->http_code})</b>.'; // You can get any curl info or pare_url field in $a.
$string['error_curl'] = 'Error de conexión para <b>{$a->url}: {$a->curl_error} (Código {$a->curl_errno})</b>.'; // You can get any curl info or pare_url field in $a.
$string['error_undefined'] = 'El enlace <b>no es válido o tiene un formato incorrecto</b>.';
$string['error_httpsecurity'] = 'El enlace <b>{$a}</b> está bloqueado por las <b>políticas de seguridad de Moodle</b> y, por lo tanto, <b>no se verificó</b>.';
$string['domain_is_whitelisted'] = 'El dominio <b>{$a->host}</b> está en la <b>lista de excepciones</b> (lista blanca). Por lo tanto, el enlace <b>{$a->url}</b> <b>no se verificó</b>.';
$string['url_is_whitelisted'] = 'El enlace <b>{$a->url}</b> está en la <b>lista de excepciones</b> (lista blanca) y <b>no se verificó</b>.';
$string['html_error_detected'] = 'El enlace <b>{$a->url}</b> parece llevar a una <b>página de error</b>, aunque la conexión fue correcta (Estado {$a->http_code}). <b>Compruebe el enlace manualmente.</b>';
// Settings.
$string['timeout_setting'] = 'Tiempo de espera de cURL';
$string['timeout_setting_desc'] = 'Tiempo para conectarse al servidor e intercambiar datos.';
$string['connect_timeout_setting'] = 'Tiempo de espera de conexión de cURL';
$string['connect_timeout_setting_desc'] = 'Tiempo para conectarse al servidor.';
$string['useragent_setting'] = 'Agente de usuario';
$string['useragent_setting_desc'] = 'El agente de usuario le indica a un sitio web qué navegador se está utilizando.';
$string['url_whitelist_setting'] = 'Lista blanca de URL';
$string['url_whitelist_setting_desc'] = 'Esta lista exceptúa únicamente la URL. Agregue una URL por línea, por ejemplo: <code>https://moodle.org</code>';
$string['domain_whitelist_setting'] = 'Lista blanca de dominios';
$string['domain_whitelist_setting_desc'] = 'Esta lista exceptúa todo el dominio. Agregue una URL por línea, por ejemplo: <code>https://moodle.org</code>';
$string['html_error_regex_setting'] = 'Expresión regular para detectar errores HTML';
$string['html_error_regex_setting_desc'] = 'Expresión regular que se usa para detectar páginas de error que aun así devuelven HTTP 200. Ejemplo: páginas que contienen "Error 404" o "Page not found".';
$string['unverifiable_code'] = 'No se pudo verificar el enlace <b>{$a->url}</b> <b>(Estado {$a->http_code})</b>: el sitio puede pedir iniciar sesión o bloquear las verificaciones automáticas. <b>Compruébelo manualmente.</b>';
$string['unverifiable_curl'] = 'No se pudo verificar el enlace <b>{$a->url}</b>: {$a->curl_error} (Código {$a->curl_errno}). <b>Compruébelo manualmente.</b>';
$string['error_codes_setting'] = 'Códigos HTTP que son error';
$string['error_codes_setting_desc'] = 'Códigos de respuesta que indican que el enlace está roto, separados por comas. Los demás códigos de error se informan como aviso para comprobarlos manualmente, porque muchos sitios responden 401, 403, 429 o 999 a las verificaciones automáticas o piden iniciar sesión (por ejemplo, LinkedIn), aunque funcionen en el navegador.';
$string['curl_errors_setting'] = 'Errores de conexión que son error';
$string['curl_errors_setting_desc'] = 'Códigos de error de cURL que indican que el enlace está roto, separados por comas. Por defecto, 6: el dominio no existe. Los demás errores de conexión, como un tiempo de espera agotado (28) o un certificado no válido (60), se informan como aviso.';
$string['concurrency_setting'] = 'Enlaces simultáneos';
$string['concurrency_setting_desc'] = 'Cantidad de enlaces que se consultan a la vez. Un valor más alto termina antes, pero algunos sitios pueden bloquear muchas consultas seguidas.';

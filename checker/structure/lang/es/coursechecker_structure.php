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
 * Strings for component 'coursechecker_structure'.
 *
 * @package    coursechecker_structure
 * @copyright  2026 URJCx
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de la estructura del curso';
$string['pluginname_help'] = 'Esta verificación compara el curso con la plantilla, que es el curso de referencia del verificador. Se aplica a los cursos de la categoría de la plantilla y sus subcategorías. Valida las secciones fijas y su orden, con una cantidad variable de módulos numerados; que los foros de las secciones fijas de la plantilla existan con la misma configuración; y que cada módulo tenga su examen. Al comparar secciones y foros se ignoran los símbolos iniciales, como los emojis, y las mayúsculas. La descripción de los foros no se compara; el foro que debe tener normas de uso no puede tener la descripción vacía. No se verifican las subsecciones y se ignoran los demás elementos del curso. También valida que los exámenes sean requisito de la finalización del curso, combinados como en la plantilla; otra actividad requerida es un aviso.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';

$string['structure_completion'] = 'Finalización del curso';
$string['structure_completion_activities'] = 'Actividades completadas';
$string['structure_completion_aggregation'] = 'La finalización del curso no tiene la configuración de la plantilla en "{$a->setting}": la plantilla tiene "{$a->expected}" y este curso tiene "{$a->actual}".';
$string['structure_completion_exam_missing'] = 'El examen "{$a->name}" no está entre las actividades requeridas para la finalización del curso.';
$string['structure_completion_method_1'] = 'Se deben cumplir todos';
$string['structure_completion_method_2'] = 'Basta con cumplir uno';
$string['structure_completion_other'] = 'La actividad "{$a->name}" está en la finalización del curso, pero solo deberían estar los exámenes.';
$string['structure_completion_overall'] = 'Requisitos de finalización del curso';
$string['structure_completion_success'] = 'Los {$a->count} exámenes del curso están en la finalización del curso.';
$string['structure_completionview'] = 'Requerir que se vea la actividad';
$string['structure_course'] = 'Estructura del curso';
$string['structure_exam_duplicate'] = 'El módulo {$a->number} tiene más de un examen: {$a->names}. Debe tener solo uno.';
$string['structure_exam_hidden'] = 'El examen "{$a->name}" está oculto.';
$string['structure_exam_missing'] = 'Falta el examen del módulo {$a->number}: un cuestionario con "{$a->text}" en el nombre.';
$string['structure_exam_outside'] = 'El examen "{$a->name}" está en la sección "{$a->section}". Debe estar dentro de su módulo.';
$string['structure_format_invalid'] = 'El formato "{$a->format}" no es válido: debe contener N, que representa el número del módulo. Corríjalo en los ajustes de esta verificación.';
$string['structure_forum_duplicate'] = 'El foro "{$a->name}" está repetido en la sección "{$a->section}".';
$string['structure_forum_missing'] = 'Falta el foro "{$a->name}" en la sección "{$a->section}".';
$string['structure_forum_rules_empty'] = 'La descripción del {$a->name} no incluye normas de uso.';
$string['structure_forum_setting'] = 'El foro "{$a->name}" no tiene la configuración de la plantilla en "{$a->setting}": la plantilla tiene "{$a->expected}" y este curso tiene "{$a->actual}".';
$string['structure_is_template'] = 'Este curso es la plantilla con la que se comparan los demás cursos, por lo que no se verifica.';
$string['structure_module_number'] = 'La sección "{$a->name}" tiene el número {$a->number}, pero se esperaba el número {$a->expected}. Los módulos deben numerarse de forma consecutiva desde 1.';
$string['structure_modules_missing'] = 'El curso no tiene secciones de módulo. Sus nombres deben empezar con el formato "{$a->format}".';
$string['structure_not_applicable'] = 'Este curso no está en la categoría de la plantilla, por lo que no se verifica.';
$string['structure_section_duplicate'] = 'La sección "{$a->name}" está repetida.';
$string['structure_section_missing'] = 'Falta la sección "{$a->name}".';
$string['structure_section_order'] = 'La sección "{$a->name}" está fuera de orden. El orden esperado es: {$a->order}.';
$string['structure_section_unexpected'] = 'La sección "{$a->name}" no forma parte de la estructura. Una sección de módulo debe empezar con el formato "{$a->format}" seguido de su nombre. El orden esperado es: {$a->order}.';
$string['structure_setting_moduleformat'] = 'Formato de módulo';
$string['structure_setting_moduleformat_desc'] = 'Cómo debe empezar el nombre de una sección de módulo, donde N representa su número. Debe ir seguido de un espacio y el nombre del módulo. Por ejemplo, "N." acepta "1. Introducción al tema". Las demás secciones de la plantilla son obligatorias en todos los cursos.';
$string['structure_setting_rulesforum'] = 'Foro con normas de uso';
$string['structure_setting_rulesforum_desc'] = 'Nombre del foro cuya descripción debe incluir normas de uso. Si está vacía se muestra un error; puede tener el mismo texto que la plantilla. Déjelo en blanco para no aplicar esta regla.';
$string['structure_success'] = 'El curso respeta la estructura de la plantilla: {$a->order}.';
$string['structure_template_invalid'] = 'No se puede usar la plantilla: debe tener un único bloque de secciones de módulo con el formato "{$a->format}". Corríjala o revise los ajustes de esta verificación.';
$string['structure_template_missing'] = 'No hay una plantilla válida. Seleccione el curso de referencia en la configuración general del verificador.';
$string['structure_setting_examtext'] = 'Texto que identifica los exámenes';
$string['structure_setting_examtext_desc'] = 'Se considera examen todo cuestionario cuyo nombre contiene este texto, en cualquier parte. No se distinguen mayúsculas ni acentos. El resto del nombre no se verifica.';

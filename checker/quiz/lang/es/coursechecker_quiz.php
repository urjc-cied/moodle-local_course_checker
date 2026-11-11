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
 * Strings for component 'coursechecker_quiz'.
 *
 * @package    coursechecker_quiz
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Verificación de cuestionarios';
$string['pluginname_help'] = 'Esta verificación puede comparar la calificación máxima con la puntuación total de las preguntas de cada cuestionario del curso (desactivado por defecto) y valida que cada cuestionario esté en la categoría del calificador que corresponde a su nombre. En los exámenes, es decir, los cuestionarios cuyo nombre contiene el texto configurado (por defecto, «Examen»), también valida la temporalización, el límite de tiempo, la calificación, los intentos, las opciones de revisión, la retroalimentación global, la finalización de actividad, la cantidad configurada de preguntas aleatorias y que haya suficientes preguntas disponibles. No se verifican los cuestionarios cuyos nombres coinciden con la expresión regular de la lista blanca configurada.';
$string['privacy:metadata'] = 'Esta verificación no almacena datos personales. Sus resultados los almacena el plugin Verificador de cursos.';
$string['regex_whitelist'] = 'Lista blanca de títulos de cuestionarios (expresión regular)';
$string['regex_whitelist_desc'] = 'Ingrese una expresión regular. Los cuestionarios cuyo título coincida con este patrón se incluirán en la lista blanca y se omitirán en la verificación.';
$string['quiz_in_whitelist'] = 'El cuestionario no se verificó porque coincide con el patrón de la lista blanca.';
$string['quiz_grade_sum_error'] = 'La calificación máxima ({$a->grade}) y la puntuación total ({$a->sumgrades}) deben ser el mismo número en este cuestionario';
$string['quiz_grade_sum_success'] = 'Este cuestionario está configurado correctamente';
$string['quiz_activity'] = 'Actividad: {$a->name}  ({$a->modname})';

// Random questions.
$string['gradecategory_heading'] = 'Categorías del calificador';
$string['gradecategory_heading_desc'] = 'Categoría del calificador en la que debe estar cada cuestionario, según su nombre. Los cuestionarios que no coincidan con ninguna regla y los incluidos en la lista blanca no se verifican.';
$string['gradecategory_rules'] = 'Reglas por nombre de cuestionario';
$string['gradecategory_rules_desc'] = 'Una regla por línea con el formato texto|categoría. Si el nombre del cuestionario contiene el texto, debe estar en esa categoría del calificador. Se aplica la primera regla que coincida y no se distinguen mayúsculas ni acentos. Déjelo en blanco para no aplicar esta validación.';
$string['quiz_gradecategory_error'] = 'El cuestionario debe estar en la categoría "{$a->category}" del calificador, pero está en "{$a->current}".';
$string['quiz_gradecategory_none'] = 'Sin categoría';
$string['quiz_gradecategory_rule_invalid'] = 'La regla "{$a->line}" no es válida: debe tener el formato texto|categoría. Corríjala en los ajustes de esta verificación.';
$string['quiz_gradecategory_success'] = 'El cuestionario está en la categoría "{$a->category}" del calificador.';
$string['randomquestions_heading'] = 'Preguntas aleatorias';
$string['randomquestions_heading_desc'] = 'Reglas que deben cumplir los cuestionarios cuyo nombre contiene el texto configurado, excepto los incluidos en la lista blanca.';
$string['randomquestions_enabled'] = 'Validar las preguntas aleatorias';
$string['randomquestions_enabled_desc'] = 'Valida las preguntas aleatorias de los cuestionarios y que haya suficientes preguntas disponibles para iniciar un intento.';
$string['randomquestions_namefilter_desc'] = 'Los cuestionarios cuyo nombre contiene este texto, en cualquier parte, son exámenes: se les aplican las reglas de exámenes y de preguntas aleatorias. No se distinguen mayúsculas ni acentos. Déjelo en blanco para aplicarlas a todos los cuestionarios.';
$string['randomquestions_namefilter'] = 'Texto que identifica los exámenes';
$string['randomquestions_required'] = 'Preguntas aleatorias requeridas';
$string['randomquestions_required_desc'] = 'Cantidad exacta de preguntas aleatorias que debe tener cada cuestionario validado.';
$string['randomquestions_matchcategory'] = 'Exigir una categoría con el mismo nombre del cuestionario';
$string['randomquestions_matchcategory_desc'] = 'Las preguntas aleatorias deben usar la categoría del banco de preguntas del curso que tiene el mismo nombre del cuestionario. No se distinguen mayúsculas de minúsculas y se ignoran los espacios al inicio y al final.';
$string['randomquestions_includesubcategories'] = 'Aceptar subcategorías';
$string['randomquestions_includesubcategories_desc'] = 'Las preguntas aleatorias también pueden usar cualquier subcategoría de la categoría con el mismo nombre del cuestionario.';
$string['quiz_random_count_error'] = 'El cuestionario tiene {$a->random} pregunta(s) aleatoria(s) y {$a->fixed} pregunta(s) fija(s), pero debe tener {$a->required} preguntas aleatorias.';
$string['quiz_random_fixed_warning'] = 'Además de las preguntas aleatorias requeridas, el cuestionario tiene {$a->fixed} pregunta(s) fija(s).';
$string['quiz_category_missing'] = 'El banco de preguntas del curso no tiene ninguna categoría llamada "{$a->name}".';
$string['quiz_category_mismatch'] = '{$a->count} pregunta(s) aleatoria(s) no usan la categoría "{$a->name}". Usan: {$a->categories}.';
$string['quiz_category_mismatch_subcategories'] = '{$a->count} pregunta(s) aleatoria(s) no usan la categoría "{$a->name}" ni sus subcategorías. Usan: {$a->categories}.';
$string['quiz_category_insufficient'] = 'No hay suficientes preguntas en {$a->categories}: hay {$a->available} disponible(s), pero el cuestionario necesita {$a->needed}.';
$string['quiz_questions_insufficient'] = 'No hay suficientes preguntas distintas para el cuestionario: hay {$a->available} disponible(s), pero necesita {$a->needed}.';
$string['quiz_random_success'] = 'El cuestionario tiene {$a->required} preguntas aleatorias y suficientes preguntas disponibles.';
$string['quiz_random_success_category'] = 'El cuestionario tiene {$a->required} preguntas aleatorias de la categoría "{$a->name}" y suficientes preguntas disponibles.';

// Exams.
$string['exam_heading'] = 'Exámenes';
$string['exam_heading_desc'] = 'Reglas que deben cumplir los exámenes, es decir, los cuestionarios cuyo nombre contiene el texto configurado, excepto los incluidos en la lista blanca. Cada regla se puede desactivar.';
$string['exam_nodates'] = 'Sin fechas de temporalización';
$string['exam_nodates_desc'] = 'Los exámenes no deben tener fecha de apertura ni de cierre.';
$string['exam_timelimit'] = 'Exigir límite de tiempo';
$string['exam_timelimit_desc'] = 'Los exámenes deben tener un límite de tiempo, de cualquier duración.';
$string['exam_gradepass'] = 'Calificación para aprobar';
$string['exam_gradepass_desc'] = 'Calificación para aprobar que deben tener los exámenes. Déjelo en blanco para no verificarla.';
$string['exam_attempts'] = 'Intentos permitidos';
$string['exam_attempts_desc'] = 'Cantidad de intentos que deben permitir los exámenes (0 es sin límite). Déjelo en blanco para no verificarla.';
$string['exam_grademethod'] = 'Método de calificación';
$string['exam_grademethod_desc'] = 'Método de calificación que deben usar los exámenes.';
$string['exam_notchecked'] = 'No verificar';
$string['exam_review_enabled'] = 'Validar las opciones de revisión';
$string['exam_review_enabled_desc'] = 'Valida qué ven los estudiantes al revisar un intento del examen.';
$string['exam_reviewoptions'] = 'Opciones de revisión que se muestran';
$string['exam_reviewoptions_desc'] = 'Opciones que deben mostrarse en los momentos validados; las demás no deben mostrarse en esos momentos.';
$string['exam_overallfeedback'] = 'Exigir retroalimentación global';
$string['exam_overallfeedback_desc'] = 'Los exámenes deben tener texto en al menos un tramo de la retroalimentación global.';
$string['exam_completion'] = 'Exigir la finalización de actividad';
$string['exam_completion_desc'] = 'Los exámenes deben completarse automáticamente al ver la actividad y obtener una calificación aprobatoria.';
$string['exam_dates_error'] = 'El examen no debe tener fechas de temporalización. Tiene: {$a->dates}.';
$string['exam_timelimit_error'] = 'El examen no tiene límite de tiempo.';
$string['exam_gradepass_error'] = 'La calificación para aprobar debe ser {$a->expected}, pero es {$a->current}.';
$string['exam_attempts_error'] = 'Los intentos permitidos deben ser {$a->expected}, pero son: {$a->current}.';
$string['exam_grademethod_error'] = 'El método de calificación debe ser "{$a->expected}", pero es "{$a->current}".';
$string['exam_review_missing'] = 'En «{$a->time}», las opciones de revisión deben mostrar: {$a->options}.';
$string['exam_review_extra'] = 'En «{$a->time}», las opciones de revisión no deben mostrar: {$a->options}.';
$string['exam_overallfeedback_error'] = 'El examen no tiene retroalimentación global.';
$string['exam_completion_view'] = 'Ver la actividad';
$string['exam_completion_error'] = 'La finalización de actividad debe ser automática y requerir: {$a->conditions}.';
$string['exam_settings_success'] = 'El examen tiene la configuración requerida.';
$string['exam_setting_invalid'] = 'El valor "{$a->value}" del ajuste "{$a->setting}" no es válido. Corríjalo en los ajustes de esta verificación.';
$string['exam_reviewtimes'] = 'Momentos de revisión que se validan';
$string['exam_reviewtimes_desc'] = 'Momentos después del intento en los que se validan las opciones de revisión. No se verifica lo que se muestra durante el intento.';
$string['exam_delay_enabled'] = 'Validar las demoras entre intentos';
$string['exam_delay_enabled_desc'] = 'Los exámenes deben forzar las demoras entre intentos configuradas abajo.';
$string['exam_delay_desc'] = 'Demora que debe tener el examen. Con 0, la demora debe estar deshabilitada.';
$string['exam_delay_error'] = '"{$a->setting}" debe ser {$a->expected}, pero es: {$a->current}.';
$string['gradesum_enabled'] = 'Exigir calificación máxima igual a la puntuación total';
$string['gradesum_enabled_desc'] = 'Todos los cuestionarios deben tener la calificación máxima igual a la suma de los puntos de sus preguntas (por ejemplo, 10 y 10). Desactívelo si la calificación máxima se reescala, por ejemplo a 100.';

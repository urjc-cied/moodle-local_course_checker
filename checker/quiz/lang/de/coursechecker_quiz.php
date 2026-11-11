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

$string['pluginname'] = 'Quiz Überprüfung';
$string['pluginname_help'] = 'Diese Überprüfung kann bei jedem Quiz im Kurs die maximale Bewertung mit der Gesamtpunktzahl der Fragen vergleichen (standardmässig deaktiviert) und prüft, ob jedes Quiz in der Kategorie der Bewertungen ist, die seinem Namen entspricht. Bei Prüfungen, also Quiz-Aktivitäten, deren Name den konfigurierten Text enthält (standardmässig «Examen»), prüft sie zusätzlich Zeitangaben, Zeitbegrenzung, Bewertung, Versuche, Überprüfungsoptionen, Gesamtfeedback, Aktivitätsabschluss, die konfigurierte Anzahl Zufallsfragen und ob genügend Fragen verfügbar sind. Quiz-Aktivitäten, deren Namen dem konfigurierten regulären Ausdruck der Ausnahmeliste entsprechen, werden nicht überprüft.';
$string['privacy:metadata'] = 'Diese Überprüfung speichert keine personenbezogenen Daten. Ihre Ergebnisse werden im Haupt-Plugin „Course Checker“ gespeichert.';

$string['regex_whitelist'] = 'Regex Quiz Titel Whitelist';
$string['regex_whitelist_desc'] = 'Geben Sie einen regulären Ausdruck ein. Quiz-Aktivitäten, deren Namen diesem Muster entsprechen, werden von der Überprüfung ausgenommen.';
$string['quiz_in_whitelist'] = 'Das Quiz wurde nicht überprüft, da es der Whitelist entspricht.';
$string['quiz_grade_sum_error'] = 'Die maximale Bewertung ({$a->grade}) und die Gesamtsumme der Punkte ({$a->sumgrades}) sollten in diesem Quiz identisch sein.';
$string['quiz_grade_sum_success'] = 'Dieses Quiz ist korrekt konfiguriert.';
$string['quiz_activity'] = 'Aktivität: {$a->name} ({$a->modname})';

// Random questions.
$string['gradecategory_heading'] = 'Kategorien der Bewertungen';
$string['gradecategory_heading_desc'] = 'Kategorie der Bewertungen, in der jedes Quiz gemäss seinem Namen sein muss. Quizze ohne passende Regel und solche auf der Whitelist werden nicht überprüft.';
$string['gradecategory_rules'] = 'Regeln nach Quizname';
$string['gradecategory_rules_desc'] = 'Eine Regel pro Zeile im Format Text|Kategorie. Enthält der Name des Quiz den Text, muss es in dieser Kategorie der Bewertungen sein. Es gilt die erste passende Regel, Gross-/Kleinschreibung und Akzente werden ignoriert. Leer lassen, um diese Validierung nicht anzuwenden.';
$string['quiz_gradecategory_error'] = 'Das Quiz muss in der Kategorie «{$a->category}» der Bewertungen sein, ist aber in «{$a->current}».';
$string['quiz_gradecategory_none'] = 'Keine Kategorie';
$string['quiz_gradecategory_rule_invalid'] = 'Die Regel «{$a->line}» ist ungültig: Sie muss das Format Text|Kategorie haben. Korrigieren Sie sie in den Einstellungen dieser Überprüfung.';
$string['quiz_gradecategory_success'] = 'Das Quiz ist in der Kategorie «{$a->category}» der Bewertungen.';
$string['randomquestions_heading'] = 'Zufallsfragen';
$string['randomquestions_heading_desc'] = 'Regeln für die Quiz-Aktivitäten, deren Name den konfigurierten Text enthält, ausgenommen die Quiz-Aktivitäten auf der Whitelist.';
$string['randomquestions_enabled'] = 'Zufallsfragen überprüfen';
$string['randomquestions_enabled_desc'] = 'Überprüft die Zufallsfragen der Quiz-Aktivitäten und ob genügend Fragen verfügbar sind, um einen Versuch zu starten.';
$string['randomquestions_namefilter_desc'] = 'Quiz-Aktivitäten, deren Name diesen Text an beliebiger Stelle enthält, sind Prüfungen: Für sie gelten die Regeln für Prüfungen und Zufallsfragen. Gross-/Kleinschreibung und Akzente werden ignoriert. Leer lassen, um sie auf alle Quiz-Aktivitäten anzuwenden.';
$string['randomquestions_namefilter'] = 'Text, der die Prüfungen kennzeichnet';
$string['randomquestions_required'] = 'Erforderliche Zufallsfragen';
$string['randomquestions_required_desc'] = 'Genaue Anzahl Zufallsfragen, die jedes überprüfte Quiz enthalten muss.';
$string['randomquestions_matchcategory'] = 'Gleichnamige Kategorie verlangen';
$string['randomquestions_matchcategory_desc'] = 'Die Zufallsfragen müssen die Kategorie der Fragensammlung des Kurses verwenden, die gleich heisst wie das Quiz. Gross-/Kleinschreibung und umgebende Leerzeichen werden ignoriert.';
$string['randomquestions_includesubcategories'] = 'Unterkategorien akzeptieren';
$string['randomquestions_includesubcategories_desc'] = 'Die Zufallsfragen dürfen auch jede Unterkategorie der gleichnamigen Kategorie verwenden.';
$string['quiz_random_count_error'] = 'Das Quiz enthält {$a->random} Zufallsfrage(n) und {$a->fixed} feste Frage(n), muss aber {$a->required} Zufallsfragen enthalten.';
$string['quiz_random_fixed_warning'] = 'Das Quiz enthält zusätzlich zu den erforderlichen Zufallsfragen {$a->fixed} feste Frage(n).';
$string['quiz_category_missing'] = 'Die Fragensammlung des Kurses enthält keine Kategorie mit dem Namen «{$a->name}».';
$string['quiz_category_mismatch'] = '{$a->count} Zufallsfrage(n) verwenden nicht die Kategorie «{$a->name}». Sie verwenden: {$a->categories}.';
$string['quiz_category_mismatch_subcategories'] = '{$a->count} Zufallsfrage(n) verwenden weder die Kategorie «{$a->name}» noch ihre Unterkategorien. Sie verwenden: {$a->categories}.';
$string['quiz_category_insufficient'] = 'Nicht genügend Fragen in {$a->categories}: {$a->available} verfügbar, das Quiz benötigt aber {$a->needed}.';
$string['quiz_questions_insufficient'] = 'Nicht genügend verschiedene Fragen für das Quiz: {$a->available} verfügbar, benötigt werden aber {$a->needed}.';
$string['quiz_random_success'] = 'Das Quiz enthält {$a->required} Zufallsfragen und es sind genügend Fragen verfügbar.';
$string['quiz_random_success_category'] = 'Das Quiz enthält {$a->required} Zufallsfragen aus der Kategorie «{$a->name}» und es sind genügend Fragen verfügbar.';

// Exams.
$string['exam_heading'] = 'Prüfungen';
$string['exam_heading_desc'] = 'Regeln für die Prüfungen, also die Quiz-Aktivitäten, deren Name den konfigurierten Text enthält, ausgenommen die Quiz-Aktivitäten auf der Whitelist. Jede Regel kann deaktiviert werden.';
$string['exam_nodates'] = 'Keine Zeitangaben';
$string['exam_nodates_desc'] = 'Prüfungen dürfen weder Öffnungs- noch Schlussdatum haben.';
$string['exam_timelimit'] = 'Zeitbegrenzung verlangen';
$string['exam_timelimit_desc'] = 'Prüfungen müssen eine Zeitbegrenzung beliebiger Dauer haben.';
$string['exam_gradepass'] = 'Bestehensgrenze';
$string['exam_gradepass_desc'] = 'Bestehensgrenze, die die Prüfungen haben müssen. Leer lassen, um sie nicht zu überprüfen.';
$string['exam_attempts'] = 'Erlaubte Versuche';
$string['exam_attempts_desc'] = 'Anzahl Versuche, die die Prüfungen erlauben müssen (0 ist unbegrenzt). Leer lassen, um sie nicht zu überprüfen.';
$string['exam_grademethod'] = 'Bewertungsmethode';
$string['exam_grademethod_desc'] = 'Bewertungsmethode, die die Prüfungen verwenden müssen.';
$string['exam_notchecked'] = 'Nicht überprüfen';
$string['exam_review_enabled'] = 'Überprüfungsoptionen prüfen';
$string['exam_review_enabled_desc'] = 'Prüft, was Studierende sehen, wenn sie einen Versuch der Prüfung überprüfen.';
$string['exam_reviewoptions'] = 'Angezeigte Überprüfungsoptionen';
$string['exam_reviewoptions_desc'] = 'Optionen, die in den geprüften Zeitpunkten angezeigt werden müssen; die anderen dürfen dann nicht angezeigt werden.';
$string['exam_overallfeedback'] = 'Gesamtfeedback verlangen';
$string['exam_overallfeedback_desc'] = 'Prüfungen müssen in mindestens einem Bereich des Gesamtfeedbacks Text haben.';
$string['exam_completion'] = 'Aktivitätsabschluss verlangen';
$string['exam_completion_desc'] = 'Prüfungen müssen automatisch abgeschlossen werden, wenn die Aktivität angesehen und eine Bestehensbewertung erreicht wird.';
$string['exam_dates_error'] = 'Die Prüfung darf keine Zeitangaben haben. Sie hat: {$a->dates}.';
$string['exam_timelimit_error'] = 'Die Prüfung hat keine Zeitbegrenzung.';
$string['exam_gradepass_error'] = 'Die Bestehensgrenze muss {$a->expected} sein, ist aber {$a->current}.';
$string['exam_attempts_error'] = 'Die erlaubten Versuche müssen {$a->expected} sein, sind aber: {$a->current}.';
$string['exam_grademethod_error'] = 'Die Bewertungsmethode muss «{$a->expected}» sein, ist aber «{$a->current}».';
$string['exam_review_missing'] = 'In «{$a->time}» müssen die Überprüfungsoptionen anzeigen: {$a->options}.';
$string['exam_review_extra'] = 'In «{$a->time}» dürfen die Überprüfungsoptionen nicht anzeigen: {$a->options}.';
$string['exam_overallfeedback_error'] = 'Die Prüfung hat kein Gesamtfeedback.';
$string['exam_completion_view'] = 'Aktivität ansehen';
$string['exam_completion_error'] = 'Der Aktivitätsabschluss muss automatisch sein und verlangen: {$a->conditions}.';
$string['exam_settings_success'] = 'Die Prüfung hat die verlangten Einstellungen.';
$string['exam_setting_invalid'] = 'Der Wert «{$a->value}» der Einstellung «{$a->setting}» ist ungültig. Korrigieren Sie ihn in den Einstellungen dieser Überprüfung.';
$string['exam_reviewtimes'] = 'Geprüfte Zeitpunkte der Überprüfung';
$string['exam_reviewtimes_desc'] = 'Zeitpunkte nach dem Versuch, in denen die Überprüfungsoptionen geprüft werden. Was während des Versuchs angezeigt wird, wird nicht geprüft.';
$string['exam_delay_enabled'] = 'Wartezeiten zwischen Versuchen prüfen';
$string['exam_delay_enabled_desc'] = 'Prüfungen müssen die unten konfigurierten Wartezeiten zwischen Versuchen erzwingen.';
$string['exam_delay_desc'] = 'Wartezeit, die die Prüfung haben muss. Mit 0 muss die Wartezeit deaktiviert sein.';
$string['exam_delay_error'] = '«{$a->setting}» muss {$a->expected} sein, ist aber: {$a->current}.';
$string['gradesum_enabled'] = 'Maximale Bewertung gleich der Gesamtpunktzahl verlangen';
$string['gradesum_enabled_desc'] = 'Jedes Quiz muss eine maximale Bewertung haben, die der Summe der Punkte seiner Fragen entspricht (zum Beispiel 10 und 10). Deaktivieren, wenn die maximale Bewertung umgerechnet wird, zum Beispiel auf 100.';

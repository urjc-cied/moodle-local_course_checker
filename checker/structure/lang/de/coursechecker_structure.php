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

$string['pluginname'] = 'Überprüfung der Kursstruktur';
$string['pluginname_help'] = 'Diese Überprüfung vergleicht den Kurs mit der Vorlage, dem Referenzkurs des Course Checkers. Sie gilt für Kurse in der Kategorie der Vorlage und deren Unterkategorien. Sie prüft die festen Abschnitte und ihre Reihenfolge mit einer variablen Anzahl nummerierter Module, ob die Foren der festen Abschnitte der Vorlage mit denselben Einstellungen vorhanden sind und ob jedes Modul seine Prüfung hat. Beim Vergleich von Abschnitten und Foren werden führende Symbole wie Emojis sowie Gross-/Kleinschreibung ignoriert. Forenbeschreibungen werden nicht verglichen; das Forum, das Nutzungsregeln enthalten muss, darf keine leere Beschreibung haben. Unterabschnitte werden nicht überprüft, andere Kurselemente werden ignoriert. Zudem wird geprüft, ob die Prüfungen für den Kursabschluss erforderlich und wie in der Vorlage kombiniert sind; eine andere erforderliche Aktivität ist eine Warnung.';
$string['privacy:metadata'] = 'Diese Überprüfung speichert keine personenbezogenen Daten. Ihre Ergebnisse werden im Haupt-Plugin „Course Checker“ gespeichert.';

$string['structure_completion'] = 'Kursabschluss';
$string['structure_completion_activities'] = 'Abgeschlossene Aktivitäten';
$string['structure_completion_aggregation'] = 'Der Kursabschluss stimmt bei «{$a->setting}» nicht mit der Vorlage überein: Die Vorlage hat «{$a->expected}», dieser Kurs hat «{$a->actual}».';
$string['structure_completion_exam_missing'] = 'Die Prüfung «{$a->name}» gehört nicht zu den für den Kursabschluss erforderlichen Aktivitäten.';
$string['structure_completion_method_1'] = 'Alle müssen erfüllt sein';
$string['structure_completion_method_2'] = 'Eine genügt';
$string['structure_completion_other'] = 'Die Aktivität «{$a->name}» ist im Kursabschluss, dort sollten aber nur die Prüfungen sein.';
$string['structure_completion_overall'] = 'Anforderungen für den Kursabschluss';
$string['structure_completion_success'] = 'Die {$a->count} Prüfungen des Kurses sind im Kursabschluss.';
$string['structure_completionview'] = 'Anzeigen der Aktivität verlangen';
$string['structure_course'] = 'Kursstruktur';
$string['structure_exam_duplicate'] = 'Modul {$a->number} hat mehr als eine Prüfung: {$a->names}. Es darf nur eine haben.';
$string['structure_exam_hidden'] = 'Die Prüfung «{$a->name}» ist verborgen.';
$string['structure_exam_missing'] = 'Die Prüfung von Modul {$a->number} fehlt: ein Quiz mit «{$a->text}» im Namen.';
$string['structure_exam_outside'] = 'Die Prüfung «{$a->name}» befindet sich im Abschnitt «{$a->section}». Sie muss in ihrem Modul sein.';
$string['structure_format_invalid'] = 'Das Format «{$a->format}» ist ungültig: Es muss N enthalten, das für die Modulnummer steht. Korrigieren Sie es in den Einstellungen dieser Überprüfung.';
$string['structure_forum_duplicate'] = 'Das Forum «{$a->name}» ist im Abschnitt «{$a->section}» doppelt vorhanden.';
$string['structure_forum_missing'] = 'Das Forum «{$a->name}» fehlt im Abschnitt «{$a->section}».';
$string['structure_forum_rules_empty'] = 'Die Beschreibung des Forums «{$a->name}» enthält keine Nutzungsregeln.';
$string['structure_forum_setting'] = 'Das Forum «{$a->name}» stimmt bei «{$a->setting}» nicht mit der Vorlage überein: Die Vorlage hat «{$a->expected}», dieser Kurs hat «{$a->actual}».';
$string['structure_is_template'] = 'Dieser Kurs ist die Vorlage, mit der die anderen Kurse verglichen werden, und wird daher nicht überprüft.';
$string['structure_module_number'] = 'Der Abschnitt «{$a->name}» hat die Nummer {$a->number}, erwartet wurde aber die Nummer {$a->expected}. Module müssen fortlaufend ab 1 nummeriert sein.';
$string['structure_modules_missing'] = 'Der Kurs enthält keine Modulabschnitte. Ihre Namen müssen mit dem Format «{$a->format}» beginnen.';
$string['structure_not_applicable'] = 'Dieser Kurs befindet sich nicht in der Kategorie der Vorlage und wird daher nicht überprüft.';
$string['structure_section_duplicate'] = 'Der Abschnitt «{$a->name}» ist doppelt vorhanden.';
$string['structure_section_missing'] = 'Der Abschnitt «{$a->name}» fehlt.';
$string['structure_section_order'] = 'Der Abschnitt «{$a->name}» steht an der falschen Stelle. Die erwartete Reihenfolge ist: {$a->order}.';
$string['structure_section_unexpected'] = 'Der Abschnitt «{$a->name}» gehört nicht zur Struktur. Ein Modulabschnitt muss mit dem Format «{$a->format}» gefolgt von seinem Namen beginnen. Die erwartete Reihenfolge ist: {$a->order}.';
$string['structure_setting_moduleformat'] = 'Modulformat';
$string['structure_setting_moduleformat_desc'] = 'Wie der Name eines Modulabschnitts beginnen muss, wobei N für seine Nummer steht. Danach müssen ein Leerzeichen und der Name des Moduls folgen. Zum Beispiel akzeptiert «N.» den Namen «1. Einführung in das Thema». Die übrigen Abschnitte der Vorlage sind in allen Kursen erforderlich.';
$string['structure_setting_rulesforum'] = 'Forum mit Nutzungsregeln';
$string['structure_setting_rulesforum_desc'] = 'Name des Forums, dessen Beschreibung Nutzungsregeln enthalten muss. Eine leere Beschreibung löst einen Fehler aus; sie darf denselben Text wie die Vorlage haben. Leer lassen, um diese Regel nicht anzuwenden.';
$string['structure_success'] = 'Der Kurs entspricht der Struktur der Vorlage: {$a->order}.';
$string['structure_template_invalid'] = 'Die Vorlage kann nicht verwendet werden: Sie muss einen einzigen Block von Modulabschnitten mit dem Format «{$a->format}» enthalten. Korrigieren Sie sie oder prüfen Sie die Einstellungen dieser Überprüfung.';
$string['structure_template_missing'] = 'Es gibt keine gültige Vorlage. Wählen Sie den Referenzkurs in den allgemeinen Einstellungen des Course Checkers aus.';
$string['structure_setting_examtext'] = 'Text, der die Prüfungen kennzeichnet';
$string['structure_setting_examtext_desc'] = 'Jedes Quiz, dessen Name diesen Text an beliebiger Stelle enthält, ist eine Prüfung. Gross-/Kleinschreibung und Akzente werden ignoriert. Der Rest des Namens wird nicht geprüft.';

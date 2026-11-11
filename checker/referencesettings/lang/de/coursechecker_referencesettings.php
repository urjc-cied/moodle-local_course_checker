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
 * Strings for component 'coursechecker_referencesettings'.
 *
 * @package    coursechecker_referencesettings
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Referenzeinstellungen Überprüfung';
$string['pluginname_help'] = 'Diese Überprüfung vergleicht die ausgewählten allgemeinen Kurseinstellungen mit einem Referenzkurs und kann zusätzlich die Zustände der Kursfilter sowie die Kursformatoptionen vergleichen. Es werden nur konfigurierte Einstellungsgruppen geprüft; nicht verfügbare ausgewählte Kurseigenschaften werden als Fehler gemeldet. Zusätzlich kann sie ein Kursbild und ein Startdatum ohne Enddatum verlangen; diese beiden Regeln gelten nicht für den Referenzkurs. Zudem werden die Namen und die Einstellungen der Kategorien der Bewertungen verglichen.';
$string['privacy:metadata'] = 'Diese Überprüfung speichert keine personenbezogenen Daten. Ihre Ergebnisse werden im Haupt-Plugin „Course Checker“ gespeichert.';

// String specific for the reference course settings checker.
$string['referencesettings_comparison'] =
    ' (Referenzkurs: "{$a->settingvaluereference}" | Aktueller Kurs: "{$a->settingvaluecurrent}")';
$string['referencesettings_settingismissing'] = 'Die Einstellung "{$a->setting}" ist keine Kurseinstellung.';
$string['referencesettings_failing'] = 'Die Einstellung "{$a->setting}" ist nicht korrekt. {$a->comparison}';
$string['referencesettings_success'] = 'Die Einstellung "{$a->setting}" ist korrekt.';
$string['referencesettings_checklist'] = 'Checkliste der Referenzkurs-Einstellungen';
$string['referencesettings_checklist_help'] = 'Bitte wählen Sie eine oder mehrere Einstellungen aus, die mit dem Referenzkurs überprüft werden sollen.';

// String specific for the reference course settings checker filters.
$string['referencefilter_comparison'] =
    ' (Referenzkurs: "{$a->filtervaluereference}" | Aktueller Kurs: "{$a->filtervaluecurrent}")';
$string['referencefilter_failing'] = 'Der Filter "{$a->filterkey}" ist nicht korrekt. {$a->comparison}';
$string['referencefilter_success'] = 'Alle Filter sind im aktuellen Kurs korrekt gesetzt.';
$string['referencefilter_enabled'] = 'Filterprüfung für Referenzeinstellungen aktiviert';
$string['referencefilter_enabled_help'] = 'Bitte aktivieren Sie diese Option, um alle Kursfilter mit dem Referenzkurs zu vergleichen.';
$string['referencefilter_filternotsetincurrentcourse'] = 'Der Filter "{$a->filterkey}" fehlt im aktuellen Kurs.';
$string['referenceformatoptions_failing'] = 'Die Formatoption "{$a->optionkey}" ist nicht korrekt. {$a->comparison}';
$string['referenceformatoptions_success'] = 'Alle Formatoptionen sind im aktuellen Kurs korrekt gesetzt.';
$string['referenceformatoptions_enabled'] = 'Formatoptionen-Prüfung für Referenzeinstellungen aktiviert';
$string['referenceformatoptions_enabled_help'] =
    'Bitte aktivieren Sie diese Option, um alle Formatoptionen des Kurses mit dem Referenzkurs zu vergleichen.';
// Course image and dates.
$string['referencesettings_dates_success'] = 'Der Kurs hat ein Startdatum und kein Enddatum';
$string['referencesettings_enddate_set'] = 'Der Kurs hat ein Enddatum ({$a->enddate}). Er darf nur ein Startdatum haben.';
$string['referencesettings_gradecategories_success'] = 'Die Bewertungen haben die Kategorien des Referenzkurses: {$a->expected}.';
$string['referencesettings_gradecategory_extra'] = 'Die Kategorie «{$a->name}» der Bewertungen ist überzählig: Die Bewertungen dürfen nur die Kategorien des Referenzkurses haben ({$a->expected}).';
$string['referencesettings_gradecategory_missing'] = 'Die Kategorie «{$a->name}» fehlt in den Bewertungen.';
$string['referencesettings_image_missing'] = 'Der Kurs hat kein Kursbild.';
$string['referencesettings_image_success'] = 'Der Kurs hat ein Kursbild';
$string['referencesettings_requiregradecategories'] = 'Kategorien der Bewertungen verlangen';
$string['referencesettings_requiregradecategories_help'] = 'Die Bewertungen müssen genau die Kategorien des Referenzkurses haben, verglichen nach ihrem Namen. Gross-/Kleinschreibung wird ignoriert.';
$string['referencesettings_comparegradecategorysettings'] = 'Einstellungen der Kategorien der Bewertungen vergleichen';
$string['referencesettings_comparegradecategorysettings_help'] = 'Vergleicht mit dem Referenzkurs die Einstellungen jeder gleichnamigen Kategorie der Bewertungen und der Kurssumme: Berechnung, leere Bewertungen, Lernziele, gestrichene oder behaltene Bewertungen, Bewertungstyp, maximale, minimale und Bestehensbewertung, Sichtbarkeit, Anzeigetyp, Dezimalstellen und Gewichtung oder Zusatzpunkte. Gilt nur, wenn die Kategorien der Bewertungen verlangt werden.';
$string['referencesettings_gradecategory_setting_failing'] = 'Die Einstellung «{$a->setting}» der Kategorie «{$a->category}» der Bewertungen ist nicht korrekt{$a->comparison}';
$string['referencesettings_gradecategory_settings_success'] = 'Die Kategorie «{$a->category}» der Bewertungen hat die gleichen Einstellungen wie der Referenzkurs.';
$string['referencesettings_requireimage'] = 'Kursbild verlangen';
$string['referencesettings_requireimage_help'] = 'Prüft, ob der Kurs ein Bild hat. Gilt nicht für den Referenzkurs.';
$string['referencesettings_requirestartdateonly'] = 'Nur Startdatum verlangen';
$string['referencesettings_requirestartdateonly_help'] = 'Prüft, ob der Kurs ein Startdatum und kein Enddatum hat. Gilt nicht für den Referenzkurs.';
$string['referencesettings_startdate_missing'] = 'Der Kurs hat kein Startdatum.';

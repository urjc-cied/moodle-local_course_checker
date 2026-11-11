# Checker Structure for Moodle: Subplugin of the Local Course Checker Plugin

This plugin compares a course with its template, which is the reference course of the Course Checker. It applies to the courses in the category of the template and its subcategories. It validates that:

- the fixed sections of the template exist in the same order, around a variable number of modules numbered consecutively from 1 (by default `N. Module name`);
- the forums in the fixed sections of the template exist in the course with the same settings, except for their description;
- the description of the forum that must have rules of use (by default `Foro social`) is not empty, which is a failure (it can have the same text as the template);
- each module has one exam, that is, a quiz whose name contains a configured text (`Examen` by default): a missing, repeated or misplaced exam is a failure, and a hidden exam is a warning. The rest of the exam name is not checked.
- the exams are required for course completion, combined as in the template, while another required activity is a warning.

Leading symbols such as emojis and case are ignored when comparing sections and forums. Other course items, subsections and exams inside subsections are not checked.

## License

This plugin is licensed under the [GNU GPL v3](https://www.gnu.org/licenses/gpl-3.0.html).

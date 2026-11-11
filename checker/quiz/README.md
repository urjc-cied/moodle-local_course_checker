# 📚 Checker Quiz for Moodle: Subplugin of the Local Course Checker Plugin

This plugin checks whether each quiz's “Maximum grade” matches the “Total of marks” assigned to its questions. It helps prevent grading inconsistencies and ensures quizzes are correctly configured.

The exams, that is, the quizzes whose name contains a configured text, must also meet configurable rules: no opening or closing date, a time limit, a grade to pass, a number of attempts, a grading method, the review options shown after the attempt, an overall feedback and an automatic activity completion that requires viewing the activity and a passing grade. Each rule can be disabled.

It can also validate the random questions of the quizzes whose name contains a text, anywhere and ignoring case and accents (`Examen` by default; empty means every quiz). In the settings of this check you can configure:

- whether this validation runs;
- the text that the quiz name must contain;
- the exact number of random questions required (10 by default);
- whether they must use the question bank category named like the quiz, ignoring case and surrounding spaces (disabled by default);
- whether subcategories of that category are accepted.

It also checks that there are enough questions to start an attempt, using the same rules as the quiz: only the latest ready version of each question counts.

Each quiz must also be in the gradebook category required by its name. The rules are configured in the settings of this check, one per line as `text|category`. Quizzes that match no rule are not checked.

---

## ⚙️ Requirements

- Moodle **4.0 or higher**
- A working **cron job**
- PHP extension `curl` (required for the Broken Links checker)

---

## 🧠 Authors

**Simon Gisler**\
[simon.gisler@ffhs.ch](mailto:simon.gisler@ffhs.ch)\
<a href="https://www.ffhs.ch" target="_blank">Swiss Distance University of Applied Sciences (FFHS)</a>

**Stefan Dani**\
[stefan.dani@ffhs.ch](mailto:stefan.dani@ffhs.ch)\
<a href="https://www.ffhs.ch" target="_blank">Swiss Distance University of Applied Sciences (FFHS)</a>

---

## 📝 License

This plugin is licensed under the [GNU GPL v3](https://www.gnu.org/licenses/gpl-3.0.html).

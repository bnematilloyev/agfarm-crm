Yii2 multiple input change log
==============================

2.30.0 (in development)
=======================

2.30.0
=======================
- #369 fix rendering action buttons in case the dataset contains non-numeric indices (unclead)

2.29.0
=======================
- fix addind active form fields doesn't work properly in case of 10 rows and more (unclead)
- revert changes in normalize method because it affected ajax validation
- fix addind active form fields in nested columns (unclead) 

2.28.0
=======================
- replace outdated jquery-sortable.js with a modern alternative (sortable.js) (sankam-nikolya)

2.27.0
======
- #367 (fix) ajax validation doesn't work for newly added/cloned inputs

2.26.2
======
- prevent error loop in case of undefined $wrapper.data('multipleInput') (cebe)

2.26.1
======
- remove version from composer.json

2.26.0
======
- fix calculation of the current row index
- fix incrementing the current row index after adding a new row 

2.25.0
======
- rework cloning: fix #277, #351, #348 (unclead)

2.24.0
======
- #339 don't set tabindex explicitly

2.23.0
======
- always use `id` from the settings if it is specified
- Ability to add custom tabindex via options array
- #335 fix input name in case of one column and enabled sorting

2.22.0
======
- Ignore dev files in zip distribution (sup-ham)
- #292 Fixed tests for last PHPUnit
- Added support prepare values of attributes with same name as the relation

2.21.4
======
- Fix replaceAll unfinished modify
- More completely type detect to replaceAll

2.21.3
======
- fix retrieving AR relation data

2.21.2
======
- FIX wrapper options for bootstrap theme

2.21.1
======
- #286 avoid removal of all rows on the page when there are several widgets on the page and method `clear` was called

2.21.0
======
- #279 ability to prepend new row instead of append

2.20.6
======

- don't cast JsExpression to string after replace widget placeholder

2.20.0
======

- #278 allow zero name
- #261 replace the widget placeholder in all nested options

2.19.0
======
- add template for input (bscheshirwork)
- pass more params to a prepareValue closure (bscheshirwork)
- add DivRenderer (bscheshirwork)

2.18.0
======
- #246 accept `\Traversable` in model attribute for `yield` compatibility (bscheshirwork) 
- #250 accept `\Traversable` in TableRenderer and ListRenderer for `yield` compatibility (bscheshirwork)
- #253 allow to omit a name for static column 
- #257 added `jsPositions` property for the `BaseRenderer` to set right order js-code in `jsInit` and `jsTemplates` (Spell6inder)
- #259 added `columnOptions` property in the `BaseColumn` for TableRenderer and ListRenderer to support HTML options of individual column (InsaneSkull)

2.17.0
======
- #215 collect all js script that has to be evaluate when add new row (not only from " on ready" section)
- #198 introduce the option `theme` to disable all bootstrap css classes
- #197 explicitly set tabindex for all inputs
- #175 option `showGeneralError` to enable displaying of general error message 

2.16.0
======
- #220 fixed error message for clientValidation and ajaxValidation (antkaz)
- #228 added `iconMap` and `iconSource`property for MultipleInput and TabularInput
- #228 changed the following methods to support icon class:
    BaseColumn->renderDragColumn(), TableRenderer->renderCellContent(), BaseRenderer->prepareButtons()
- #194 added support of yii\base\DynamicModel
- #186 added event `afterDropRow`

2.15.0
=======================
- #217 added `layoutConfig` property for the ListRenderer (antkaz)

2.14.0
======
- #202 added extra buttons (dimmitri)
- PR#201 added optional clone button (alex-nesterov)

2.13.0
======
- #152 added ability to allow an empty list (or set `min` property to 0) for TabularInput

2.12.0
======
- Rename yii\base\Object to yii\base\BaseObject


2.11.0
======
- Added the possibility to substitute buttons before rows

2.10.0
======
- #170: Added global options `enableError`
- #154: Added missing js event: beforeAddRow

2.9.0
=====

- Pass the added row to `afterAddRow` event

2.8.2
=====

- Fixed conflict with jQuery UI sortable

2.8.1
=====

- Fixed client validation

2.8.0
=====

- #137: added option `nameSuffix` to avoid errors related to duplication of id in case when you use several copies of the widget on a page

2.7.1
=====

- Fixed assets

2.7.0
=====

- Fixed an incorrect behavior of widget in case of ajax loading (e.g. in modal window)

2.6.1
=====

- Fixed assets

2.6.0
=====

- PR#132: Implemented `Sortting` (sankam-nikolya)
- PR#132: fixed if attribute is set and hasProperty return false (sankam-nikolya)

2.5.0
=====

- #127: fixed js actions

2.4.0
=====

- Implemented `ListRenderer`

2.3.1
=====

- Fixed ajax validation for embedded fields

2.3.0
=====

- #107: render a hidden input when `MultipleInput` is used for active field
- #109: respect ID when using a widget's placeholder

2.2.0
=====

- #104: Fixed preparation of js attributes (Choate, unclead)
- Fixed removal of row with index 0 via js api method (pvlg)


2.1.1
=====

- Enh: Passing a deleted row to the event

2.1.0
=====

- Enh #37: Support of client validation

2.0.1
=====

- Bug #105: Change vendor name in namespace from yii to unclead to respect Yii recommendations

2.0.0
=====

- Renamed `limit` option to `max`
- Changed namespace from `unclead\widgets` to `yii\multipleinput`
- #92: Adjustments for correct work with AR relations
- Enh #104: Added method to set value of an particular option

1.4.1
=====

- #99: Respect "defaultValue" if it is set and current value is empty (unclead)

1.4.0
-----

- #94: added ability to set custom renderer (unclead, bokodi-dev)
- #97: Respect `addButtonPosition` when rendering the button (unclead)

1.3.1
-----

- Bug: Use method `::className` instead of `::class`

1.3.0
-----

- #79 Added support for embedded MultipleInput widget (unclead, execut)
- Enh: Added ability to render `add` button in the footer (unclead)
- Enh: Improving for better work without ActiveForm (unclead)
- Enh: Added ability to render `add` button at several positions (unclead)

1.2.19
------

- #85: fixed `$enableError` not render element in template (thiagotalma)

1.2.18
------

- #81 fixed output of errors in case of non-ajax validation

1.2.17
------

- Enh: increased default value for the property `limit` (ivansal)
- Enh: Added support of associative array in data (ivansal)
- Bug: fixed double execution events for included MultipleInput (fiamma06)

1.2.16
------

- Bug #70: replacing of the placeholder after preparing the content of row

1.2.15
------

- Added note about usage widget with ajax

1.2.14
------

- Bug #71: trigger the event after actual removal of row

1.2.13
------

- Added new js events (add/remove/clear inputs) and integrated the gulp for minification of assets (veksa)
- Added support of closure for parameter `options` (veksa)

1.2.12
------

- Hotfix: Fixed error when array_key_exits (kongoon)

1.2.11
------

- Bug #61: Fixed a rendering of remove button
- Bug #62: Incorrect behavior is case when `min` is equal to `limit`
- Bug #64: Radio/checkbox lists doesn't work correctly

1.2.10
------

- Enh #59 Added columnClass property (unclead)

1.2.9
-----

- Enh #56: add `rowOptions` property

1.2.8
-----

- Enh: Don't show action column when limit is `equal` to `min`

1.2.7
-----

- Bug #55: Attach click events to the widget wrapper instead of `$(document)`

1.2.6
-----

- Bug #49: urlencoded field token replacement in js template (rolmonk)
- Enh #48: Added option `min` for setting minimum number of rows
- Enh: added option `addButtonPosition`

1.2.5
-----

- Bug #46: Renamed placeholder to avoid conflict with other plugins
- Bug #47: Use Html helper for rendering buttons instead of Button widget
- Enh: Deleted yii2-bootstrap dependency 

1.2.4
-----

- Bug #39: TabularInput: now new row does't copy values from  the most recent row
- Enh #40: Pass the current row for removal when calling `beforeDeleteRow` event


1.2.3
-----

- Enh #34: Added option `allowEmptyList` (unclead)
- Enh #35: Added option `enableGuessTitle` for MultipleInput (unclead)
- Bug #36: Use PCRE_MULTILINE modifier in regex

1.2.2
-----

- Enh #31: Added support of anonymous function for `items` attribute (unclead, stepancher)
- Enh: added hidden field for radio and checkbox inputs (unclead, kotchuprik)
- Enh: improved css (fiamma06)

1.2.1
-----

- Bug #25 fixed rendering when data is empty
- Bug #27 fixed element's prefix generation

1.2.0
-----

- Bug #19 Refactoring rendering of inputs (unclead)
- Bug #20 Added hasAttribute checking for AR models (unclead)
- Enh #22 Added `TabularInput` widget (unclead), rendering logic has been moved to separate class (renderer)

1.1.0
-----

- Bug #17: display inline errors (unclead, mikbox74)
- Enh #11: Improve js events (unclead)
- Bug #16: correct use of defaultValue property (unclead)
- code improvements (unclead)

1.0.4
--------------------

- Bug #15: Fix setting current values of dropDownList (unclead)
- Bug #16: fix render of dropDown and similar inputs (unclead)
- Enh: Add attributeOptions property

1.0.3
-----
- Bug: Hidden fields no longer break markup (unclead, kotchuprik)

1.0.2
-----

- Enh: added minified version of js script (unclead)
- Enh #8: renamed placeholders for avoid conflicts with other widgets (unclead)
- Enh #7: customization of header cell

1.0.1
-----

- Enh #1: Implemented ability to use widget as column type (unclead)
- Enh: add js events (ZAYEC77)

1.0.0
-----

first stable release

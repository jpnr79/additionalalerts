<?php
// Fallback stubs for static analysis only
if (!class_exists('CommonDBTM')) { class CommonDBTM { public static function getType() { return ''; } public function getID() { return 0; } public function canViewItem() { return true; } public static function canView() { return true; } public function getName() { return ''; } public function find($a) { return []; } public function getFromResultSet($a) {} public function getField($k) { return null; } } }
if (!class_exists('User')) { class User extends CommonDBTM { public static function getTable() { return 'glpi_users'; } public static function getFormURLWithID($id) { return ''; } } }
if (!class_exists('Session')) { class Session { public static function haveRight($a, $b) { return true; } public static function addToNavigateListItems($a, $b) {} public static function isMultiEntitiesMode() { return false; } public static function addMessageAfterRedirect(...$a) {} public static function haveAccessToEntity(...$a) { return true; } public static function haveRightsOr($a, $b) { return true; } } }
if (!class_exists('Html')) { class Html { public static function convDateTime($a, $b = null, $c = null) { return ''; } public static function hidden(...$a) { return ''; } public static function submit(...$a) { return ''; } public static function closeForm(...$a) { return ''; } } }
if (!class_exists('Plugin')) { class Plugin { public static function loadLang($p) {} } }
if (!class_exists('Dropdown')) { class Dropdown { public static function getDropdownName(...$a) { return ''; } } }
if (!class_exists('Toolbox')) { class Toolbox { public static function getItemTypeFormURL($c) { return ''; } } }
if (!class_exists('NotificationEvent')) { class NotificationEvent { public static function raiseEvent(...$a) { return true; } } }
if (!class_exists('Alert')) { class Alert { const END = 0; public static function dropdownYesNo($a) {} } }
if (!class_exists('DbUtils')) { class DbUtils { public function getAllDataFromTable($t) { return []; } } }
if (!class_exists('Printer_CartridgeInfo')) { class Printer_CartridgeInfo { public $fields = []; public function getFromDB($id) {} } }
if (!class_exists('Printer')) { class Printer { public $fields = []; public function getFromDB($id) {} } }
if (!class_exists('Entity')) { class Entity { public function getField($k) { return null; } public function can($id, $right) { return true; } } }
if (!class_exists('Config')) { class Config { public $fields = []; public static function getConfig() { return new self(); } public function getFromDB($id) {} public function useInkAlert() { return true; } } }
if (!class_exists('CronTask')) { class CronTask { const STATE_DISABLE = 0; public $fields = ["state"=>0]; public function getFromDBbyName($c, $n) { return false; } public function log($m) {} public function addVolume($v) {} } }
if (!class_exists('InkPrinterState')) { class InkPrinterState { public function configState() {} } }
if (!class_exists('InkThreshold')) { class InkThreshold { public function showSetupForm($a, $b) {} } }
if (!class_exists('AdditionalAlert')) { class AdditionalAlert { public static function getTypeName($n=0) { return ''; } } }
if (!function_exists('__')) { function __($a, $b = null) { return $a; } }
if (!function_exists('__s')) { function __s($a, $b = null) { return $a; } }
if (!function_exists('_sx')) { function _sx($a, $b) { return $b; } }
if (!function_exists('_n')) { function _n($a, $b, $c, $d = null) { return $c == 1 ? $a : $b; } }
if (!defined('ERROR')) { define('ERROR', 1); }
if (!defined('UPDATE')) { define('UPDATE', 1); }
if (!defined('READ')) { define('READ', 1); }
if (!defined('CREATE')) { define('CREATE', 1); }
if (!defined('ALLSTANDARDRIGHT')) { define('ALLSTANDARDRIGHT', 1); }
if (!defined('PLUGIN_ADDITIONALALERTS_WEBDIR')) { define('PLUGIN_ADDITIONALALERTS_WEBDIR', '/'); }

<?php
// Include namespaced stubs first so PHP can parse namespace declarations
require_once __DIR__ . '/stubs_namespaced.php';
// Minimal core stubs required for static analysis runs targeted to this plugin
if (!class_exists('CommonGLPI')) {
	class CommonGLPI {
		public $fields = [];
		public function getType() { return ''; }
		public function getField($name) { return $this->fields[$name] ?? null; }
	}
}
// This file provides stubs for GLPI core classes and functions used by the additionalalerts plugin.
// It is for static analysis only and MUST NOT be included in production or runtime environments.

	// ensure magic static handler exists for analysis; no-op implementation
	class CommonDBTM_MAINTAINER_EXTENDER { public static function __callStatic($n,$a) { return null; } }
if (!class_exists('DbUtils', false)) { class DbUtils { public function getAllDataFromTable($t, $opts = null) { return []; } public function countElementsInTable($t, $c = null) { return 0; } public function getUserName($id) { return 'User'.$id; } } }
if (!class_exists('NotificationTarget', false)) {
	class NotificationTarget {
		public static function getInstance($obj, $type, $options) { return new self(); }
		public $tag_descriptions = [];
		public $data = [];
		public $obj;
		public function getTags() {}
		public function addDataForTemplate($event, $options = []) {}
	}
}
if (!class_exists('DB', false)) {
	class DB {
		public function tableExists($t) { return true; }
		public function request($q) { return []; }
		public function update($table, $values, $where = []) { return true; }
	}
}
if (!class_exists('Notification', false)) { class Notification { const USER_TYPE = 1; const ASSIGN_TECH = 2; const SUPERVISOR_ASSIGN_GROUP = 3; public static function getNotificationsByEventAndType() { return []; } } }
if (!class_exists('NotificationTemplate', false)) { class NotificationTemplate { } }
if (!class_exists('NotificationTemplateTranslation', false)) { class NotificationTemplateTranslation { } }
if (!class_exists('Notification_NotificationTemplate', false)) { class Notification_NotificationTemplate { } }
if (!class_exists('Ticket', false)) { class Ticket { public static function getStatus($s) { return $s; } public function getEmpty() {} } }
if (!class_exists('Alert', false)) { class Alert { public static function dropdownIntegerNever($a, $b = null, $c = null) {} public static function dropdownYesNo($opts = []) {} } }
if (!class_exists('Migration', false)) { class Migration { public function __construct($v = null) {} public function executeMigration() {} } }
if (!class_exists('Session', false)) { class Session { public static function getLoginUserID() { return 1; } public static function haveRight($r, $l) { return true; } public static function haveRightsOr($r, $arr) { return true; } public static function haveAccessToEntity($id) { return true; } } }
if (!class_exists('Html', false)) {
		/**
		 * Minimal Html helpers used by the plugin (stubs for static analysis)
		 * @method static void header(string $title = '', string $url = '', string $type = '', mixed $option = null)
		 * @method static void footer()
		 * @method static void back()
		 * @method static string dropdownYesNo(array $opts = [])
		 * @method static string dropdownIntegerNever($a, $b = null, $c = null)
		 * @method static string convDateTime($v)
		 * @method static string input(string $name, array $opts = [])
		 * @method static void openMassiveActionsForm()
		 * @method static void showMassiveActions()
		 * @method static string getCheckAllAsCheckbox()
		 * @method static string showMassiveActionCheckBox()
		 */
	class Html {
		public static function hidden($n, $a) { return ''; }
		public static function submit($l, $a) { return ''; }
		public static function closeForm() {}
		public static function header($title = '', $url = '', $type = '', $option = null) {}
		public static function footer() {}
		public static function back() {}
		public static function dropdownYesNo($opts = []) {}
		public static function dropdownIntegerNever($a, $b = null, $c = null) {}
		public static function convDateTime($v) { return (string)$v; }
		public static function input($name, $opts = []) { return ''; }
		public static function openMassiveActionsForm() {}
		public static function showMassiveActions() {}
		public static function getCheckAllAsCheckbox() { return ''; }
		public static function showMassiveActionCheckBox() { return ''; }

		public static function __callStatic($name, $arguments) { return null; }
	}
}
if (!class_exists('Menu', false)) { class Menu { public static function removeRightsFromSession() {} } }
if (!class_exists('Plugin', false)) {
	/**
	 * Minimal Plugin helper stub
	 * @method static string getPhpDir(string $name)
	 * @method static void registerClass(string $class, array $opts = [])
	 * @method static bool isPluginActive(string $name)
	 */
	class Plugin {
		public static function getPhpDir($n) { return ''; }
		public static function registerClass($c, $a = []) {}
		public static function isPluginActive($name) { return true; }
		public static function loadLang($n) {}
		public static function loadLanguage($n) { return true; }

		public static function __callStatic($name, $arguments) { return null; }
	}
}
if (!class_exists('Dropdown', false)) { class Dropdown { public static function getDropdownName($t, $id) { return ''; } public static function show($params = []) {} } }

if (!class_exists('MassiveAction', false)) {
	class MassiveAction {
		const ACTION_OK = 1;
		const ACTION_KO = 2;
		const ACTION_NORIGHT = 3;
		const CLASS_ACTION_SEPARATOR = '::';
		public static function __callStatic($name, $args) { return null; }
	}
}

// Add some CommonDBTM helpers used by plugins and allow magic static calls
if (!class_exists('CommonDBTM', false)) {
	class CommonDBTM {
		public $fields = [];
		public function getFromDB($id = 0) {}
		public function getFromDBByCrit($crit) { return false; }
		public static function getForbiddenStandardMassiveAction() { return []; }
		public static function showMassiveActionsSubForm($ma) { return ''; }
		public static function __callStatic($name, $args) { return null; }
	}
} elseif (!method_exists('CommonDBTM', '__callStatic')) {
}
if (!class_exists('InfocomAlert', false)) { class InfocomAlert { public static function getTypeName($n) { return ''; } } }
if (!class_exists('InkAlert', false)) { class InkAlert { } }
if (!class_exists('Printer', false)) { class Printer { public $fields = []; public function getFromDB($id) {} } }
if (!class_exists('Printer_CartridgeInfo', false)) { class Printer_CartridgeInfo { public $fields = []; public function getFromDB($id) {} } }
if (!class_exists('Entity', false)) { class Entity { } }
if (!class_exists('CronTask', false)) { class CronTask { public static function Register($c, $n, $t) {} public static function Unregister($n) {} } }
// Provide a simple ProfileRight stub used by plugin code
if (!class_exists('ProfileRight')) {
	class ProfileRight {
		public static function addProfileRights($a) {}
		public static function getProfileRights($id, $arr) { return []; }
		public function deleteByCriteria($a) {}
		public function add($a) {}
	}
}

// Provide a global placeholder exception and alias into the expected namespaced GLPI exception
if (!class_exists('Glpi\\Exception\\Http\\AccessDeniedHttpException')) {
	if (!class_exists('Glpi_Exception_Http_AccessDeniedHttpException')) {
		class Glpi_Exception_Http_AccessDeniedHttpException extends \Exception {}
	}
	class_alias('Glpi_Exception_Http_AccessDeniedHttpException', 'Glpi\\Exception\\Http\\AccessDeniedHttpException');
}
if (!function_exists('getUserName')) { function getUserName($id) { return 'User'.$id; } }
if (!function_exists('__')) { function __($s, $domain = null) { return $s; } }
if (!function_exists('_x')) { function _x($s, $c, $domain = null) { return $s; } }
if (!function_exists('_n')) { function _n($sing, $plur, $count, $domain = null) { return $count > 1 ? $plur : $sing; } }

// Note: intentionally not declaring namespaced exception to avoid namespace ordering issues in this stub.

// Provide minimal namespaced aliases used by plugin files (some files reference these inside the plugin namespace)
if (!class_exists('GlpiPlugin\\Additionalalerts\\Html')) {
	class_alias('Html', 'GlpiPlugin\\Additionalalerts\\Html');
}
if (!class_exists('GlpiPlugin\\Additionalalerts\\Plugin')) {
	class_alias('Plugin', 'GlpiPlugin\\Additionalalerts\\Plugin');
}
if (!class_exists('GlpiPlugin\\Additionalalerts\\Alert')) {
	class_alias('Alert', 'GlpiPlugin\\Additionalalerts\\Alert');
}
if (!class_exists('GlpiPlugin\\Additionalalerts\\Dropdown')) {
	class_alias('Dropdown', 'GlpiPlugin\\Additionalalerts\\Dropdown');
}
if (!class_exists('GlpiPlugin\\Additionalalerts\\CronTask')) {
	class_alias('CronTask', 'GlpiPlugin\\Additionalalerts\\CronTask');
}
// Provide plugin-namespace CommonDBTM and MassiveAction so unqualified references inside the plugin namespace resolve
if (!class_exists('GlpiPlugin\\Additionalalerts\\CommonDBTM')) {
	class_alias('CommonDBTM', 'GlpiPlugin\\Additionalalerts\\CommonDBTM');
}
if (!class_exists('GlpiPlugin\\Additionalalerts\\MassiveAction')) {
	class_alias('MassiveAction', 'GlpiPlugin\\Additionalalerts\\MassiveAction');
}
// Minimal PHPUnit test case stub used by plugin tests during static analysis
if (!class_exists('PHPUnit\\Framework\\TestCase')) {
	eval('namespace PHPUnit\\Framework { class TestCase { public function assertIsString($actual, string $message = "") {} } }');
}
if (!defined('HOUR_TIMESTAMP')) { define('HOUR_TIMESTAMP', 3600); }
if (!defined('DAY_TIMESTAMP')) { define('DAY_TIMESTAMP', 86400); }
if (!defined('READ')) { define('READ', 1); }
if (!defined('UPDATE')) { define('UPDATE', 2); }
if (!defined('CREATE')) { define('CREATE', 4); }
if (!defined('PURGE')) { define('PURGE', 8); }

// Provide a minimal global Profile class so plugin `Profile` class can extend
if (!class_exists('Profile')) {
	class Profile {
		public $fields = [];
		public function getFromDB($id = 0) {}
		public function getFormURL() { return ''; }
		public function displayRightsChoiceMatrix($rights, $opts = []) {}
	}
}



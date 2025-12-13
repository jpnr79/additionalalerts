<?php

namespace GlpiPlugin\Additionalalerts {
    class Html {
        public static function header(string $title = '', string $url = '', string $type = '', $option = null) {}
        public static function footer() {}
        public static function back() {}
        public static function dropdownYesNo(array $opts = []) {}
        public static function dropdownIntegerNever($a, $b = null, $c = null) {}
        public static function convDateTime($v) {}
        public static function input(string $name, array $opts = []) {}
        public static function hidden($n, $a) {}
        public static function submit($l, $a) {}
        public static function closeForm() {}
        public static function openMassiveActionsForm() {}
        public static function showMassiveActions() {}
        public static function getCheckAllAsCheckbox() {}
        public static function showMassiveActionCheckBox() {}
    }

    class Plugin {
        public static function getPhpDir(string $name) {}
        public static function registerClass(string $class, array $opts = []) {}
        public static function isPluginActive(string $name) {}
        public static function loadLang($n) {}
    }

    class Alert {
        public static function dropdownIntegerNever($a, $b = null, $c = null) {}
        public static function dropdownYesNo(array $opts = []) {}
    }

    class Dropdown {
        public static function getDropdownName($t, $id) {}
        public static function show($params = []) {}
        public static function showNumber($params = []) {}
        public static function showAllItems($params = []) {}
    }

    class CronTask {
        const STATE_DISABLE = 0;
        public static function Register($c, $n, $t) {}
        public static function Unregister($n) {}
    }

    class CommonDBTM {
        public static function getForbiddenStandardMassiveAction() {}
        public static function showMassiveActionsSubForm($ma) {}
    }

    class MassiveAction {
        public static function __callStatic($name, $args) {}
    }

    class Session {
        public static function getLoginUserID() {}
        public static function haveRightsOr($r, $arr) {}
        public static function haveRight($r, $l) {}
        public static function haveAccessToEntity($id) {}
        public static function isMultiEntitiesMode() {}
        public static function getNewCSRFToken() {}
        public static function checkCentralAccess() {}
    }
}

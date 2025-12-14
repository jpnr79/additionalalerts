    if (!class_exists('Config')) {
        class Config {
            public $fields = [];
            public static function getConfig() { return new self(); }
            public function getFromDB($id) { return false; }
            public function useInfocomAlert() { return true; }
        }
    }
    if (!class_exists('NotificationType')) {
        class NotificationType {
            public function configType() {}
        }
    }
    if (!function_exists('_sx')) {
        function _sx($context, $str, $domain = null) { return $str; }
    }
if (!class_exists('CommonDBTM')) {
    class CommonDBTM {
        public $fields = [];
        public function getFromDB($id) { return false; }
        public function getFromDBByCrit($crit) { return false; }
        public function add($input) { return false; }
        public function find($criteria = [], $options = []) { return []; }
    }
}
if (!class_exists('CommonGLPI')) {
    class CommonGLPI {
        public function getType() { return ''; }
        public function getField($name) { return null; }
    }
}
if (!class_exists('Alert')) {
    class Alert {
        const END = 0;
        public static function dropdownYesNo($opts) {}
        public static function dropdownIntegerNever($name, $val) {}
    }
}
if (!class_exists('CronTask')) {
    class CronTask {
        public $fields = ["state" => 0];
        const STATE_DISABLE = 0;
        public function getFromDBbyName($class, $name) { return false; }
    }
}
if (!class_exists('DbUtils')) {
    class DbUtils {
        public static function getDropdownName($table, $id) { return "Name $id"; }
        public function getUserName($id) { return 'User'.$id; }
        public function getAllDataFromTable($table) { return []; }
    }
}
if (!class_exists('Dropdown')) {
    class Dropdown {
        public static function getDropdownName($table, $id) { return "Name $id"; }
        public static function showYesNo($name, $val) {}
        public static function showNumber($name, $val, $a=0,$b=0,$c=0,$d=0,$e=0,$f='',$g=true,$h='',$i='') {}
    }
}
if (!class_exists('Entity')) {
    class Entity {
        public function getField($name) { return null; }
        public function can($id, $right) { return true; }
    }
}
if (!class_exists('Html')) {
    class Html {
        public static function hidden($name, $opts=[]) { return ''; }
        public static function submit($label, $opts=[]) { return ''; }
        public static function closeForm() { return ''; }
    }
}
if (!class_exists('MassiveAction')) {
    class MassiveAction {}
}
if (!class_exists('NotificationEvent')) {
    class NotificationEvent {
        public static function raiseEvent() { return false; }
    }
}
if (!class_exists('Plugin')) {
    class Plugin {
        public static function loadLang($plugin) {}
    }
}
if (!class_exists('Session')) {
    class Session {
        public static function haveRight($item, $right) { return true; }
        public static function isMultiEntitiesMode() { return false; }
        public static function addMessageAfterRedirect($msg, $success = true, $type = 0) {}
        public static function haveAccessToEntity($id) { return true; }
    }
}
if (!class_exists('Toolbox')) {
    class Toolbox {
        public static function getItemTypeFormURL($class) { return ''; }
    }
}
if (!defined('READ')) { define('READ', 1); }
if (!defined('UPDATE')) { define('UPDATE', 2); }
if (!defined('ERROR')) { define('ERROR', 3); }
if (!function_exists('__')) {
    function __($str, $domain = null) { return $str; }
}



class InfocomAlert extends CommonDBTM {
    public static function getTypeName($nb = 0) { return 'InfocomAlert'; }
    public static function createTabEntry($str) { return $str; }
    public function getEmpty() { return null; }
    public static function getIcon() {
        return "ti ti-bell-ringing";
    }
    /**
     * @param CommonGLPI $item
     * @param int        $withtemplate
     * @return string
     */
    public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
        if ($item->getType() == 'CronTask' && $item->getField('name') == "AdditionalalertsNotInfocom") {
            return self::createTabEntry(__('Plugin setup', 'additionalalerts'));
        }
        return '';
    }

    /**
     * @param CommonGLPI $item
     * @param int        $tabnum
     * @param int        $withtemplate
     * @return bool
     */
    public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {
        if ($item->getType() == 'CronTask') {
            $type = new NotificationType();
            $type->configType();
        }
        return true;
    }

    // Cron action

    /**
     * @param $name
     *
     * @return array
     */
    public static function cronInfo($name)
    {

        switch ($name) {
            case 'AdditionalalertsNotInfocom':
                return [
                    'description' => self::getTypeName(2)];   // Optional
                break;
        }
        return [];
    }

    /**
     * @param $entity
     *
     * @return string
     */
    public static function query($entity)
    {
        global $DB;

        $criteria = [
            'SELECT' => [
                'glpi_computers.*',
                'glpi_items_operatingsystems.operatingsystems_id'
            ],
            'FROM' => 'glpi_computers',
            'LEFT JOIN' => [
                'glpi_infocoms' => [
                    'ON' => [
                        'glpi_computers' => 'id',
                        'glpi_infocoms' => 'items_id',
                        [
                            'AND' => [
                                'glpi_infocoms.itemtype' => 'Computer'
                            ]
                        ]
                    ]
                ],
                'glpi_items_operatingsystems' => [
                    'ON' => [
                        'glpi_computers' => 'id',
                        'glpi_items_operatingsystems' => 'items_id',
                        [
                            'AND' => [
                                'glpi_items_operatingsystems.itemtype' => 'Computer'
                            ]
                        ]
                    ]
                ]
            ],
            'WHERE' => [
                'glpi_computers.is_deleted' => 0,
                'glpi_computers.is_template' => 0,
                'glpi_infocoms.buy_date' => null,
                'glpi_computers.entities_id' => $entity
            ],
            'ORDER' => 'glpi_computers.name ASC'
        ];

        // Check for notification types to exclude
        $types_criteria = [
            'SELECT' => 'types_id',
            'FROM' => 'glpi_plugin_additionalalerts_notificationtypes',
        ];

        $iterator = $DB->request($types_criteria);

        if (count($iterator) > 0) {
            $excluded_types = [];
            foreach ($iterator as $data_type) {
                $excluded_types[] = $data_type["types_id"];
            }
            $criteria['WHERE']['glpi_computers.computertypes_id'] = ['NOT IN', $excluded_types];
        }

        return $criteria;
    }


    /**
     * @param $data
     *
     * @return string
     */
    public static function displayBody($data)
    {
        global $CFG_GLPI;

        $body = "<tr class='tab_bg_2'><td><a href=\"" . $CFG_GLPI["root_doc"] . "/front/computer.form.php?id=" . $data["id"] . "\">" . $data["name"];

        if ($_SESSION["glpiis_ids_visible"] == 1 || empty($data["name"])) {
            $body .= " (";
            $body .= $data["id"] . ")";
        }
        $body .= "</a></td>";
        if (Session::isMultiEntitiesMode()) {
            $body .= "<td class='center'>" . Dropdown::getDropdownName("glpi_entities", $data["entities_id"]) . "</td>";
        }
        $body .= "<td>" . Dropdown::getDropdownName("glpi_computertypes", $data["computertypes_id"]) . "</td>";
        $body .= "<td>" . Dropdown::getDropdownName("glpi_operatingsystems", $data["operatingsystems_id"]) . "</td>";
        $body .= "<td>" . Dropdown::getDropdownName("glpi_states", $data["states_id"]) . "</td>";
        $body .= "<td>" . Dropdown::getDropdownName("glpi_locations", $data["locations_id"]) . "</td>";
        $body .= "<td>";
        if (!empty($data["users_id"])) {
            $dbu = new DbUtils();
            $body .= "<a href=\"" . $CFG_GLPI["root_doc"] . "/front/user.form.php?id=" . $data["users_id"] . "\">"
                  . $dbu->getUserName($data["users_id"]) . "</a>";
        }
        if (!empty($data["groups_id"])) {
            $body .= " - <a href=\"" . $CFG_GLPI["root_doc"] . "/front/group.form.php?id=" . $data["groups_id"] . "\">";

            $body .= Dropdown::getDropdownName("glpi_groups", $data["groups_id"]);
            if ($_SESSION["glpiis_ids_visible"] == 1) {
                $body .= " (";
                $body .= $data["groups_id"] . ")";
            }
            $body .= "</a>";
        }
        if (!empty($data["contact"])) {
            $body .= " - " . $data["contact"];
        }

        $body .= "</td>";
        $body .= "</tr>";

        return $body;
    }


    /**
     * @param      $field
     * @param bool $with_value
     *
     * @return array
     */
    public static function getEntitiesToNotify($field, $with_value = false)
    {
        global $DB;

        $criteria = [
            'SELECT' => ['entities_id as entity',$field],
            'FROM' => 'glpi_plugin_additionalalerts_infocomalerts',
            'ORDERBY' => 'entities_id ASC'
        ];
        $iterator = $DB->request($criteria);

        $entities = [];
        if (count($iterator) > 0) {
            foreach ($iterator as $entitydatas) {
                self::getDefaultValueForNotification($field, $entities, $entitydatas);
            }
        } else {
            $config = new Config();
            $config->getFromDB(1);
            $dbu = new DbUtils();
            foreach ($dbu->getAllDataFromTable('glpi_entities') as $entity) {
                $entities[$entity['id']] = $config->fields[$field];
            }
        }

        return $entities;
    }

    /**
     * @param $field
     * @param $entities
     * @param $entitydatas
     */
    public static function getDefaultValueForNotification($field, &$entities, $entitydatas)
    {

        $config = new Config();
        $config->getFromDB(1);
        //If there's a configuration for this entity & the value is not the one of the global config
        if (isset($entitydatas[$field]) && $entitydatas[$field] > 0) {
            $entities[$entitydatas['entity']] = $entitydatas[$field];
        } //No configuration for this entity : if global config allows notification then add the entity
        //to the array of entities to be notified
        elseif ((!isset($entitydatas[$field])
                || (isset($entitydatas[$field]) && $entitydatas[$field] == -1))
               && $config->fields[$field]) {
            $dbu = new DbUtils();
            foreach ($dbu->getAllDataFromTable('glpi_entities') as $entity) {
                $entities[$entity['id']] = $config->fields[$field];
            }
        }
    }

    /**
     * Cron action
     *
     * @param $task for log, if NULL display
     *
     *
     * @return int
     */
    public static function cronAdditionalalertsNotInfocom($task = null)
    {
        global $DB, $CFG_GLPI;

        if (!$CFG_GLPI["notifications_mailing"]) {
            return 0;
        }

        $config = Config::getConfig();

        $CronTask = new CronTask();
        if ($CronTask->getFromDBbyName(InfocomAlert::class, "AdditionalalertsNotInfocom")) {
            if ($CronTask->fields["state"] == CronTask::STATE_DISABLE
             || !$config->useInfocomAlert()) {
                return 0;
            }
        } else {
            return 0;
        }

        $message     = [];
        $cron_status = 0;

        foreach (self::getEntitiesToNotify('use_infocom_alert') as $entity => $repeat) {
            $query_notinfocom = self::query($entity);

            $notinfocom_infos    = [];
            $notinfocom_messages = [];

            $type                    = Alert::END;
            $notinfocom_infos[$type] = [];
            foreach ($DB->request($query_notinfocom) as $data) {
                $entity                             = $data['entities_id'];
                $message                            = $data["name"];
                $notinfocom_infos[$type][$entity][] = $data;

                if (!isset($notinfocom_messages[$type][$entity])) {
                    $notinfocom_messages[$type][$entity] = self::getTypeName(2) . "<br />";
                }
                $notinfocom_messages[$type][$entity] .= $message;
            }

            foreach ($notinfocom_infos[$type] as $entity => $notinfocoms) {
                Plugin::loadLang('additionalalerts');

                if (count($notinfocoms) > 500) {
                    //limit if it is too many element (does not work)
                    $notinfocoms = array_slice($notinfocoms, 500);
                }
                if (NotificationEvent::raiseEvent(
                    "notinfocom",
                    new self(),
                    ['entities_id' => $entity,
                        'notinfocoms' => $notinfocoms]
                )) {
                    $message     = $notinfocom_messages[$type][$entity];
                    $cron_status = 1;
                    if ($task) {
                        $task->log(Dropdown::getDropdownName(
                            "glpi_entities",
                            $entity
                        ) . ":  $message\n");
                        $task->addVolume(1);
                    } else {
                        Session::addMessageAfterRedirect(Dropdown::getDropdownName(
                            "glpi_entities",
                            $entity
                        ) . ":  $message");
                    }
                } else {
                    if ($task) {
                        $task->log(Dropdown::getDropdownName("glpi_entities", $entity)
                             . ":  Send infocoms alert failed\n");
                    } else {
                        Session::addMessageAfterRedirect(Dropdown::getDropdownName("glpi_entities", $entity)
                                                   . ":  Send infocoms alert failed", false, ERROR);
                    }
                }
            }
        }

        return $cron_status;
    }


    /**
     * @param Entity $entity
     *
     * @return bool
     */
    public static function showNotificationOptions(Entity $entity)
    {

        $ID = $entity->getField('id');
        if (!$entity->can($ID, READ)) {
            return false;
        }

        // Notification right applied
        $canedit = Session::haveRight('notification', UPDATE) && Session::haveAccessToEntity($ID);

        // Get data
        $entitynotification = new self();
        if (!$entitynotification->getFromDBByCrit(['entities_id' => $ID])) {
            $entitynotification->getEmpty();
        }

        if ($canedit) {
            echo "<form method='post' name=form action='" . Toolbox::getItemTypeFormURL(__CLASS__) . "'>";
        }
        echo "<table class='tab_cadre_fixe'>";

        echo "<tr><th colspan='2'>" . __('Alarms options') . "</th></tr>";

        echo "<tr class='tab_bg_1'><td>" . self::getTypeName(2) . "</td><td>";
        $default_value = $entitynotification->fields['use_infocom_alert'];
        Alert::dropdownYesNo(['name'           => "use_infocom_alert",
            'value'          => $default_value,
            'inherit_global' => 1]);
        echo "</td></tr>";

        if ($canedit) {
            echo "<tr>";
            echo "<td class='tab_bg_2 center' colspan='4'>";
            echo Html::hidden('entities_id', ['value' => $ID]);
            if ($entitynotification->fields["id"]) {
                echo Html::hidden('id', ['value' => $entitynotification->fields["id"]]);
                echo Html::submit(_sx('button', 'Save'), ['name' => 'update', 'class' => 'btn btn-primary']);
            } else {
                echo Html::submit(_sx('button', 'Save'), ['name' => 'add', 'class' => 'btn btn-primary']);
            }
            echo "</td></tr>";
            echo "</table>";
            Html::closeForm();
        } else {
            echo "</table>";
        }
    }
}

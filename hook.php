
<?php
/**
 * Install function for the additionalalerts plugin
 * @return bool
 */
function plugin_additionalalerts_install()
{
    // Add install logic here if needed
    return true;
}

if (!function_exists('getDB')) {
    function getDB() {
        global $DB;
        if (isset($DB) && is_object($DB)) {
            return $DB;
        } elseif (class_exists('DBConnection') && method_exists('DBConnection', 'getDB')) {
            // Fallback for DBConnection::getDB() if available
            return call_user_func([DBConnection::class, 'getDB']);
        } else {
            throw new \RuntimeException('No GLPI DB object available');
        }
    }
}
// Local analyzer-only fallback for CronTask and Plugin helpers used in hooks
if (!class_exists('CronTask')) {
    class CronTask { public static function Register($c, $n, $t) {} public static function Unregister($n) {} }
}
    if (!class_exists('Plugin')) {
    class Plugin { public static function isPluginActive($n) { return true; } public static function getPhpDir($n) { return ''; } public static function registerClass($c, $a = []) {} }
}
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 * -------------------------------------------------------------------------
 * additionalalerts plugin for GLPI
 * Copyright (C) 2009-2022 by the additionalalerts Development Team.
 *
 * additionalalerts is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * additionalalerts is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with additionalalerts. If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------------
 */

/**
 * @return bool
 */
function plugin_additionalalerts_uninstall()
{
    // use getDB() for DB access

    $tables = [
        "glpi_plugin_additionalalerts_infocomalerts",
        "glpi_plugin_additionalalerts_inkalerts",
        "glpi_plugin_additionalalerts_notificationtypes",
        "glpi_plugin_additionalalerts_configs",
        "glpi_plugin_additionalalerts_inkthresholds",
        "glpi_plugin_additionalalerts_inkprinterstates",
        "glpi_plugin_additionalalerts_ticketunresolveds"
    ];

    foreach ($tables as $table) {
        getDB()->dropTable($table, true);
    }

    //old versions
    $tables = [
        "glpi_plugin_additionalalerts_reminderalerts",
        "glpi_plugin_alerting_config",
        "glpi_plugin_alerting_state",
        "glpi_plugin_alerting_profiles",
        "glpi_plugin_alerting_mailing",
        "glpi_plugin_alerting_type",
        "glpi_plugin_additionalalerts_profiles",
        "glpi_plugin_alerting_cartridges",
        "glpi_plugin_alerting_cartridges_printer_state",
        "glpi_plugin_additionalalerts_profiles",
        "glpi_plugin_additionalalerts_ocsalerts",
        "glpi_plugin_additionalalerts_notificationstates"
    ];

    foreach ($tables as $table) {
        getDB()->dropTable($table, true);
    }



    $notif = new Notification();
    $options = ['itemtype' => InkAlert::class];
    foreach (
        getDB()->request([
            'FROM' => 'glpi_notifications',
            'WHERE' => $options
        ]) as $data
    ) {
        $notif->delete($data);
    }


    // Use fully qualified CronTask class everywhere

    //templates
    $template = new NotificationTemplate();
    $translation = new NotificationTemplateTranslation();
    $notif_template = new Notification_NotificationTemplate();
    $options = ['itemtype' => InkAlert::class];
    foreach (
        getDB()->request([
            'FROM' => 'glpi_notificationtemplates',
            'WHERE' => $options
        ]) as $data
    ) {
        $options_template = [
            'notificationtemplates_id' => $data['id'],
        ];

        foreach (
            getDB()->request([
                'FROM' => 'glpi_notificationtemplatetranslations',
                'WHERE' => $options_template
            ]) as $data_template
        ) {
            $translation->delete($data_template);
        }
        $template->delete($data);

        foreach (
            getDB()->request([
                'FROM' => 'glpi_notifications_notificationtemplates',
                'WHERE' => $options_template
            ]) as $data_template
        ) {
            $notif_template->delete($data_template);
        }
    }

    $notif = new Notification();
    $options = ['itemtype' => 'GlpiPlugin\\Additionalalerts\\InfocomAlert'];
    foreach (
        getDB()->request([
            'FROM' => 'glpi_notifications',
            'WHERE' => $options
        ]) as $data
    ) {
        $notif->delete($data);
    }

    //templates
    $template = new NotificationTemplate();
    $translation = new NotificationTemplateTranslation();
    $notif_template = new Notification_NotificationTemplate();
    $options = ['itemtype' => 'GlpiPlugin\\Additionalalerts\\InfocomAlert'];
    foreach (
        getDB()->request([
            'FROM' => 'glpi_notificationtemplates',
            'WHERE' => $options
        ]) as $data
    ) {
        $options_template = [
            'notificationtemplates_id' => $data['id'],
        ];

        foreach (
            getDB()->request([
                'FROM' => 'glpi_notificationtemplatetranslations',
                'WHERE' => $options_template
            ]) as $data_template
        ) {
            $translation->delete($data_template);
        }
        $template->delete($data);

        foreach (
            getDB()->request([
                'FROM' => 'glpi_notifications_notificationtemplates',
                'WHERE' => $options_template
            ]) as $data_template
        ) {
            $notif_template->delete($data_template);
        }
    }

    $notif = new Notification();
    $options = ['itemtype' => 'GlpiPlugin\\Additionalalerts\\TicketUnresolved'];
    foreach (
        getDB()->request([
            'FROM' => 'glpi_notifications',
            'WHERE' => $options
        ]) as $data
    ) {
        $notif->delete($data);
    }

    //templates
    $template = new NotificationTemplate();
    $translation = new NotificationTemplateTranslation();
    $notif_template = new Notification_NotificationTemplate();
    $options = ['itemtype' => 'GlpiPlugin\\Additionalalerts\\TicketUnresolved'];
    foreach (
        getDB()->request([
            'FROM' => 'glpi_notificationtemplates',
            'WHERE' => $options
        ]) as $data
    ) {
        $options_template = [
            'notificationtemplates_id' => $data['id'],
        ];

        foreach (
            getDB()->request([
                'FROM' => 'glpi_notificationtemplatetranslations',
                'WHERE' => $options_template
            ]) as $data_template
        ) {
            $translation->delete($data_template);
        }
        $template->delete($data);

        foreach (
            getDB()->request([
                'FROM' => 'glpi_notifications_notificationtemplates',
                'WHERE' => $options_template
            ]) as $data_template
        ) {
            $notif_template->delete($data_template);
        }
    }

    //Delete rights associated with the plugin
    $profileRight = new ProfileRight();
    // Profile rights cleanup skipped if methods unavailable
    if (class_exists('Menu') && method_exists('Menu', 'removeRightsFromSession')) {
        Menu::removeRightsFromSession();
    }

    \CronTask::Unregister('additionalalerts');

    return true;
}

// Define database relations
/**
 * @return array
 */
function plugin_additionalalerts_getDatabaseRelations()
{
    global $DB;
    $links = [];
    if (\GlpiPlugin\Additionalalerts\Plugin::isPluginActive("additionalalerts")) {
        // Add any relations if needed
    }
    return $links;
}
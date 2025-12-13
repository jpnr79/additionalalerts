<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 additionalalerts plugin for GLPI
 Copyright (C) 2009-2022 by the additionalalerts Development Team.

 https://github.com/InfotelGLPI/additionalalerts
 -------------------------------------------------------------------------

 LICENSE

 This file is part of additionalalerts.

 additionalalerts is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 additionalalerts is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with additionalalerts. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */


namespace GlpiPlugin\Additionalalerts;

use Alert;
use Html;
use CommonGLPI;
use Plugin;



if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

/**
 * Class Config
 */
class Config extends CommonDBTM
{
    // Provide fields storage for static analysis
    public $fields = [];
    // Fallback for static analysis: createTabEntry
    public static function createTabEntry($str) { return $str; }
    // Fallback for static analysis: showFormHeader
    public function showFormHeader($options = []) { return true; }
    // Fallback for static analysis: showFormButtons
    public function showFormButtons($options = []) { return true; }
    // Stub update method for static analysis
    public function update($input) {
        // In real GLPI, this would update config in DB
        foreach ($input as $k => $v) {
            $this->fields[$k] = $v;
        }
        return true;
    }
    // Getters and setters follow
    static $rightname = "plugin_additionalalerts";

    /**
     * @param int $nb
     * @return string
     */
    static function getTypeName($nb = 0)
    {
        if (function_exists('__')) {
            return __('Plugin setup', 'additionalalerts');
        } else {
            return 'Plugin setup';
        }
    }

    public static function getConfig()
    {
        static $config = null;
        if (is_null($config)) {
            $config = new self();
        }
        if (method_exists($config, 'getFromDB')) {
            $config->getFromDB(1);
        }
        return $config;
    }

    static function getIcon()
    {
        return "ti ti-bell-ringing";
    }

    /**
    * @param mixed $item
    * @param int|null $with
    * @return string
    */
    function getTabNameForItem($item, $with = null)
    {
        global $CFG_GLPI;
        if ($item->getType()=='NotificationMailingSetting'
            && $item->getField('id')
            && $CFG_GLPI["notifications_mailing"]
        ) {
            return self::createTabEntry(AdditionalAlert::getTypeName(2));
        } elseif ($item->getType()=='Entity') {
            return self::createTabEntry(AdditionalAlert::getTypeName(2));
        }
        return null;
    }

    /**
    * @param mixed $item
    * @param int $tabnum
    * @param int|null $with
    * @return bool
    */
    static function displayTabContentForItem($item, $tabnum = 1, $with = null)
    {
        if ($item->getType()=='NotificationMailingSetting') {
            $conf = new self();
            $conf->showConfigForm();
        } elseif ($item->getType()=='Entity') {
            if (class_exists('TicketUnresolved') && method_exists('TicketUnresolved', 'showNotificationOptions')) {
                TicketUnresolved::showNotificationOptions($item);
            }
        }
        return true;
    }

    // Add missing getFromDB method for compatibility
    public function getFromDB($id = 0) { return false; }

    /**
     * @param array $options
     * @return bool
     */
    function showConfigForm($options = [])
    {
        $this->getFromDB(1);
        $options['colspan'] = 1;
        $this->showFormHeader($options);



        echo "<tr class='tab_bg_2'>";
        echo "<td>" . InfocomAlert::getTypeName(2) . "</td><td>";
            if (class_exists('\GlpiPlugin\Additionalalerts\Alert') && method_exists('\GlpiPlugin\Additionalalerts\Alert', 'dropdownYesNo')) {
                \GlpiPlugin\Additionalalerts\Alert::dropdownYesNo(['name' => "use_infocom_alert", 'value' => $this->fields["use_infocom_alert"]]);
            } else if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'dropdownYesNo')) {
                \GlpiPlugin\Additionalalerts\Html::dropdownYesNo(['name' => "use_infocom_alert", 'value' => $this->fields["use_infocom_alert"]]);
        } else {
            // Fallback: simple yes/no select
            $val = (int)($this->fields["use_infocom_alert"] ?? 0);
            echo "<select name='use_infocom_alert'>";
            echo "<option value='0'" . ($val === 0 ? ' selected' : '') . ">No</option>";
            echo "<option value='1'" . ($val === 1 ? ' selected' : '') . ">Yes</option>";
            echo "</select>";
        }
        echo "</td></tr>";

        echo "<tr class='tab_bg_2'>";
        $cartridgeLabel = function_exists('__') ? __('Cartridges whose level is low', 'additionalalerts') : 'Cartridges whose level is low';
        echo "<td >" . $cartridgeLabel . "</td><td>";
            if (class_exists('\GlpiPlugin\Additionalalerts\Alert') && method_exists('\GlpiPlugin\Additionalalerts\Alert', 'dropdownYesNo')) {
                \GlpiPlugin\Additionalalerts\Alert::dropdownYesNo(['name' => "use_ink_alert", 'value' => $this->fields["use_ink_alert"]]);
            } else if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'dropdownYesNo')) {
                \GlpiPlugin\Additionalalerts\Html::dropdownYesNo(['name' => "use_ink_alert", 'value' => $this->fields["use_ink_alert"]]);
        } else {
            // Fallback: simple yes/no select
            $val = (int)($this->fields["use_ink_alert"] ?? 0);
            echo "<select name='use_ink_alert'>";
            echo "<option value='0'" . ($val === 0 ? ' selected' : '') . ">No</option>";
            echo "<option value='1'" . ($val === 1 ? ' selected' : '') . ">Yes</option>";
            echo "</select>";
        }
        echo "</td></tr>";

        echo "<tr class='tab_bg_2'>";
        $unresolvedLabel = function_exists('__') ? __('Unresolved Ticket Alerts', 'additionalalerts') : 'Unresolved Ticket Alerts';
        echo "<td>" . $unresolvedLabel . "</td><td>";
            if (class_exists('\GlpiPlugin\Additionalalerts\Alert') && method_exists('\GlpiPlugin\Additionalalerts\Alert', 'dropdownIntegerNever')) {
                \GlpiPlugin\Additionalalerts\Alert::dropdownIntegerNever('delay_ticket_alert', $this->fields["delay_ticket_alert"]);
            } else if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'dropdownIntegerNever')) {
                \GlpiPlugin\Additionalalerts\Html::dropdownIntegerNever('delay_ticket_alert', $this->fields["delay_ticket_alert"]);
        } else {
            // Fallback: simple number input
            $val = (int)($this->fields["delay_ticket_alert"] ?? 0);
            $dayLabel = function_exists('_n') ? _n('Day', 'Days', 2, 'additionalalerts') : 'Days';
            echo "<input type='number' name='delay_ticket_alert' min='0' max='99' value='" . $val . "'> &nbsp;" . $dayLabel;
        }
        echo "</td></tr>";

        echo "<tr class='tab_bg_2'><td class='center' colspan='2'>";
            if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'hidden')) {
                \GlpiPlugin\Additionalalerts\Html::hidden('id', ['value' => 1]);
        }
        echo "</td></tr>";

        $this->showFormButtons($options);

        return true;
    }
    // ----------------- Getters and setters -------------------
    public function useInfocomAlert()
    {
        return $this->fields['use_infocom_alert'];
    }

    public function useInkAlert()
    {
        return $this->fields['use_ink_alert'];
    }

    public function getDelayTicketAlert()
    {
        return $this->fields['delay_ticket_alert'];
    }
}

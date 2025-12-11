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
use CommonDBTM;
use CommonGLPI;
use Html;
use Plugin;

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

/**
 * Class Config
 */
class Config extends CommonDBTM
{

    static $rightname = "plugin_additionalalerts";

   /**
    * @param int $nb
    * @return string
    */
    static function getTypeName($nb = 0)
    {
        declare(strict_types=1);

        return __('Plugin setup', 'additionalalerts');
    }

    public static function getConfig()
    {
        static $config = null;
        public static function getTypeName(int $nb = 0): string
        if (is_null($config)) {
            $config = new self();
        }
        $config->getFromDB(1);

        return $config;
    }
        public static function getConfig(): self
    static function getIcon()
    {
        return "ti ti-bell-ringing";
    }

   /**
    * @param CommonGLPI $item
    * @param int $withtemplate
    * @return string|translated
    */
    function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
    {
        public static function getIcon(): string

        if ($item->getType()=='NotificationMailingSetting'
            && $item->getField('id')
               && $CFG_GLPI["notifications_mailing"]
        ) {
            return self::createTabEntry(AdditionalAlert::getTypeName(2));
        } elseif ($item->getType()=='Entity') {
            return self::createTabEntry(AdditionalAlert::getTypeName(2));
        }
        public function getTabNameForItem(CommonGLPI $item, int $withtemplate = 0): array|string
    }

   /**
    * @param CommonGLPI $item
    * @param int $tabnum
    * @param int $withtemplate
    * @return bool
    */
    static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {

        if ($item->getType()=='NotificationMailingSetting') {
            $conf = new self();
            $conf->showConfigForm();
        } elseif ($item->getType()=='Entity') {
            InfocomAlert::showNotificationOptions($item);
        public static function displayTabContentForItem(CommonGLPI $item, int $tabnum = 1, int $withtemplate = 0): bool
            TicketUnresolved::showNotificationOptions($item);
        }
        return true;
    }

   /**
    * @param array $options
    * @return bool
    */
    function showConfigForm()
    {
        public function showConfigForm(): void

        $this->getFromDB(1);
        $options['colspan'] = 1;
        $this->showFormHeader($options);

        echo "<tr class='tab_bg_2'>";
        echo "<td>" . InfocomAlert::getTypeName(2) . "</td><td>";
        public function useInfocomAlert(): bool
                              'value'=>$this->fields["use_infocom_alert"]]);
        echo "</td></tr>";

        echo "<tr class='tab_bg_2'>";
        echo "<td >" . __('Cartridges whose level is low', 'additionalalerts') . "</td><td>";
        Alert::dropdownYesNo(['name'=>"use_ink_alert",
            'value'=>$this->fields["use_ink_alert"]]);
        public function useInkAlert(): bool

        echo "<tr class='tab_bg_2'>";
        echo "<td>" . __('Unresolved Ticket Alerts', 'additionalalerts') . "</td><td>";

        Alert::dropdownIntegerNever(
            'delay_ticket_alert',
            $this->fields["delay_ticket_alert"],
        public function getDelayTicketAlert(): int
        );
        echo "&nbsp;"._n('Day', 'Days', 2)."</td></tr>";
        echo "</td></tr>";

        echo "<tr class='tab_bg_2'><td class='center' colspan='2'>";
        echo Html::hidden('id', ['value' => 1]);
        echo "</td></tr>";

        $this->showFormButtons($options);

        return true;
    }


   //----------------- Getters and setters -------------------//

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

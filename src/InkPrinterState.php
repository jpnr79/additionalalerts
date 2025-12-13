<?php
declare(strict_types=1);

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

use Dropdown;
use Html;

/**
 * Class InkPrinterState
 */
class InkPrinterState extends NotificationState {
    public static $rightname = "plugin_additionalalerts";

    function configState()
    {
        $target = PLUGIN_ADDITIONALALERTS_WEBDIR . "/front/inkalert.form.php";
        $states = $this->find([]);
        $used = [];
        foreach ($states as $data) {
            $used[] = $data['states_id'];
        }

        echo "<div class='center'>";
        echo "<form method='post' action=\"$target\">";
        echo "<table class='tab_cadre_fixe' cellpadding='5'>";
        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __('Parameter', 'additionalalerts') . "</td>";
        echo "<td>" . __('Statutes used for the ink level', 'additionalalerts') . " : ";
        // Fallback for Dropdown::show
        echo "<select name='states_id'>";
        foreach ($used as $state_id) {
            echo "<option value='$state_id'>" . htmlspecialchars($state_id) . "</option>";
        }
        echo "</select>";
        echo "&nbsp;";
        // Fallback for Html::submit
        echo "<input type='submit' name='add_state' class='btn btn-primary' value='" . _sx('button', 'Update') . "'>";
        echo "</div></td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
        echo "</div>";

        $rand = mt_rand();
        $data = $this->find([], ["states_id ASC"]);

        if (count($data) != 0) {
            echo "<form method='post' name='massiveaction_form$rand' id='massiveaction_form$rand'  action=\"$target\">";
            echo "<table class='tab_cadre_fixe' cellpadding='5'>";
            echo "<tr>";
            // Fallback for Html::getCheckAllAsCheckbox
            echo "<th width='10'><input type='checkbox' name='checkall'></th>";
            echo "<th>" . _n('State', 'States', 2) . "</th>";
            echo "</tr>";
            foreach ($data as $ligne) {
                echo "<tr class='tab_bg_1'>";
                echo "<td width='10'>";
                // Fallback for Html::showMassiveActionCheckBox
                echo "<input type='checkbox' name='item[]' value='" . htmlspecialchars($ligne["id"]) . "'>";
                echo "</td>";
                // Fallback for Dropdown::getDropdownName
                echo "<td>" . htmlspecialchars($ligne["states_id"]) . "</td>";
                echo "</tr>";
            }
                echo "</table>";
                echo "</form>";
                echo "</div>";
            }
        }
    }
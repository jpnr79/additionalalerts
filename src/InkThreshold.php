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

// Fallback for CommonDBTM if not loaded
if (!\class_exists('CommonDBTM')) {
    abstract class CommonDBTM {
        public $fields = [];
        public function find(array $criteria = []) { return []; }
        public function add(array $data = []) { return null; }
        public function getFromDBByCrit(array $crit) { return false; }
    }
}

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

/**
 * Class InkThreshold
 */
class InkThreshold extends CommonDBTM
{
    // Provide add() stub for static analysis when CommonDBTM fallback is not recognized
    public function add(array $data = []) { return null; }
   /**
    * @param $target
    * @param $id
    */
    function showSetupForm($target, $id)
    {

        $threshold = new InkThreshold();
        $inkthresholds = $threshold->find(["printers_id" => $id]);

        if (count($inkthresholds) == 0) {
            $this->add(["printers_id" => $id]);
        }
        $threshold = new InkThreshold();
        $threshold->getFromDBByCrit(["printers_id" => $id]);

        echo "<form action='" . $target . "' method='post'>";
        echo "<table class='tab_cadre' cellpadding='5' width='950'>";
        $title = function_exists('__') ? __('Ink level alerts', 'additionalalerts') : 'Ink level alerts';
        echo "<tr><th colspan='2'>" . $title . "</th></tr>";
        echo "<tr class='tab_bg_1'>";
        echo "<td>" . $title . "</td>";
        echo "<td>";
        if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'input')) {
            \GlpiPlugin\Additionalalerts\Html::input('threshold', ['value' => $threshold->fields["threshold"], 'size' => 3]);
            echo " %";
        } else {
            echo '<input name="threshold" value="' . htmlspecialchars((string)$threshold->fields["threshold"]) . '" size="3" /> %';
        }
        echo "</td>";
        echo "</tr>";

        echo "<tr class='tab_bg_2'>";
        echo "<td colspan='2' class='center'>";
        $saveLabel = function_exists('_sx') ? _sx('button', 'Save') : 'Save';
        if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'submit')) {
            \GlpiPlugin\Additionalalerts\Html::submit($saveLabel, ['name' => 'update_threshold', 'class' => 'btn btn-primary']);
        } else {
            echo '<button type="submit" name="update_threshold" class="btn btn-primary">' . htmlspecialchars((string)$saveLabel) . '</button>';
        }
        echo "</td>";
        echo "</tr>";

        echo "</table>";
            if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'hidden')) {
                \GlpiPlugin\Additionalalerts\Html::hidden('id', ['value' => $threshold->fields["id"]]);
            } else {
                echo '<input type="hidden" name="id" value="' . htmlspecialchars((string)$threshold->fields["id"]) . '" />';
            }
            if (class_exists('\GlpiPlugin\Additionalalerts\Html') && method_exists('\GlpiPlugin\Additionalalerts\Html', 'closeForm')) {
                \GlpiPlugin\Additionalalerts\Html::closeForm();
            } else {
                echo "</form>";
            }
        }
    }

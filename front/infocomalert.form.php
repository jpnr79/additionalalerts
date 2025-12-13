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

use GlpiPlugin\Additionalalerts\InfocomAlert;
use GlpiPlugin\Additionalalerts\NotificationType;

// Local analyzer-only fallback for Html
if (!class_exists('Html')) {
   class Html { public static function back() {} }
}

$type = new NotificationType();
$infocom = new InfocomAlert();

if (isset($_POST["add"])) {

   if ($infocom->canUpdate()) {
      $newID = $infocom->add($_POST);
   }
   \GlpiPlugin\Additionalalerts\Html::back();

} else if (isset($_POST["update"])) {

   if ($infocom->canUpdate()) {
      $infocom->update($_POST);
   }
   \GlpiPlugin\Additionalalerts\Html::back();

} else if (isset($_POST["add_type"])) {

   if ($infocom->canUpdate()) {
      $newID = $type->add($_POST);
   }
   \GlpiPlugin\Additionalalerts\Html::back();

} else if (isset($_POST["delete_type"])) {

   if ($infocom->canUpdate()) {
      $type->getFromDB($_POST["id"]);
      foreach ($_POST["item"] as $key => $val) {
         if ($val == 1) {
            $type->delete(['id' => $key]);
         }
      }
   }
   \GlpiPlugin\Additionalalerts\Html::back();

}

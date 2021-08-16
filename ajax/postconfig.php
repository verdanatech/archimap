<?php
/*
 -------------------------------------------------------------------------
 Archimap plugin for GLPI
 Copyright (C) 2009-2018 by Eric Feron.
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of Archimap.

 Archimap is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 at your option any later version.

 Archimap is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Archimap. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
 
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

$DB = new DB;
$keys = file_get_contents('php://input');
Toolbox::logInFile("gettables", "setconfig ".$keys."\n");
if (isset($keys)) {
	$keys = json_decode($keys);
} else {
    die("No 'keys' contained in body of POST request 'getconfig'");
}
$datas = [];
foreach($keys as $key => $typevalue) {
	$type = $typevalue->type;
	$value = $typevalue->value;
    $query = "UPDATE glpi_plugin_archimap_configs SET value = '$value' WHERE type = '$type' and `key` = '$key';";
Toolbox::logInFile("gettables", "postconfig ".$query."\n");
//var_dump($query);
    $result=$DB->query($query);
    $datas[$key] = $DB->affectedRows();
}
//var_dump($datas);
Toolbox::logInFile("gettables", "postconfig ".print_r($datas,TRUE)."\n");
echo json_encode($result);
?>

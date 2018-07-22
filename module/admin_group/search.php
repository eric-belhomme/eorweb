<?php
/*
#########################################
#
# Copyright (C) 2018 EyesOfNetwork Team
# DEV NAME : Jean-Philippe LEVY
# VERSION : 2.0
# APPLICATION : eorweb for eyesofreport project
#
# LICENCE :
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
#########################################
*/

include("../../include/config.php");
include("../../include/function.php");

// Search function for Jquery an exit
if(isset($_GET['term']) && isset($_GET['request']) && $_GET['request'] == "search_group") {
	$result=sqlrequest($database_eorweb,"select * from ldap_groups_extended where group_name LIKE '%".$_GET['term']."%' order by group_name");
	
	$array = array();
	while ($line = mysqli_fetch_array($result)){
		array_push($array, $line[1]);
	}
	echo json_encode($array);
}

?>

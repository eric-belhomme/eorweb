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

include("header.php"); 

logging("logout","User logged out");
if(isset($_COOKIE["session_id"])) { 
	$sessid=$_COOKIE["session_id"]; 
	sqlrequest($database_eorweb,"DELETE FROM sessions where session_id=?",false,array("s",(string)$sessid));
}
setcookie("session_eor_id",FALSE);
setcookie("user_name",FALSE);
setcookie("user_id",FALSE);
setcookie("user_limitation",FALSE);
setcookie("group_id",FALSE);
setcookie("nagvis_session",FALSE,0,"/nagvis");
setcookie("Cacti",FALSE);
setcookie("clickedFolder",FALSE);
setcookie("highlightedTreeviewLink",FALSE);

?>

<div class="container">
	<div class="row">
		<div class="img col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<img class="img-responsive center-block login-logo" src="<?php echo $path_logo; ?>" alt="logo eyesofreport">
				</div>
				<div class="panel-body">
					<div class="alert alert-info">
						<?php echo getLabel("label.message.logout.success"); ?>
					</div>
					<a class="btn btn-lg btn-primary btn-block" href="login.php"><?php echo getLabel("action.connect"); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
		
<?php include("footer.php"); ?>

<?php
/*
#########################################
#
# Copyright (C) 2018 EyesOfNetwork Team
# DEV NAME : Bastien PUJOS
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

include("../../header.php");
include("../../side.php");

global $database_eorweb;
?>

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo getLabel("label.manage_remediation.remediation_action_new"); ?></h1>
		</div>
	</div>
	
	<?php
	// get infos for updates
	$remediation_id = retrieve_form_data("id",null);
	$invalid=false;
	
	if(isset($_GET["id"]) && $_GET["id"] != null){
		$sql = "SELECT remediation_action.*, remediation.state
				FROM remediation_action
				LEFT JOIN remediation ON remediation.id =remediation_action.remediationID
				WHERE remediation_action.id=?";

		$user_infos=sqlrequest($database_eorweb, $sql, false, array("i",(int)$remediation_id));
		
		// Retrieve Information from database
		$remediation_name=mysqli_result($user_infos,0,"description");
		$remediation_host=mysqli_result($user_infos,0,"host");
		$remediation_service=mysqli_result($user_infos,0,"service");
		$remediation_type=mysqli_result($user_infos,0,"type");
		$remediation_dateDebut=mysqli_result($user_infos,0,"DateDebut");
		$remediation_dateFin=mysqli_result($user_infos,0,"DateFin");
		$remediation_action=mysqli_result($user_infos,0,"Action");
		$remediation_source=mysqli_result($user_infos,0,"source");
		$remediation_statut=mysqli_result($user_infos,0,"state");
	} else {	
		$remediation_name=retrieve_form_data("name",null);
		$remediation_host=retrieve_form_data("host",null);
		$remediation_service=retrieve_form_data("service",null);
		$remediation_type=retrieve_form_data("type",null);
		$remediation_dateDebut=retrieve_form_data("start",null);
		$remediation_dateFin=retrieve_form_data("end",null);
		$remediation_source=retrieve_form_data("source",null);
		$remediation_action=retrieve_form_data("action",null);
	}

	if ($remediation_source != "none" && $remediation_source != "") {
		$result = sqlrequest($database_thruk, "SELECT host_name,host_id FROM ".$remediation_source."_host WHERE host_name=?",false,array("s",(string)$remediation_host));
		$array_host=mysqli_fetch_row($result);
		
		if($array_host && $remediation_service!="Hoststatus") {
			$result = sqlrequest($database_thruk, "SELECT service_description FROM ".$remediation_source."_service WHERE host_id=? and service_description=?",false,array("is",(int)$array_host[1],(string)$remediation_service));
			$array_service=mysqli_fetch_row($result);
		} elseif($remediation_service=="Hoststatus") {
			$array_service[0]="Hoststatus";
		}
	}
	
	if(isset($_POST["add"]) || isset($_POST["update"])) {
		if(!$remediation_name || $remediation_name==""){
			message(7," : ".getLabel("message.error.remediation_action_name"),'warning');
		}
		elseif(!$remediation_type || $remediation_type==""){
			message(7," : ".getLabel("message.error.remediation_action_type"),'warning');
		}
		elseif(!$remediation_source || $remediation_source=="" || $remediation_source=="none"){
			message(7," : ".getLabel("message.error.remediation_action_source"),'warning');
		}
		elseif(!$remediation_host || $remediation_host==""){
			message(7," : ".getLabel("message.error.remediation_action_host"),'warning');
		}
		elseif($remediation_host != $array_host[0]){
			message(7," : ".getLabel("message.error.remediation_action_host_name"),'warning');
		}
		elseif(!$remediation_service || $remediation_service==""){
			message(7," : ".getLabel("message.error.remediation_action_service"),'warning');
		}
		elseif($remediation_service != $array_service[0]){
			message(7," : ".getLabel("message.error.remediation_action_service_description"),'warning');
		}
		elseif(isset($_POST["add"])){
			$desciptionExist = sqlrequest($database_eorweb,"SELECT description FROM remediation_action");
			while ($line = mysqli_fetch_array($desciptionExist)){
				if($line[0] == $remediation_name){
					message(7," : ".getLabel("message.error.remediation_action_descr"),'warning');
					$invalid=true;
				}
			}
			
			if(!$invalid){
				// insert values for add
				$sql_add = "INSERT INTO remediation_action (description,type,DateDebut,DateFin,Action,host,service,source) VALUES('".$remediation_name."','".$remediation_type."','".$remediation_dateDebut."','".$remediation_dateFin."', '".$remediation_action."','".$remediation_host."','".$remediation_service."','".$remediation_source."')";
				$remediation_id = sqlrequest($database_eorweb,$sql_add,true);
				
				message(6," : ".getLabel("message.manage_remediation.action_create"),'ok');
			}
		}elseif(isset($_POST["update"])){
			$sql_add = sqlrequest($database_eorweb,"UPDATE remediation_action SET description='".$remediation_name."', type='".$remediation_type."', DateDebut='".$remediation_dateDebut."', DateFin='".$remediation_dateFin."', source='".$remediation_source."', host='".$remediation_host."', service='".$remediation_service."', Action='".$remediation_action."' WHERE id='".$remediation_id."'");
			
			message(6," : ".getLabel("message.manage_remediation.action_update"),'ok');
		}
	}
	
	?>
	<form id="form_user" action='./remediation_action.php' method='POST' name='form_user'>
		<div class="row form-group">
			<label class="col-md-3"><?php echo getLabel("label.manage_remediation.remediation_action_name"); ?></label>
			<div class="col-md-9">
				<input class="form-control hidden" type='text' name='id'  value='<?php if(isset($remediation_id)){echo $remediation_id; }?>'>
				<input class="form-control" type='text' name='name'  value='<?php echo $remediation_name?>' maxlength="50">
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-3"><?php echo getLabel("label.manage_remediation.remediation_action.source"); ?></label>
			<div class="col-md-9">
				<select class="form-control" id='source' name='source' size=1>
					<?php
						$request="SELECT distinct thruk_idx,nick_name FROM bp_sources";
						$result=sqlrequest($database_vanillabp,$request);
						
						echo "<option value='none'>".getLabel("label.manage_remediation.remediation_action.source_select")."</option>";
						
						while ($line = mysqli_fetch_array($result)){
							if($line[0] != "NR"){
								if(isset($remediation_source) && $remediation_source == $line[0]){
									echo "<option value='$line[0]' SELECTED>$line[1]</option>";
								}else{
									echo "<option value='$line[0]'>$line[1]</option>";
								}
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-3"><?php echo getLabel("label.host"); ?></label>
			<div class="col-md-9">
				<input class="form-control" type='text' id='host' name='host' value='<?php echo $remediation_host?>'>
			</div>
		</div>
		<div class="row form-group">
			<label class="col-md-3"><?php echo getLabel("label.service"); ?></label>
			<div class="col-md-9">
				<input class="form-control" type='text' id='service' name='service' value='<?php echo $remediation_service?>'>
			</div>
		</div>
		
		<div class="row form-group">
			<label class="col-md-3"><?php echo getLabel("label.manage_remediation.type"); ?></label>
			<div class="col-md-9">
				<select class="form-control" name='type' size=1>
					<?php
						if ($remediation_type == "incident"){
							echo "<option value='maintenance'>".getLabel("label.manage_remediation.remediation_action.downtime")."</option>";
							echo "<option value='incident' SELECTED>".getLabel("label.manage_remediation.remediation_action.incident")."</option>";
						} else {
							echo "<option value='maintenance' SELECTED>".getLabel("label.manage_remediation.remediation_action.downtime")."</option>";
							echo "<option value='incident'>".getLabel("label.manage_remediation.remediation_action.incident")."</option>";
						}
					?>
				</select>
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-3"><?php echo getLabel("label.manage_remediation.action"); ?></label>
			<div class="col-md-9">
				<select class="form-control" name='action' size=1>
					<?php
						if ($remediation_action == "delete"){
							echo "<option value='add'>".getLabel("action.add")."</option>";
							echo "<option value='delete' SELECTED>".getLabel("label.manage_remediation.remediation_action.remove")."</option>";
						} else {
							echo "<option value='add' SELECTED>".getLabel("action.add")."</option>";
							echo "<option value='delete'>".getLabel("label.manage_remediation.remediation_action.remove")."</option>";
						}
					?>
				</select>
			</div>
		</div>

		<div class="row form-group">
			<label class="col-md-3"><?php echo getLabel("label.kettle_apps.time_period_select"); ?></label>
			<div class="col-md-9">
				<div class="input-group input-validity-date">
					<input type="text" class="form-control" readonly id="validity_date">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
					<input id="datepickerStart" name="start" type="hidden" value='<?php echo $remediation_dateDebut?>'>
					<input id="datepickerEnd" name="end" type="hidden" value='<?php echo $remediation_dateFin?>'>
				</div>
			</div>
		</div>

		<div class="form-group">
			<?php
				if (isset($remediation_id) && $remediation_id != null) {
					if(isset($remediation_statut)){
						if($remediation_statut == "executed" || $remediation_statut == "approved" || $remediation_statut == "waiting") {
							echo "<input disabled class='btn btn-primary' type='submit' name='update' value=".getLabel('action.update').">";
						}else{
							echo "<input class='btn btn-primary' type='submit' name='update' value=".getLabel('action.update').">";
						}
					}else{
						echo "<input class='btn btn-primary' type='submit' name='update' value=".getLabel('action.update').">";
					}
				}else{
					echo "<button class='btn btn-primary' type='submit' name='add' value='add'>".getLabel("action.add")."</button>";
				}
				echo "<button class='btn btn-default' style='margin-left: 10px;' type='button' name='back' value='back' onclick='location.href=\"index.php?action=remediation_action\"'>".getLabel("action.cancel")."</button>";
			?>
		</div>
	</form>

</div>

<?php include("../../footer.php"); ?>


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
?>

<script src="/bower_components/jquery-appear/build/jquery.appear.min.js"></script>
<script src="/bower_components/moment/min/moment-with-locales.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="./js/library.js"></script>

<?php
$filejs="./js/".basename($_SERVER['PHP_SELF'],".php").".js";
if(file_exists($filejs)) {?>
<script src="<?php echo $filejs;?>"></script>
<?php } ?>

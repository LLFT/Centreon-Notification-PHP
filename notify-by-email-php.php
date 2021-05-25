#!/usr/bin/php -c /etc/php.ini

/*
###
### Version  Date      Author    Description
###----------------------------------------------
### 1.0      25/05/21  LLFT   1.0 stable release
### Macro-List : https://assets.nagios.com/downloads/nagioscore/docs/nagioscore/3/en/macrolist.html
### Command Notification : 
### $USER1$/mail/notify-by-email-php.php "NOTIFICATIONTYPE=$NOTIFICATIONTYPE$" "HOSTNAME=$HOSTNAME$" "HOSTALIAS=$HOSTALIAS$" "HOSTADDRESS=$HOSTADDRESS$" "HOSTDURATION=$HOSTDURATION$" "HOSTID=$HOSTID$" "HOSTSTATE=$HOSTSTATE$" "HOSTOUTPUT=$HOSTOUTPUT$" "LASTHOSTCHECK=$LASTHOSTCHECK$" "LASTHOSTSTATECHANGE=$LASTHOSTSTATECHANGE$" "LASTSERVICECHECK=$LASTSERVICECHECK$" "LASTSERVICESTATECHANGE=$LASTSERVICESTATECHANGE$" "LONGDATETIME=$LONGDATETIME$" "NOTIFICATIONAUTHOR=$NOTIFICATIONAUTHOR$" "NOTIFICATIONCOMMENT=$NOTIFICATIONCOMMENT$" "SERVICEDESC=$SERVICEDESC$" "SERVICEID=$SERVICEID$" "SERVICEOUTPUT=$SERVICEOUTPUT$" "SERVICESTATE=$SERVICESTATE$" "SERVICEDURATION=$SERVICEDURATION$" "NOTIFICATIONNUMBER=$NOTIFICATIONNUMBER$" "CONTACTEMAIL=$CONTACTEMAIL$"
*/

<?php

	parse_str(implode('&', array_slice($argv, 1)), $_GET);
	
	if (empty($_GET)){
		echo "parameters is null";
		exit(1);
	}
		
//htmlentities()
    $url = "https://YOUR URL CENTREON";
    $from = "YOUR MAIL SENDER";
	$notifType = $_GET['NOTIFICATIONTYPE'];
	$hostName = $_GET['HOSTNAME'];
	$hostAlias = $_GET['HOSTALIAS'];
	$hostAddress = $_GET['HOSTADDRESS'];
	$hostDuration = $_GET['HOSTDURATION'];
	$hostId = $_GET['HOSTID'];
	$hostState = $_GET['HOSTSTATE'];
	$hostOutput = $_GET['HOSTOUTPUT'];	
	$lastHostCheck =  date('m/d/Y H:i:s', $_GET['LASTHOSTCHECK']);
	$lastHostStateChange =  date('m/d/Y H:i:s', $_GET['LASTHOSTSTATECHANGE']);
	$lastServiceCheck = date('m/d/Y H:i:s', $_GET['LASTSERVICECHECK']);
	$lastServiceStateChange = date('m/d/Y H:i:s', $_GET['LASTSERVICESTATECHANGE']);
	$longDateTime = $_GET['LONGDATETIME'];
	$notificationAuthor = $_GET['NOTIFICATIONAUTHOR'];
	$notificationComment = $_GET['NOTIFICATIONCOMMENT'];
	$serviceDesc = $_GET['SERVICEDESC'];
	$serviceId = $_GET['SERVICEID'];
	$serviceOutput = $_GET['SERVICEOUTPUT'];
	$serviceState = $_GET['SERVICESTATE'];	
	$serviceDuration = $_GET['SERVICEDURATION'];	
	$notificationNumber = $_GET['NOTIFICATIONNUMBER'];	
	$contactEmail  = $_GET['CONTACTEMAIL'];
	
	

	switch ($hostState) {
		
		case 'UP': 
			$bgc_hostState="#87bd23";		
		break;
		case 'DOWN': 
			$bgc_hostState="#ed1c24";	
		break;
		case 'UNREACHABLE': 
			$bgc_hostState="#818285";	
		break;
		default : 
			$bgc_hostState="#666666";	
		break;
	}

	switch ($serviceState) {	
		case 'WARNING': 
			$bgc_serviceState="#f48400";		
		break;
		case 'CRITICAL': 
			$bgc_serviceState="#f40000";	
		break;
		case 'OK': 
			$bgc_serviceState="#00b71a";	
		break;
		default : 
			$bgc_serviceState="#666666";	
		break;
	}
	
	switch ($notifType) {	
		case 'PROBLEM': 
			$bgc_notifType="#ffb24e";		
		break;
		case 'RECOVERY': 
			$bgc_notifType="#87bd23";	
		break;
		case 'ACKNOWLEDGEMENT': 
			$bgc_notifType="#edd91c";	
		break;
		default : 
			$bgc_notifType="#666666";	
		break;
	}
	
		$subject = "[CENTREON] $notifType $hostName [$hostState]";
		$body="<html><body>\r\n";
		$body.="<table border=0 width='98%' cellpadding=0 cellspacing=0>\r\n";
		$body.="<tr><td valign='top'>\r\n";
		$body.="<table border=0 cellpadding=0 cellspacing=0 width='98%'>\r\n";
		$body.="<tr bgcolor=$bgc_hostState><td><b>Hostname: </b></td><td><a href='$url/centreon/main.php?p=20202&o=hd&host_name=$hostName'>$hostAlias [$hostState]</a></td></tr>\r\n";
		$body.="<tr bgcolor=#fefefe><td><b>Address: </b></td><td>$hostAddress</td></tr>\r\n";
		$body.="<tr bgcolor=#eeeeee><td><b>Date/Time: </b></td><td>$longDateTime</td></tr>\r\n";
		if ($notificationNumber > 1){
			$body.="<tr bgcolor=#fefefe><td><b>Notification: </b></td><td>$notificationNumber</td></tr>\r\n";
		}
		if (empty($serviceId)) {
			$body.="<tr bgcolor=#fefefe><td><b>Info: </b></td><td><font color=$bgc_hostState>$hostOutput</font></td></tr>\r\n";
			$body.="<tr bgcolor=#eeeeee><td><b>Last host check: </b></td><td>$lastHostCheck</td></tr>\r\n";
			$body.="<tr bgcolor=#fefefe><td><b>Last Host State Change: </b></td><td>$lastHostStateChange</td></tr>\r\n";
		}else{
			$body.="</table>\r\n";
			$body.="</td></tr>\r\n";
			$body.="<tr><td valign='top'>\r\n";
			$body.="<table border=0 cellpadding=0 cellspacing=0 width='88%'>\r\n";
			$body.="<tr bgcolor=$bgc_serviceState><td><b>Service: </b></td><td><a href='$url/centreon/main.php?p=20201&o=svcd&host_name=$hostName&service_description=$serviceDesc'>$serviceDesc [$serviceState]</a></td></tr>\r\n";
			$body.="<tr bgcolor=$bgc_serviceState><td colspan=2 style='text-align:center'><font color=ffffff>Service Summary</font></b></td></tr> \r\n";
			$body.="<tr bgcolor=#fefefe><td><b>Service Output : </b></td><td>$serviceOutput</td></tr>\r\n";
			$body.="<tr bgcolor=#eeeeee><td><b>Last Service Check : </b></td><td>$lastServiceCheck</td></tr>\r\n";
			$body.="<tr bgcolor=#fefefe><td><b>Last State Change : </b></td><td>$lastServiceStateChange</td></tr>\r\n";
			if ($serviceState != 'OK'){
				$body.="<tr bgcolor=#eeeeee><td><b>Service Duration: </b></td><td>$serviceDuration</td></tr>\r\n";
			}	
		}
		
		if($notifType == 'PROBLEM'){
			if (empty($serviceId)) {
				$body.="<tr bgcolor=$bgc_hostState><td><b>Actions: </b></td><td><a href='$url/centreon/main.php?p=20202&o=hak&cmd=14&host_name=$hostName&en=1'>Acknowledge</a></td></tr>\r\n";
			}else{
				$body.="<tr bgcolor=$bgc_serviceState><td><b>Actions: </b></td><td><a href='$url/centreon/main.php?p=20201&o=svcak&cmd=15&host_name=$hostName&service_description=$serviceDesc&en=1'>Acknowledge</a></td></tr>\r\n";
			}
		}
		if($notifType == 'ACKNOWLEDGEMENT'){
			$body.="<tr bgcolor=$bgc_notifType><td width='140'><b>Comment :</font></b></td><b>$notificationComment</b> by $notificationAuthor </td></tr>\r\n";
		}
		$body.="</table>\r\n";
		$body.="</td></tr>\r\n";
		$body.="</table>\r\n";
		$body.="</body></html>\r\n";	

        $headers = "From: $from\r\n";
        $headers = $headers."Content-type: text/html\r\n";        
        /* Send eMail Now... */
        mail($contactEmail, $subject, $body, $headers);

?>

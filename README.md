# Centreon-Notification-PHP
Centreon-Notification-PHP is a script for generating Centreon issuez notifications in a more colorful and readable HTML format. 

It is based on Macros available under the URL: https://assets.nagios.com/downloads/nagioscore/docs/nagioscore/3/en/macrolist.html#hoststate

The basic idea is inspired by the script of Shini31 https://github.com/Shini31/centreon-notifications

## Requirement:
_ Server PHP 7 or older installed on your Poller

## SETUP

### On your Server 
* Copy the script to __/usr/lib64/nagios/plugins/mail/__
* Edit the script __/usr/lib64/nagios/plugins/mail/notify-by-email-php.php__ for complete the __$url__ and __$from__ parameters
* __Make the file executable__

### On Centreon 
* create a notification command named: __notify-by-email-php__
* Fill in the command line field with this: 
> $USER1$/mail/notify-by-email-php.php "NOTIFICATIONTYPE=$NOTIFICATIONTYPE$" "HOSTNAME=$HOSTNAME$" "HOSTALIAS=$HOSTALIAS$" "HOSTADDRESS=$HOSTADDRESS$" "HOSTDURATION=$HOSTDURATION$" "HOSTID=$HOSTID$" "HOSTSTATE=$HOSTSTATE$" "HOSTOUTPUT=$HOSTOUTPUT$" "LASTHOSTCHECK=$LASTHOSTCHECK$" "LASTHOSTSTATECHANGE=$LASTHOSTSTATECHANGE$" "LASTSERVICECHECK=$LASTSERVICECHECK$" "LASTSERVICESTATECHANGE=$LASTSERVICESTATECHANGE$" "LONGDATETIME=$LONGDATETIME$" "NOTIFICATIONAUTHOR=$NOTIFICATIONAUTHOR$" "NOTIFICATIONCOMMENT=$NOTIFICATIONCOMMENT$" "SERVICEDESC=$SERVICEDESC$" "SERVICEID=$SERVICEID$" "SERVICEOUTPUT=$SERVICEOUTPUT$" "SERVICESTATE=$SERVICESTATE$" "SERVICEDURATION=$SERVICEDURATION$" "NOTIFICATIONNUMBER=$NOTIFICATIONNUMBER$" "CONTACTEMAIL=$CONTACTEMAIL$"

* Activate the Shell and Save
* Then you just have to create a contact template that points to the new notification.
* To finish by generating the files that are going well

## TEST

* If you want to test sending mail from your server

>  php -f mail/notify-by-email-php.php "NOTIFICATIONTYPE=PROBLEM" "HOSTNAME=HOSTNAME" "HOSTALIAS=HOSTALIAS" "HOSTADDRESS=HOSTADDRESS" "HOSTDURATION=HOSTDURATION" "HOSTID=HOSTID" "HOSTSTATE=HOSTSTATE" "HOSTOUTPUT=HOSTOUTPUT" "LASTHOSTCHECK=1616083992" "LASTHOSTSTATECHANGE=1616083992" "LASTSERVICECHECK=1616083992" "LASTSERVICESTATECHANGE=1616083992" "LONGDATETIME=LONGDATETIME" "NOTIFICATIONAUTHOR=NOTIFICATIONAUTHOR" "NOTIFICATIONCOMMENT=NOTIFICATIONCOMMENT" "SERVICEDESC=SERVICEDESC" "SERVICEID=SERVICEID" "SERVICEOUTPUT=SERVICEOUTPUT" "SERVICESTATE=SERVICESTATE" "SERVICEDURATION=SERVICEDURATION" "NOTIFICATIONNUMBER=NOTIFICATIONNUMBER" "CONTACTEMAIL=__YOUR-EMAIL-ADDRESS__"


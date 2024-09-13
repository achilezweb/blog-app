<?php
/* phpMyAdmin configuration */

$cfg['LoginCookieValidity'] = 31536000;
// $cfg['AllowArbitraryServer'] = true; //server: mysql
// $cfg['ShowServerInfo'] = true; // Enables server information display, not ready needed

/* First server */
$i = 1;
$cfg['Servers'][$i]['host'] = 'mysql'; // Replace with your MySQL server host
/* Second server */
// $i++;
// $cfg['Servers'][$i]['host'] = 'mysql2'; // Replace with another MySQL server host

/* Set default server */
// $cfg['DefaultServer'] = 1; // Index of the server in the $cfg['Servers'] array


/* Other configurations */

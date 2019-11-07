<?php

  define('DEBUG', true); // set debug to false for production

  define('DB_NAME', 'a'); // database name
  define('DB_USER', 'root'); // database user
  define('DB_PASSWORD', ''); // database password
  define('DB_HOST', '127.0.0.1'); // database host *** use IP address to avoid DNS lookup

/*
  define('DB_NAME', 'fohm2019_lacteos '); // database name
  define('DB_USER', 'fohm2019_lacteos'); // database user
  define('DB_PASSWORD', '*lacteos2019*'); // database password
  define('DB_HOST', 'mysql1006.mochahost.com'); // database host *** use IP address to avoid DNS lookup
*/

  define('DEFAULT_CONTROLLER', 'Home'); // default controller if there isn't one defined in the url
  define('DEFAULT_LAYOUT', 'default'); // if no layout is set in the controller use this layout.

  define('PROOT', '/logistica/'); // set this to '/' for a live server.
  define('MASTER', 'http://192.168.1.21:8080/Intranet/'); // set this to '/' for a live server.
  define('VERSION','0.25'); // release version this can be used to display version or version assets like css and js files useful for fighting cached browser files

  define('SITE_TITLE', 'Logistica - DPJD'); // This will be used if no site title is set
  define('MENU_BRAND', 'Logistica - DPJD'); //This is the Brand text in the menu

  define('CURRENT_USER_SESSION_NAME', '53bd4d25898e76130b97a2a30b3798ce69014d0e'); //session name for logged in user
  define('REMEMBER_ME_COOKIE_NAME', '53bd4d25898e76130b97a2a30b3798ce69014d0e'); // cookie name for logged in user remember me
  define('REMEMBER_ME_COOKIE_EXPIRY', 2592000); // time in seconds for remember me cookie to live (30 days)

  define('ACCESS_RESTRICTED', 'Restricted'); //controller name for the restricted redirect

  define('CONEXIONES',
  [
    'MySql'  =>[
      'driver'=>'mysql',
      //'server'=>'192.168.1.21',
      'server'=>'127.0.0.1',
      'port'=>3306,
      'db'=>'intranet',
      //'userName'=>'manager',
      'userName'=>'root',
      //'password'=>'VaneSS1109'
      'password'=>''
    ],
    'SqlServer'=>[
      'driver'=>'sqlsrv',
      'server'=>'192.168.1.30\DPJD',
      'userName'=>'sa',
      'password'=>'B1Admin'
    ]
  ]
);
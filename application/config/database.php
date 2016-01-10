<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "default";
$active_record = TRUE;
//正式环境配置
$db['default']['hostname'] = "127.0.0.1";
$db['default']['username'] = "greg";
$db['default']['password'] = "hndxtmx1997";
$db['default']['database'] = "implement";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "imp2016";
$db['default']['pconnect'] = FALSE;//是否使用持续连接（改为否，否则会占用连接资源）
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
//测试环境配置
$db['demo']['hostname'] = "127.0.0.1";
$db['demo']['username'] = "greg";
$db['demo']['password'] = "hndxtmx1997";
$db['demo']['database'] = "implement_demo";
$db['demo']['dbdriver'] = "mysql";
$db['demo']['dbprefix'] = "imp2016";
$db['demo']['pconnect'] = FALSE;//是否使用持续连接（改为否，否则会占用连接资源）
$db['demo']['db_debug'] = TRUE;
$db['demo']['cache_on'] = FALSE;
$db['demo']['cachedir'] = "";
$db['demo']['char_set'] = "utf8";
$db['demo']['dbcollat'] = "utf8_general_ci";
//dflpvmkt-专营店表配置
$db['dflpvmkt']['hostname'] = "127.0.0.1";
$db['dflpvmkt']['username'] = "greg";
$db['dflpvmkt']['password'] = "hndxtmx1997";
$db['dflpvmkt']['database'] = "dflpvmkt";
$db['dflpvmkt']['dbdriver'] = "mysql";
$db['dflpvmkt']['dbprefix'] = "";
$db['dflpvmkt']['pconnect'] = FALSE;//是否使用持续连接（改为否，否则会占用连接资源）
$db['dflpvmkt']['db_debug'] = TRUE;
$db['dflpvmkt']['cache_on'] = FALSE;
$db['dflpvmkt']['cachedir'] = "";
$db['dflpvmkt']['char_set'] = "latin1";
$db['dflpvmkt']['dbcollat'] = "latin1_swedish_ci";
//权限表配置
$db['auth']['hostname'] = "127.0.0.1";
$db['auth']['username'] = "greg";
$db['auth']['password'] = "hndxtmx1997";
$db['auth']['database'] = "NTSDF";
$db['auth']['dbdriver'] = "mysql";
$db['auth']['dbprefix'] = "js_";
$db['auth']['pconnect'] = FALSE;//是否使用持续连接（改为否，否则会占用连接资源）
$db['auth']['db_debug'] = TRUE;
$db['auth']['cache_on'] = FALSE;
$db['auth']['cachedir'] = "";
$db['auth']['char_set'] = "utf8";
$db['auth']['dbcollat'] = "utf8_general_ci";

/* End of file database.php */
/* Location: ./system/application/config/database.php */
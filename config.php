<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
ini_set('display_errors',1);
define(BASE_DIR, __DIR__ . '/');
define(HOST, 'localhost');
define(USER, 'root');
define(PASSWORD, '');
define(DATABASE, 'mongo3');
define(DB_DRIVER, 'pdo_mysql');
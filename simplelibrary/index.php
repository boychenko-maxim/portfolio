<?php

$config=dirname(__FILE__).'/protected/config/main.php';

defined('YII_DEBUG');

// include Yii bootstrap file
require_once(dirname(__FILE__).'/../../framework/yii.php');

// create a Web application instance and run
Yii::createWebApplication($config)->run();
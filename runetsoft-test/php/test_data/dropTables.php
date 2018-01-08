<?php
include('../pdoHelper.php');

prepareAndExecuteSql(getMysqlPDO('../../../databaseSettings.php'),
    "DROP TABLES UsersCities, Cities, Users, Education");

echo "Drop tables successfully!";

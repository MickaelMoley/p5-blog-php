<?php

// cli-config.php
require_once 'app/Application.php';

$app = new \Core\Application();


return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app->processDatabaseManager());

